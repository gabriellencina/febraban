<?php

namespace febraban;
class bbDebAuto150Layout{

    public static function Arquivo($cfg)
    {
        $salvar_remessa_em   = isset($cfg['salvar_remessa_em']) ? $cfg['salvar_remessa_em'] : ' ';
        $nome_aquivo_remessa = isset($cfg['nome_aquivo_remessa']) ? $cfg['nome_aquivo_remessa'] : Date('dmY');
    }


    public static function RegistroA($cfg)
    {

        $cod_registro                           = isset($cfg['cod_registro']) ? $cfg['cod_registro'] :' ';
        $cod_remessa                            = isset($cfg['cod_remessa']) ? $cfg['cod_remessa'] : 0;
        $cod_convenio 						    = isset($cfg['cod_convenio']) ? $cfg['cod_convenio'] :' ';
        $nome_destinataria                      = isset($cfg['nome_destinataria']) ? $cfg['nome_destinataria'] :' ';
        $cod_depositaria                        = isset($cfg['cod_depositaria']) ? $cfg['cod_depositaria'] :' ';
        $nome_depositaria                       = isset($cfg['nome_depositaria']) ? $cfg['nome_depositaria'] :' ';
        $data_geracao                           = isset($cfg['data_geracao']) ? $cfg['data_geracao'] :' ';
        $numero_sequencial_arquivo              = isset($cfg['numero_sequencial_arquivo']) ? $cfg['numero_sequencial_arquivo'] :' ';
        $versao_layout                          = isset($cfg['versao_layout']) ? $cfg['versao_layout'] :' ';
        $identificacao_servico                  = isset($cfg['identificacao_servico']) ? $cfg['identificacao_servico'] :' ';
        $reservado_futuro                       = isset($cfg['reservado_futuro']) ? $cfg['reservado_futuro'] :' ';

        $campos 							    = array();
        $campos['cod_registro'] 		        = array(1,1,'X:1',$cod_registro);
        $campos['cod_remessa']                  = array(2,2,'9:1',$cod_remessa);
        $campos['cod_convenio']                 = array(3,22,'X:20',$cod_convenio);                     
        $campos['nome_destinataria']            = array(23,42,'X:20',$nome_destinataria);
        $campos['cod_depositaria']              = array(43,45,'9:3',$cod_depositaria);
        $campos['nome_depositaria']             = array(46,65,'X:20',$nome_depositaria);
        $campos['data_geracao']                 = array(66,73,'9:8',$data_geracao);
        $campos['numero_sequencial_arquivo']    = array(74,79,'9:6',$numero_sequencial_arquivo);
        $campos['versao_layout']                = array(80,81,'9:2',$versao_layout);
        $campos['identificacao_servico']        = array(82,98,'X:17',$identificacao_servico);
        $campos['reservado_futuro']             = array(99,150,'X:52',$reservado_futuro);

        return bbDebAuto150Layout::FormatarCampos($campos);

    }


    public static function RegistroE($cfg)
    {

        $cod_registro_e                         = isset($cfg['cod_registro_e']) ? $cfg['cod_registro_e'] :' ';
        $id_cliente_destinataria                = isset($cfg['id_cliente_destinataria']) ? $cfg['id_cliente_destinataria'] :' ';
        $agencia_debito                         = isset($cfg['agencia_debito']) ? $cfg['agencia_debito'] :' ';
        $id_cliente_depositaria                 = isset($cfg['id_cliente_depositaria']) ? $cfg['id_cliente_depositaria'] :' ';
        $prazo_validade_contrato                = isset($cfg['prazo_validade_contrato']) ? $cfg['prazo_validade_contrato'] :' ';
        $valor_debito                           = isset($cfg['valor_debito']) ? $cfg['valor_debito'] :' ';
        $cod_moeda                              = isset($cfg['cod_moeda']) ? $cfg['cod_moeda'] :' ';
        $uso_instituicao_destinataria           = isset($cfg['uso_instituicao_destinataria']) ? $cfg['uso_instituicao_destinataria'] :' ';
        $uso_instituicao_destinataria2          = isset($cfg['uso_instituicao_destinataria2']) ? $cfg['uso_instituicao_destinataria2'] :' ';
        $tipo_identificacao                     = isset($cfg['tipo_identificacao']) ? $cfg['tipo_identificacao'] :' ';
        $identificacao                          = isset($cfg['identificacao']) ? $cfg['identificacao'] :' ';
        $tipo_operacao                          = isset($cfg['tipo_operacao']) ? $cfg['tipo_operacao'] :' ';
        $utilizacao_cheque_especial             = isset($cfg['utilizacao_cheque_especial']) ? $cfg['utilizacao_cheque_especial'] :' ';
        $opcao_debito_parcial                   = isset($cfg['opcao_debito_parcial']) ? $cfg['opcao_debito_parcial'] :' ';
        $reservado_futuro_E                     = isset($cfg['reservado_futuro_E']) ? $cfg['reservado_futuro_E'] :' ';
        $cod_movimento                          = isset($cfg['cod_movimento']) ? $cfg['cod_movimento'] :' ';

        $campos                                 = array();
        $campos['cod_registro_e']               = array(1,1,'X:1',$cod_registro_e);
        $campos['id_cliente_destinataria']      = array(2,26,'X:25',$id_cliente_destinataria);
        $campos['agencia_debito']               = array(27,30,'X:4',$agencia_debito);
        $campos['id_cliente_depositaria']       = array(31,50,'X:20',$id_cliente_depositaria);
        $campos['prazo_validade_contrato']      = array(51,58,'9:8',$prazo_validade_contrato);
        $campos['valor_debito']                 = array(59,73,'9:15',$valor_debito);
        $campos['cod_moeda']                    = array(74,75,'9:2',$cod_moeda);
        $campos['uso_instituicao_destinataria'] = array(76,128,'X:53',$uso_instituicao_destinataria);
        $campos['uso_instituicao_destinataria2']= array(129,129,'X:1',$uso_instituicao_destinataria2);
        $campos['tipo_identificacao']           = array(130,130,'9:1',$tipo_identificacao);
        $campos['identificacao']                = array(131,145,'9:15',$identificacao);
        $campos['tipo_operacao']                = array(146,146,'9:1',$tipo_operacao);
        $campos['utilizacao_cheque_especial']   = array(147,147,'9:1',$utilizacao_cheque_especial);
        $campos['opcao_debito_parcial']         = array(148,148,'9:1',$opcao_debito_parcial);
        $campos['reservado_futuro_E']           = array(149,149,'X:1',$reservado_futuro_E);
        $campos['cod_movimento']                = array(150,150,'9:1',$cod_movimento);
        
        return bbDebAuto150Layout::FormatarCampos($campos);

    }


    public static function RegistroZ($cfg)
    {

        $cod_registro_z                          = isset($cfg['cod_registro_z']) ? $cfg['cod_registro_z'] :' ';
        $total_registros_arquivo                 = isset($cfg['total_registros_arquivo']) ? $cfg['total_registros_arquivo'] :' ';
        $valor_total_registros_arquivo           = isset($cfg['valor_total_registros_arquivo']) ? $cfg['valor_total_registros_arquivo'] :' ';
        $reservado_futuro_Z                      = isset($cfg['reservado_futuro_Z']) ? $cfg['reservado_futuro_Z'] :' ';

        $campos                                  = array();
        $campos['cod_registro_z']                = array(1,1,'X:1',$cod_registro_z);
        $campos['total_registros_arquivo']       = array(2,7,'9:6',$total_registros_arquivo);
        $campos['valor_total_registros_arquivo'] = array(8,24,'9:17',$valor_total_registros_arquivo);
        $campos['reservado_futuro_Z']            = array(25,150,'X:126',$reservado_futuro_Z);

        return bbDebAuto150Layout::FormatarCampos($campos);

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
			$strValor     = bbDebAuto150Layout::clearString($strV);

			$x = explode(':',$strValidacao); //Identifica tipo de validação x ou 9

			$validacao = isset($x[0]) ? $x[0] : 'X';
			$tamanho   = isset($x[1]) ? $x[1] : 1;

			if(!in_array($index,$permiteBrancos)&&$strValor===NULL)
			{
				
				die('O campo '.$index.' ('.$strValidacao.') não pode estar em branco! {'.$strValor.'}');
			
			}else{

				if($validacao=='X'){
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
		// Para usar
    }
}
?>

