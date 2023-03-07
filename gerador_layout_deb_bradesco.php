<?php

namespace febraban;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("vendor/autoload.php");
include('connection.php');

// Recebendo por parâmetro de url o cod do convenio e data de vencimento
$convenio   = $_GET['convenio'];

$vencimento = date('Y-m-d', strtotime($_GET['data']));

$vendedor 	= $_GET['vendedor'];

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
	$sql = "SELECT * , bancos.nome_banco, bancos.codigo_febraban, convenios_debito_em_conta.banco_id, convenios_debito_em_conta.id
            FROM convenios_debito_em_conta 
            INNER JOIN bancos
            ON bancos.id = convenios_debito_em_conta.banco_id	
            WHERE `cod_convenio` = " . $convenio;
	$res = $connection->query($sql);
	$row = $res->fetch_object();

	// Inicializa variáveis
	$Registro0 					= array();
	$Registro1                  = array();
	$Registro6                  = array();
	$Registro9 					= array();
	$soma_valores               = 0;
	$agencia                    = $row->agencia;
	$conta                      = substr($row->conta_compromisso, 0, -1);
	$digito_conta               = substr($row->conta_compromisso, -1);
	$contador_registros         = 2;
	$cod_banco                  = $row->codigo_febraban;
	$convenio                   = $row->cod_convenio;
	$numero_sequencial_arquivo  = $row->numero_sequencial_arquivo  + 1;

	switch ($cod_banco) {
		case 237:
			
			// Adiciona 1 ao numero sequencial do arquivo e guarda convenios_debito_em_conta
			$sql = "UPDATE `convenios_debito_em_conta` SET `numero_sequencial_arquivo` = $numero_sequencial_arquivo  WHERE `cod_convenio` = " . $convenio;
			$res2 = $connection->query($sql);

			// REGISTRO 0
			$Registro0["cod_registro0"]                                 = 0;
			$Registro0["cod_remessa"]                                   = 1;
			$Registro0["literal_remessa"]                               = "REMESSA";
			$Registro0["cod_servico"]                                   = 1;
			$Registro0["literal_servico"]                               = "COBRANCA";
			$Registro0["cod_empresa"]                                   = $row->cod_convenio;
			$Registro0["nome_empresa"]                                  = $row->nome_empresa;
			$Registro0["num_bradesco_camara_compensacao"]               = 237;
			$Registro0["nome_banco_extenso"]                            = "BRADESCO";
			$Registro0["data_gravacao_arquivo"]                         = date('dmy');
			$Registro0["reservado_futuro"]                              = " ";
			$Registro0["id_sistema"]                                    = "MX";
			$Registro0["numero_sequencial_arquivo"]                     = $numero_sequencial_arquivo;
			$Registro0["reservado_futuro2"]                             = " ";
			$Registro0["numero_sequencial_registro"]                    = $row->numero_registro_a;
			
			$content  = '';	

			$content .= bradescoDebAuto400LayoutCNAB::Registro0($Registro0).PHP_EOL;

			$condicao = !empty($vendedor) ? "AND N.vendedor_id = $vendedor" :  " ";

			// Busca as parcelas
			$sql = "SELECT	negocio_parcelas.id as parcela,
							negocio_parcelas.negocio_id,
							negocio_parcelas.documento, 
							negocio_parcelas.vencimento,   
							negocio_parcelas.valor,   
							negocio_parcelas.data_pagamento,  
							negocio_parcelas.multa,  
							negocio_parcelas.juros,
							negocio_parcelas.total, 
							negocio_parcelas.pagamento_parcelas,
							negocio_parcelas.cod_retorno,  
							negocio_parcelas.cod_retorno1,  
							negocio_parcelas.cod_retorno2,  
							negocio_parcelas.cod_retorno3,
							negocio_parcelas.cod_retorno4,
							negocio_parcelas.cod_retorno5,  
							negocio_parcelas.numero_parcela,   
							negocio_parcelas.numero_sequencial_arquivo_debito,
							negocio_parcelas.numero_registro_e,  
							negocio_parcelas.numero_agendamento_cliente,
							negocio_parcelas.vencimento_original,
							negocio_parcelas.valor_tarifa,
							negocio_parcelas.status,
							C.id,
							C.endereco,
							C.numero_endereco,
							C.complemento_endereco,
							C.bairro,
							C.nome,
							C.sobrenome,
							C.cpf,
							C.cep,
							C.cidade,  
							T.nome_cidade,
							U.nome_uf,
							V.cod_convenio,
							F.dias_antecedencia_cobranca_debito,
							D.agencia_bancaria,
							D.conta_corrente,
							V.mensagem_cliente,
							V.codigo_carteira,
							N.vendedor_id
					FROM negocio_parcelas
					INNER JOIN negocios as N ON N.id = negocio_id
					INNER JOIN clientes as C ON N.cliente_id = C.id
					INNER JOIN clientes_dados_debito as D ON N.conta_debito = D.id
					LEFT JOIN cidades as T ON T.id = C.cidade
					LEFT JOIN ufs as U ON U.id = T.uf_cidade
					INNER JOIN forma_pagamento as F ON N.forma_pagamento = F.id
					INNER JOIN convenios_debito_em_conta as V ON F.cod_convenio = V.id
					WHERE negocio_parcelas.numero_registro_e = 0 AND negocio_parcelas.vencimento <= '$vencimento' 
																 AND V.cod_convenio = $convenio 
																 AND negocio_parcelas.status = 1 
																 $condicao";

			$res3 = $connection->query($sql);
			
			$nome_arquivo_debito_conta = "CB" . date('dm') . str_pad($numero_sequencial_arquivo, 2, '0', STR_PAD_LEFT) . ".REM";
			
			$data_geracao_atual = date('Y-m-d');
		
			// Insere os dados do nosso arquivo na tabela arquivos debito conta
			$sql = "INSERT INTO arquivos_debito_conta (nome_arquivo, tipo_arquivo, data_criacao, convenio, numero_registros, arquivo_optante, numero_arquivo)
					VALUES('$nome_arquivo_debito_conta', 'REM', '$data_geracao_atual', $convenio, $contador_registros, 0, $numero_sequencial_arquivo)";
			$res4 = $connection->query($sql);
		
			// Busca o id com base no nome do aquivo, data criação e convenio 
			$sql = "SELECT id FROM arquivos_debito_conta WHERE nome_arquivo = '$nome_arquivo_debito_conta' AND data_criacao = '$data_geracao_atual' AND convenio = '$convenio'";
			$res5 = $connection->query($sql);
			$row5 = $res5->fetch_object();

			while($row2 = $res3->fetch_object())
			{
				// $converte_cep   = intval($row2->cep);
				$reg_vencimento = str_replace('-', '', $row2->vencimento);

				$reg_venci = str_replace('-', '', $vencimento);

				// Verifica se a data de vencimento é menor que a data passada no parâmetro, se sim, atualiza o vencimento para o parametro passado
				if ($reg_vencimento < $reg_venci) {

					$data_vencimento = str_replace('-', '', $vencimento);

				} else {

					$data_vencimento = str_replace('-', '', $row2->vencimento);
					
				}

				$sql  = "UPDATE `negocio_parcelas` SET `numero_registro_e` = " . $contador_registros . ",`numero_sequencial_arquivo_debito` = " . $numero_sequencial_arquivo . " WHERE `id` = " . $row2->parcela;
				$res6 = $connection->query($sql);

				// Soma e Formata o valor da parcela
				$soma_valores = $soma_valores + $row2->total;
				$inteiro      = intval($row2->total);
				$centavos     = substr(number_format($row2->total, 2, ',', '.'), strpos(number_format($row2->total, 2, ',', '.'), ',', 0) + 1, strlen(number_format($row2->total, 2, ',', '.')));

				$formata_vencimento = date('dmy', strtotime($row2->vencimento));

				$limpa_campo_conta_corrente =   [
													'A', 'a', 'B', 'b', 'C', 'c',
													'D', 'd', 'E', 'e', 'F', 'f',
													'G', 'g', 'H', 'h', 'I', 'i',
													'J', 'j', 'K', 'k', 'L', 'l',
													'M', 'm', 'N', 'n', 'O', 'o',
													'P', 'p', 'Q', 'q', 'R', 'r',
													'S', 's', 'T', 't', 'U', 'u',
													'V', 'v', 'W', 'w', 'X', 'x',
													'Y', 'y', 'Z', 'z'
												];
                 
				$Registro1["cod_registro1"]                         = 1;
				$Registro1["agencia_debito"]                        = intval(str_replace(" ", "", $row2->agencia_bancaria));
				$Registro1["razao_conta_corrente"]                  = 0;
				$Registro1["conta_corrente"]                        = intval(str_replace($limpa_campo_conta_corrente, 0, $row2->conta_corrente));
				$Registro1["zero"]                                  = 0;
				$Registro1["carteira"]                              = $row2->codigo_carteira;
				$Registro1["agencia"]                               = $agencia;
				$Registro1["conta"]                                 = $conta;
				$Registro1["digito_conta"]                          = $digito_conta;
				$Registro1["num_controle_participante"]             = '-' . $row2->parcela;
				$Registro1["cod_banco_deb_camara_compensacao"]      = 237;
				$Registro1["campo_multa"]                           = 0;
				$Registro1["percentual_multa"]                      = 0;
				$Registro1["id_titulo_banco"]                       = intval($row2->documento);
				$Registro1["desconto_bonificacao_dia"]              = 0;
				$Registro1["condicao_emissao_papeleta_cobranca"]    = 1;
				$Registro1["ident_emite_boleto_deb_auto"]           = "N";
				$Registro1["id_operacao_banco"]                     = " ";
				$Registro1["id_rateio_credito"]                     = " ";
				$Registro1["enderacamento_aviso_deb_auto"]          = 2;
				$Registro1["quantidade_pagamentos"]                 = " ";
				$Registro1["id_ocorrencia"]                         = 1;
				$Registro1["num_documento"]                         = " ";
				$Registro1["data_vencimento_titulo"]                = $formata_vencimento;
				$Registro1["valor_titulo"]                          = $inteiro . $centavos;
				$Registro1["banco_encarregado_cobranca"]            = 0;
				$Registro1["agencia_depositaria"]                   = 0;
				$Registro1["especie_titulo"]                        = 99;
				$Registro1["identificacao"]                         = "N";
				$Registro1["data_emissao_titulo"]                   = date('dmy');
				$Registro1["instrucao1"]                            = 0;
				$Registro1["instrucao2"]                            = 0;
				$Registro1["valor_cobrado_dia_atraso"]              = 0;
				$Registro1["data_limite_concessao_desconto"]        = 0;
				$Registro1["valor_desconto"]                        = 0;
				$Registro1["valor_iof"]                             = 0;
				$Registro1["valor_abatimento"]                      = 0;
				$Registro1["id_tipo_inscricao_pagador"]             = 01;
				$Registro1["num_inscricao_pagador"]                 = 00001 . $row2->cpf;
				$Registro1["nome_pagador"]                          = clearString(trim($row2->nome)) . ' ' . clearString(trim($row2->sobrenome));
				$Registro1["endereco_completo"]                     = clearString($row2->endereco) . '-' . clearString($row2->numero_endereco) . '-' . clearString($row2->complemento_endereco) . '-' . clearString($row2->bairro) . '-' . clearString($row2->nome_cidade) . '-' . clearString($row2->nome_uf);
				$Registro1["mensagem1"]                             = $row2->mensagem_cliente;
				$Registro1["cep"]                                   = 90470130;
				$Registro1["mensagem2"]                             = " ";
				$Registro1["numero_sequencial_registro2"]           = $contador_registros;

				$contador_registros += 1;

				$content .= bradescoDebAuto400LayoutCNAB::Registro1($Registro1) . PHP_EOL;

				$Registro6["cod_registro6"]                         = 6;
				$Registro6["carteira"]                              = $row->codigo_carteira;
				$Registro6["agencia_debito"]                        = $agencia;
				$Registro6["conta_corrente2"]                       = $conta;
				$Registro6["numero_bradesco"]                       = 0;
				$Registro6["digito_numero_bradesco"]                = 0;
				$Registro6["tipo_operacao"]                         = 3;
				$Registro6["utilizacao_cheque_especial"]            = "N";
				$Registro6["consulta_saldo_apos_vencimento"]        = "S";
				$Registro6["num_cod_id_contrato"]                   = $row2->negocio_id;
				$Registro6["prazo_validade_contrato"]               = 999999999;
				$Registro6["reservado_futuro_6"]                    = " ";
				$Registro6["numero_sequencial_registro3"]           = $contador_registros;

				$contador_registros += 1;

				$content .= bradescoDebAuto400LayoutCNAB::Registro6($Registro6) . PHP_EOL;
										
				$sql = "INSERT INTO arquivos_debito_conta_retornos (data_ocorrencia, arquivo_debito_conta_id, negocio_parcela_id, registro, agencia, conta, cliente_id, status, cod_convenio, banco)
						VALUES('$data_geracao_atual', $row5->id, $row2->parcela, $contador_registros, '$row2->agencia_bancaria', '$row2->conta_corrente', $row2->id, $row2->status, $row->id, $row->banco_id)";
				$res7 = $connection->query($sql);
				
			}

			// atualiza meu numero de registros na tabela arquivos debito conta
			$sql = "UPDATE arquivos_debito_conta SET numero_registros = '$contador_registros' WHERE nome_arquivo = '$nome_arquivo_debito_conta' 
					AND data_criacao = '$data_geracao_atual' AND convenio = '$convenio'";
			$res8 = $connection->query($sql);
			
			$Registro9["cod_registro9"]                = 9;
			$Registro9["reservado_futuro_9"]           = " ";
			$Registro9["numero_sequencial_registro3"]  = $contador_registros;

			$content .= bradescoDebAuto400LayoutCNAB::Registro9($Registro9) . PHP_EOL;

			// Gera arquivo de débito automático com os dados e logo após salva  
			$nome_arquivo = "CB" . date('dm') . str_pad($numero_sequencial_arquivo, 2, '0', STR_PAD_LEFT) . ".REM";
			$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/$nome_arquivo", "wb");
			fwrite($fp, $content);
			fclose($fp);

			header("Location: index_bradesco.php");

			break;

		default:
			echo 'Layout não encontrado';
			break;
	}
}