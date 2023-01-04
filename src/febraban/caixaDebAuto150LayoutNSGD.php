<?php

namespace febraban;
class caixaDebAuto150LayoutNSGD{

	public static function Arquivo($cfg)
	{
		$salvar_remessa_em   = isset($cfg['salvar_remessa_em']) ? $cfg['salvar_remessa_em'] :' ';
		$nome_aquivo_remessa = isset($cfg['nome_aquivo_remessa']) ? $cfg['nome_aquivo_remessa'] : Date('dmY');
	}

	
	public static function RegistroA($cfg)
	{

		$cod_registro 						   = isset($cfg['cod_registro']) ? $cfg['cod_registro'] :' ';
		$cod_remessa  						   = isset($cfg['cod_remessa']) ? $cfg['cod_remessa'] : 0;
		$cod_convenio 						   = isset($cfg['cod_convenio']) ? $cfg['cod_convenio'] :' ';
		$nome_empresa 						   = isset($cfg['nome_empresa']) ? $cfg['nome_empresa'] :'';
		$cod_banco    						   = isset($cfg['cod_banco']) ? $cfg['cod_banco'] :'';
		$nome_banco   						   = isset($cfg['nome_banco']) ? $cfg['nome_banco'] :'';
		$data_movimento 					   = isset($cfg['data_movimento']) ? $cfg ['data_movimento'] :'';
		$numero_sequencial_arquivo 			   = isset($cfg['numero_sequencial_arquivo']) ? $cfg['numero_sequencial_arquivo'] :'';
		$versao_layout 					       = isset($cfg['versao_layout']) ? $cfg['versao_layout'] :'';
		$identificacao_servico 			       = isset($cfg['identificacao_servico']) ? $cfg['identificacao_servico'] :'';
		$conta_compromisso 				       = isset($cfg['conta_compromisso']) ? $cfg['conta_compromisso'] :'';
		$id_ambiente_cliente 			       = isset($cfg['id_ambiente_cliente']) ? $cfg['id_ambiente_cliente'] :'';
		$id_ambiente_caixa 				       = isset($cfg['id_ambiente_caixa']) ? $cfg['id_ambiente_caixa'] :'';
		$reservado_futuro1 				       = isset($cfg['reservado_futuro1']) ? $cfg['reservado_futuro1'] :'';
		$numero_sequencial_registro 		   = isset($cfg['numero_sequencial_registro']) ? $cfg['numero_sequencial_registro'] :'';
		$reservado_futuro2 					   = isset($cfg['reservado_futuro2']) ? $cfg['reservado_futuro2'] :'';
		
		$campos								   = array();
		$campos['cod_registro'] 		       = array(1,1,'X:1',$cod_registro);
		$campos['cod_remessa']       	       = array(2,2,'9:1',$cod_remessa);
		$campos['cod_convenio']			       = array(3,22,'X:20',$cod_convenio);
		$campos['nome_empresa']				   = array(23,42,'X:20',$nome_empresa);
		$campos['cod_banco']				   = array(43,45,'9:3',$cod_banco);
		$campos['nome_banco']				   = array(46,65,'X:20',$nome_banco);
		$campos['data_movimento']   		   = array(66,73,'9:8',$data_movimento);
		$campos['numero_sequencial_arquivo']   = array(74,79,'9:6',$numero_sequencial_arquivo);
		$campos['versao_layout'] 	           = array(80,81,'9:2',$versao_layout);
		$campos['identificacao_servico']       = array(82,98,'X:17',$identificacao_servico);
		$campos['conta_compromisso']           = array(99,114,'9:16',$conta_compromisso);
		$campos['id_ambiente_cliente']         = array(115,115,'X:1',$id_ambiente_cliente);
		$campos['id_ambiente_caixa']           = array(116,116,'X:1',$id_ambiente_caixa);
		$campos['reservado_futuro1']	       = array(117,143,'X:27',$reservado_futuro1);
		$campos['numero_sequencial_registro']  = array(144,149,'9:6',$numero_sequencial_registro);
		$campos['reservado_futuro2']           = array(150,150,'X:1',$reservado_futuro2);

		return caixaDebAuto150LayoutNSGD::FormatarCampos($campos);

	}


	public static function RegistroE($cfg)
	{

		$cod_registro 					       = isset($cfg['cod_registro']) ? $cfg['cod_registro'] :' ';
		$id_cliente_empresa 				   = isset($cfg['id_cliente_empresa']) ? $cfg['id_cliente_empresa'] :' ';
		$agencia_debito 					   = isset($cfg['agencia_debito']) ? $cfg['agencia_debito'] :' ';
        $brancos 							   = isset($cfg['brancos']) ? $cfg['brancos']: '';
		$id_cliente_banco 					   = isset($cfg['id_cliente_banco']) ? $cfg['id_cliente_banco'] :' ';
		$data_vencimento				       = isset($cfg['data_vencimento']) ? $cfg['data_vencimento'] :' ';
		$valor_debito 						   = isset($cfg['valor_debito']) ? $cfg['valor_debito'] :' ';
		$codigo_moeda   					   = isset($cfg['codigo_moeda']) ? $cfg['codigo_moeda'] :' ';
		$uso_empresa 			  			   = isset($cfg['uso_empresa']) ? $cfg['uso_empresa'] :' ';
		$numero_agendamento_cliente 	       = isset($cfg['numero_agendamento_cliente']) ? $cfg['numero_agendamento_cliente'] :'';
		$reservado_futuroE 					   = isset($cfg['reservado_futuroE']) ? $cfg['reservado_futuroE'] :' ';
		$numero_sequencial_registro 		   = isset($cfg['numero_sequencial_registro']) ? $cfg['numero_sequencial_registro'] :'';
		$codigo_movimento 	  				   = isset($cfg['codigo_movimento']) ? $cfg['codigo_movimento'] :' ';

		$campos 							   = array();
		$campos['cod_registro'] 			   = array(1,1,'X:1',$cod_registro);
		$campos['id_cliente_empresa'] 		   = array(2,26,'X:25',$id_cliente_empresa);
		$campos['agencia_debito'] 	  		   = array(27,30,'9:4',$agencia_debito);
		$campos['id_cliente_banco'] 		   = array(31,42,'9:12',$id_cliente_banco);
        $campos['brancos'] 					   = array(43,44, 'X:2', $brancos);
		$campos['data_vencimento'] 			   = array(45,52,'9:8',$data_vencimento);
		$campos['valor_debito'] 			   = array(53,67,'9:15',$valor_debito);
		$campos['codigo_moeda'] 			   = array(68,69,'X:2',$codigo_moeda);
		$campos['uso_empresa'] 			       = array(70,129,'X:60',$uso_empresa);
		$campos['numero_agendamento_cliente']  = array(130,135,'9:6',$numero_agendamento_cliente);
		$campos['reservado_futuroE'] 		   = array(136,143,'X:8',$reservado_futuroE);
		$campos['numero_sequencial_registro']  = array(144,149,'9:6',$numero_sequencial_registro);
		$campos['codigo_movimento'] 		   =  array(150,150,'9:1',$codigo_movimento);

		return caixaDebAuto150LayoutNSGD::FormatarCampos($campos);

	 }


	public static function RegistroZ($cfg)
	{

	 	$cod_registro 						    = isset($cfg['cod_registro']) ? $cfg['cod_registro'] :' ';
	 	$total_registros_arquivo 			    = isset($cfg['total_registros_arquivo']) ? $cfg['total_registros_arquivo'] :' ';
	 	$valor_total_registro_arquivo 		    = isset($cfg['valor_total_registro_arquivo']) ? $cfg['valor_total_registro_arquivo'] :' ';
	 	$reservado_futuroZ1 				    = isset($cfg['reservado_futuroZ1']) ? $cfg['reservado_futuroZ1'] :' ';
	 	$numero_sequencial_registro 		    = isset($cfg['numero_sequencial_registro']) ? $cfg['numero_sequencial_registro'] :' ';
	 	$reservado_futuroZ2 				 	= isset($cfg['reservado_futuroZ2']) ? $cfg['reservado_futuroZ2'] :' ';

	 	$campos = array();
	 	$campos['cod_registro'] 			    = array(1,1,'X:1',$cod_registro);
	 	$campos['total_registros_arquivo'] 	    = array(2,7,'9:6',$total_registros_arquivo);
	 	$campos['valor_total_registro_arquivo'] = array(8,24,'9:17',$valor_total_registro_arquivo);
	 	$campos['reservado_futuroZ1'] 			= array(25,143,'X:119',$reservado_futuroZ1);
	 	$campos['numero_sequencial_registro']   = array(144,149,'9:6',$numero_sequencial_registro);
	 	$campos['reservado_futuroZ2']           = array(150,150,'X:1',$reservado_futuroZ2);

	 	return caixaDebAuto150LayoutNSGD::FormatarCampos($campos);

	 }


	public static function FormatarCampos($campos)
	{

		$RegistroA      = ''; //String do Registro A
		$permiteBrancos = array('reservado_futuro','uso_empresa'); //Campos que podem ser vazios

		foreach($campos as $index=>$value){
			
			$strInicio    = isset($value[0]) ? $value[0] : 1; 
			$strFim       = isset($value[1]) ? $value[1] : 1; 			
			$strValidacao = isset($value[2]) ? $value[2] : 'X:1';
			$strV         = isset($value[3]) ? $value[3] : '';
			$strValor     = caixaDebAuto150LayoutNSGD::clearString($strV);

			$x = explode(':',$strValidacao); //Identifica tipo de validação x ou 9

			$validacao = isset($x[0]) ? $x[0] : 'X';
			$tamanho   = isset($x[1]) ? $x[1] : 1;

			if(!in_array($index,$permiteBrancos)&&$strValor===NULL)
			{
				
				die('O campo '.$index.' ('.$strValidacao.') não pode estar em branco! {'.$strValor.'}');
			
			} else {

				if($validacao=='X')
				{
					$contaCaracteres = strlen($strValor); //Conta valor recebido 

					if($contaCaracteres!=$tamanho)
					{
						$limitaTamanho   = substr($strValor,0,$tamanho); //Força string a caber no tamanho
						$completaTamanho = str_pad($limitaTamanho,$tamanho," ", STR_PAD_RIGHT); //completa com espaços caracteres faltantes 
						$strCampo        = $completaTamanho; 
					} else {
						$strCampo = $strValor;
					}

					$RegistroA .= $strCampo;

				} else {

					if(ctype_digit($strValor))
					{
						$converToString  = (string) $strValor;
						$limitaTamanho   = substr($converToString,0,$tamanho); //Força string a caber no tamanho
						$completaTamanho = str_pad($limitaTamanho,$tamanho, "0", STR_PAD_LEFT); //Completa com espaços caracteres faltantes 
						$strCampo        = $completaTamanho; 
						$RegistroA .= $strCampo;
					} else {
						echo('O campo '.$index.' ('.$strValidacao.') deve conter apenas numeros!');
					}
				}
			}
		}//Fim foreach

	  	return $RegistroA;
		
	}
	
	private static function clearString($string){
	    $limpa = preg_replace(array("/(ç)/","/(Ç)/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","c C a A e E i I o O u U n N"),$string);
	    return strtoupper(strtolower($limpa));
		// Para usar
	}
}
?>
