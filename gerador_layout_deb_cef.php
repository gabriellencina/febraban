<?php 
	namespace febraban;

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include("vendor/autoload.php");
	include('connection.php');

	//Recebendo por parâmetro na url convenio, vencimento, optante e codigo de operação
	$convenio   = $_GET['convenio'];

	$vencimento = date('Y-m-d',strtotime($_GET['data']));

	$optante    = $_GET['optante'];

	$codigo_de_operacao = $_GET['codigo_de_operacao'];

	function clearString($string = "")
	{
		$nova_string = $string;

		if($string) {
			$comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', 'Ãª', 'ª', 'º');
			$semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'E', 'a', 'o');
			$nova_string = str_replace($comAcentos, $semAcentos, $string);
			$nova_string = str_replace($comAcentos, $semAcentos, utf8_encode($nova_string));
		}

		return $nova_string;
	}
	
	if(isset($_GET['convenio']))
	{
		// Busca os dados do convenio
		$sql = "SELECT * , bancos.nome_banco, bancos.codigo_febraban, convenios_debito_em_conta.banco_id
				FROM convenios_debito_em_conta 
				INNER JOIN bancos
				ON bancos.id = convenios_debito_em_conta.banco_id	
				WHERE `cod_convenio` = ".$convenio;
		$res = $connection->query($sql);

		$row 	   = $res->fetch_object();
		$cod_banco = $row->codigo_febraban;
		$convenio  = $row->cod_convenio;	
		$numero_sequencial_arquivo = $row->numero_sequencial_arquivo  + 1;

		switch($cod_banco)
		{
			case 104:
				// Adiciona 1 ao numero sequencial do arquivo e guarda no convenio 
				$sql = "UPDATE `convenios_debito_em_conta` SET `numero_sequencial_arquivo` = $numero_sequencial_arquivo  WHERE `cod_convenio` = ".$convenio;
				$res = $connection->query($sql);

				//REGISTRO A
				$RegistroA = array(); 
				$RegistroA["cod_registro"] 				 	= "A";  
				$RegistroA["cod_remessa"] 				 	= "1";
				$RegistroA["cod_convenio"] 				 	= $convenio;
				$RegistroA["nome_empresa"] 				 	= $row->nome_empresa;
				$RegistroA["cod_banco"] 				 	= $cod_banco;
				$RegistroA["nome_banco"] 				 	= $row->nome_banco; 
				$RegistroA["data_movimento"] 			 	= date('Ymd');
				$RegistroA["numero_sequencial_arquivo"]  	= $numero_sequencial_arquivo;
				$RegistroA["versao_layout"] 			 	= $row->versao_layout;
				$RegistroA["identificacao_servico"] 	 	= $row->identificacao_servico;
				$RegistroA["conta_compromisso"] 		 	= $row->conta_compromisso;
				$RegistroA["id_ambiente_cliente"] 		 	= $row->ambiente_cliente;
				$RegistroA["id_ambiente_caixa"] 		 	= $row->ambiente_banco;
				$RegistroA["reservado_futuro1"] 		 	= " ";
				$RegistroA["numero_sequencial_registro"] 	= $row->numero_registro_a;
				$RegistroA["reservado_futuro2"] 		 	= " ";

				$content  = '';
				$content .= $codigo_de_operacao = $_GET['codigo_de_operacao'] == 1288 ? caixaDebAuto150LayoutNSGD::RegistroA($RegistroA).PHP_EOL : caixaDebAuto150LayoutSidec::RegistroA($RegistroA).PHP_EOL;
		
				
				//REGISTRO E
				// Busca as Parcelas
				$condicao  = $optante == 1 ? "negocio_parcelas.numero_registro_e = 0 AND " : "";
				$condicao2 = $optante == 0 ? "clientes_dados_debito.optante = 0 AND " : "";
				
				$sql = "SELECT clientes.cpf, convenios_debito_em_conta.cod_convenio, forma_pagamento.dias_antecedencia_cobranca_debito, clientes_dados_debito.agencia_bancaria, clientes_dados_debito.optante , clientes_dados_debito.conta_corrente, clientes_dados_debito.cod_operacao, negocio_parcelas.*  
						FROM `negocio_parcelas`
						INNER JOIN negocios ON negocios.id = negocio_id 
						INNER JOIN clientes ON negocios.cliente_id = clientes.id
						INNER JOIN forma_pagamento ON negocios.forma_pagamento = forma_pagamento.id
						INNER JOIN convenios_debito_em_conta ON forma_pagamento.cod_convenio = convenios_debito_em_conta.id
						INNER JOIN clientes_dados_debito ON negocios.conta_debito = clientes_dados_debito.id
						WHERE $condicao $condicao2 negocio_parcelas.vencimento <= '$vencimento'"; 
				$res = $connection->query($sql);
					
				
				// Inicializa variáveis
				$numero_sequencial_registroE = 0;
				$soma_valores = 0;
				
				// Laço de geração dos registros E
				while($row = $res->fetch_object())
				{
					if($codigo_de_operacao = $_GET['codigo_de_operacao'] == 1288 && $row->cod_operacao == 1288 || $codigo_de_operacao = $_GET['codigo_de_operacao'] != 1288 && $row->cod_operacao != 1288)
					{
						// Atualiza o numero do registro E na parcela caso não esteja efetuando o cadastro
						$numero_sequencial_registroE = $numero_sequencial_registroE + 1;

						// Se não for optante gera os valores de débito, se não somente os dados de cadastro
						if($optante == 0){	
							// Verifica se a data de vencimento é menor que a data passada no parâmetro, se sim, atualiza o vencimento para o parametro passado
							if (str_replace('-', '', $row->vencimento) < str_replace('-', '',$vencimento))
							{
								$data_vencimento = str_replace('-', '',$vencimento);
							} else {
								$data_vencimento = str_replace('-', '', $row->vencimento);
							}

							$sql  = "UPDATE `negocio_parcelas` SET `numero_registro_e` = ".$numero_sequencial_registroE.", vencimento = ".$data_vencimento." WHERE `id` = ".$row->id;
							$res2 = $connection->query($sql);

							// Soma e Formata o valor da parcela
							$soma_valores = $soma_valores + $row->total;
							$inteiro      = intval($row->total);
							$centavos     = substr(number_format($row->total, 2, ',', '.'), strpos(number_format($row->total, 2, ',', '.'),',',0)+1, strlen(number_format($row->total, 2, ',', '.')));
							
						} else {
							$data_vencimento = '00000000';
							$soma_valores    = 0;
							$inteiro         = 0;
							$centavos 		 = '00';
						}
						
						// Preenche Array do Registro E
						$RegistroE = array();
						$RegistroE["cod_registro"]       			= "E";
						$RegistroE["id_cliente_empresa"] 			= $row->cpf;
						$RegistroE["agencia_debito"]     			= $row->agencia_bancaria;
						$RegistroE["codigo_operacao"]    			= intval($row->cod_operacao);
						$RegistroE["id_cliente_banco"]   			= intval($row->conta_corrente);
						$RegistroE["data_vencimento"]    			= $data_vencimento;
						$RegistroE["valor_debito"]       			= $inteiro.$centavos;
						$RegistroE["codigo_moeda"]       			= "03";
						$RegistroE["uso_empresa"]        			= " ";
						$RegistroE["numero_agendamento_cliente"] 	=  0; //intval($row->numero_agendamento_cliente);
						$RegistroE["reservado_futuroE"] 			= "";
						$RegistroE["numero_sequencial_registro"] 	= $numero_sequencial_registroE;
						$RegistroE["codigo_movimento"] 				= 5;
						
						$content .= $codigo_de_operacao = $_GET['codigo_de_operacao'] == 1288 ? caixaDebAuto150LayoutNSGD::RegistroE($RegistroE).PHP_EOL : caixaDebAuto150LayoutSidec::RegistroE($RegistroE).PHP_EOL;
					}
				}
				
					// Registro Z, confere a somatoria dos Registros E
					$RegistroZ = array();
					$inteiro 										= intval($soma_valores);
					$centavos 										= substr(number_format($soma_valores, 2, ',', '.'), strpos(number_format($soma_valores, 2, ',', '.'),',',0)+1, strlen(number_format($soma_valores, 2, ',', '.')));
					$RegistroZ["cod_registro"] 						= "Z";
					$RegistroZ["total_registros_arquivo"] 			= $numero_sequencial_registroE + 2;
					$RegistroZ["valor_total_registro_arquivo"]  	= $inteiro.$centavos;
					$RegistroZ["reservado_futuroZ1"] 				= " ";
					$RegistroZ["numero_sequencial_registro"] 		= $numero_sequencial_registroE + 2;
					$RegistroZ["reservado_futuroZ2"] 				= " ";

					$content .= $codigo_de_operacao = $_GET['codigo_de_operacao'] == 1288 ? caixaDebAuto150LayoutNSGD::RegistroZ($RegistroZ).PHP_EOL : caixaDebAuto150LayoutSidec::RegistroZ($RegistroZ).PHP_EOL;
					
					//Cria o arquivo
					$nome_arquivo = "DEB_".$cod_banco."_".$convenio."_".date('ymd')."_".str_pad($numero_sequencial_arquivo, 5 , '0' , STR_PAD_LEFT).".REM";
					$fp = fopen($_SERVER['DOCUMENT_ROOT'] ."/$nome_arquivo","wb");
					fwrite($fp,$content);
					fclose($fp);

					header("Location: index_cef.php");

					break;

				default:
					echo 'Layout não encontrado';
					break;
			}

			// Insere dados do arquivo debito em conta
			$sql = "INSERT INTO arquivos_debito_conta (nome_arquivo, tipo_arquivo, data_criacao, convenio, numero_registros, registros_falha, arquivo_optante, numero_arquivo) 
					VALUES ('$nome_arquivo', 'REM', date('Y-m-d'), $convenio, $numero_sequencial_registroE, 0, $optante, $numero_sequencial_arquivo)";
			$res = $connection->query($sql);

		}
?>
