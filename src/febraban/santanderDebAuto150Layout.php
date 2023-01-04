<?php

namespace febraban;
class santanderDebAuto150Layout{

    public static function Arquivo($cfg)
    {
		$salvar_remessa_em   = isset($cfg['salvar_remessa_em']) ? $cfg['salvar_remessa_em'] :' ';
		$nome_aquivo_remessa = isset($cfg['nome_aquivo_remessa']) ? $cfg['nome_aquivo_remessa'] : Date('dmY');
	}

    public static function RegistroA($cfg)
    {

        $cod_registro                           = isset($cfg['cod_registro']) ? $cfg['cod_registro'] :' ';
        $cod_remessa                            = isset($cfg['cod_remessa']) ? $cfg['cod_remessa'] : 1;
        $cod_convenio                           = isset($cfg['cod_convenio']) ? $cfg['cod_convenio'] :' ';
        $nome_empresa                           = isset($cfg['nome_empresa']) ? $cfg['nome_empresa'] :' ';
        $cod_banco                              = isset($cfg['cod_banco']) ? $cfg['cod_banco'] :' ';
        $nome_banco                             = isset($cfg['nome_banco']) ? $cfg['nome_banco'] :' ';
        $data_geração_arquivo                   = isset($cfg['data_geração_arquivo']) ? $cfg['data_geração_arquivo'] :' ';
        $numero_sequencial_arquivo              = isset($cfg['numero_sequencial_arquivo']) ? $cfg['numero_sequencial_arquivo'] :' ';
        $versao_layout                          = isset($cfg['versao_layout']) ? $cfg['versao_layout'] :' ';
        $identificacao_servico                  = isset($cfg['identificacao_servico']) ? $cfg['identificacao_servico'] :' ';
        $reservado_futuro                       = isset($cfg['reservado_futuro']) ? $cfg['reservado_futuro'] :' ';
        
        $campos = array();
        $campos['cod_registro'] 	            = array(1,1,'X:1', $cod_registro);
        $campos['cod_remessa']                  = array(2,2,'9:1', $cod_remessa);
        $campos['cod_convenio']		            = array(3,22,'X:20', $cod_convenio);
        $campos['nome_empresa']		            = array(23,42,'X:20', $nome_empresa);
        $campos['cod_banco']		            = array(43,45,'9:3', $cod_banco);
        $campos['nome_banco']		            = array(46,65,'X:20', $nome_banco);
        $campos['data_geração_arquivo']         = array(66,73, '9:8', $data_geração_arquivo);
        $campos['numero_sequencial_arquivo']    = array(74,79,'9:6', $numero_sequencial_arquivo);
        $campos['versao_layout'] 	            = array(80,81,'9:2', $versao_layout);
        $campos['identificacao_servico']        = array(82,98,'X:17', $identificacao_servico);
        $campos['reservado_futuro']             = array(99,150,'X:52', $reservado_futuro);

        return santanderDebAuto150Layout::FormatarCampos($campos);

    }

    public static function RegistroE($cfg)
    {

        $cod_registro                           = isset($cfg['cod_registro']) ? $cfg['cod_registro'] :' ';
        $id_cliente_empresa                     = isset($cfg['id_cliente_empresa']) ? $cfg['id_cliente_empresa'] :' ';
        $agencia_debito                         = isset($cfg['agencia_debito']) ? $cfg['agencia_debito'] :' ';
        $id_cliente_banco                       = isset($cfg['id_cliente_banco']) ? $cfg['id_cliente_banco'] :' ';
        $data_vencimento                        = isset($cfg['data_vencimento']) ? $cfg['data_vencimento'] :' ';
        $valor_debito                           = isset($cfg['valor_debito']) ? $cfg['valor_debito'] :' ';
        $codigo_moeda                           = isset($cfg['codigo_moeda']) ? $cfg['codigo_moeda'] :' ';
        $uso_empresa                            = isset($cfg['uso_empresa']) ? $cfg['uso_empresa'] :' ';
        $reservado_futuroE                      = isset($cfg['reservado_futuroE']) ? $cfg['reservado_futuroE'] :' ';
        $codigo_movimento                       = isset($cfg['codigo_movimento']) ? $cfg['codigo_movimento'] :' ';

        $campos = array();
        $campos['cod_registro'] 	            = array(1,1,'X:1',$cod_registro);
        $campos['id_cliente_empresa']           = array(2,26,'X:25',$id_cliente_empresa);
        $campos['agencia_debito'] 	            = array(27,30,'9:4',$agencia_debito);
        $campos['id_cliente_banco']             = array(31,44,'X:14',$id_cliente_banco);
        $campos['data_vencimento'] 	            = array(45,52,'9:8',$data_vencimento);
        $campos['valor_debito'] 	            = array(53,67,'9:15',$valor_debito);
        $campos['codigo_moeda'] 	            = array(68,69,'X:2',$codigo_moeda);
        $campos['uso_empresa'] 	                = array(70,128,'X:59',$uso_empresa);
        $campos['reservado_futuroE']            = array(130,149, 'X:20', $reservado_futuroE);
        $campos['codigo_movimento']             =  array(150,150,'9:1',$codigo_movimento);

        return santanderDebAuto150Layout::FormatarCampos($campos);

    }

    public static function RegistroZ($cfg)
    {

        $cod_registro                            = isset($cfg['cod_registro']) ? $cfg['cod_registro'] :' ';
        $total_registros_arquivo                 = isset($cfg['total_registros_arquivo']) ? $cfg['total_registros_arquivo'] :' ';
        $valor_total_registro_arquivo            = isset($cfg['valor_total_registro_arquivo']) ? $cfg['valor_total_registro_arquivo'] :' ';
        $reservado_futuroZ                       = isset($cfg['reservado_futuroZ']) ? $cfg['reservado_futuroZ'] :' ';

        $campos = array();
        $campos['cod_registro']                  = array(1,1,'X:1',$cod_registro);
        $campos['total_registros_arquivo']       = array(2,7,'9:6',$total_registros_arquivo);
        $campos['valor_total_registro_arquivo']  = array(8,24,'9:17',$valor_total_registro_arquivo);
        $campos['reservado_futuroZ']             = array(25,150,'X:126',$reservado_futuroZ);

        return santanderDebAuto150Layout::FormatarCampos($campos);

    }

    public static function FormatarCampos($campos)
    {

		$RegistroA = ''; //String do Registro A
		$permiteBrancos = array('reservado_futuro','uso_empresa'); //Campos que podem ser vazios

		foreach($campos as $index=>$value)
        {	
			$strInicio    = isset($value[0]) ? $value[0] : 1; 
			$strFim       = isset($value[1]) ? $value[1] : 1; 			
			$strValidacao = isset($value[2]) ? $value[2] : 'X:1';
			$strV         = isset($value[3]) ? $value[3] : '';
			$strValor     = santanderDebAuto150Layout::clearString($strV);

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

    private static function clearString($string)
    {
	    $limpa = preg_replace(array("/(ç)/","/(Ç)/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","c C a A e E i I o O u U n N"),$string);
	    return strtoupper(strtolower($limpa));
	}
}




