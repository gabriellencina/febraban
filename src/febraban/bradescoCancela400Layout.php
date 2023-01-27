<?php

namespace febraban;

class bradescoCancela400Layout{

    public static function Arquivo($cfg)
    {
        $salvar_remessa_em   = isset($cfg['salvar_remessa_em']) ? $cfg['salvar_remessa_em'] : ' ';
        $nome_aquivo_remessa = isset($cfg['nome_aquivo_remessa']) ? $cfg['nome_aquivo_remessa'] : Date('dmY');
    }


    public static function Registro0($cfg)
    {
        // Registro 0 - header label (conf layout para cabeçalho)
        $cod_registro0                                      = isset($cfg['cod_registro0']) ? $cfg['cod_registro0'] : ' ';
        $cod_remessa                                        = isset($cfg['cod_remessa']) ? $cfg['cod_remessa'] : 1;
        $literal_remessa                                    = isset($cfg['literal_remessa']) ? $cfg['literal_remessa'] : ' ';
        $cod_servico                                        = isset($cfg['cod_servico']) ? $cfg['cod_servico'] : ' ';
        $literal_servico                                    = isset($cfg['literal_servico']) ? $cfg['literal_servico'] : ' ';
        $cod_empresa                                        = isset($cfg['cod_empresa']) ? $cfg['cod_empresa'] : ' ';
        $nome_empresa                                       = isset($cfg['nome_empresa']) ? $cfg['nome_empresa'] : ' ';
        $num_bradesco_camara_compensacao                    = isset($cfg['num_bradesco_camara_compensacao']) ? $cfg['num_bradesco_camara_compensacao'] : ' ';
        $nome_banco_extenso                                 = isset($cfg['nome_banco_extenso']) ? $cfg['nome_banco_extenso'] : ' ';
        $data_gravacao_arquivo                              = isset($cfg['data_gravacao_arquivo']) ? $cfg['data_gravacao_arquivo'] : ' ';
        $reservado_futuro                                   = isset($cfg['reservado_futuro']) ? $cfg['reservado_futuro'] : ' ';
        $id_sistema                                         = isset($cfg['id_sistema']) ? $cfg['id_sistema'] : ' ';
        $numero_sequencial_arquivo                          = isset($cfg['numero_sequencial_arquivo']) ? $cfg['numero_sequencial_arquivo'] : ' ';
        $reservado_futuro2                                  = isset($cfg['reservado_futuro2']) ? $cfg['reservado_futuro2'] : ' ';
        $numero_sequencial_registro                         = isset($cfg['numero_sequencial_registro']) ? $cfg['numero_sequencial_registro'] : ' ';

        $campos = array();
        $campos['cod_registro0']                            = array(1, 1, '9:1', $cod_registro0);
        $campos['cod_remessa']                              = array(2, 2, '9:1', $cod_remessa);
        $campos['literal_remessa']                          = array(3, 9, 'X:7', $literal_remessa);
        $campos['cod_servico']                              = array(10, 11, '9:2', $cod_servico);
        $campos['literal_servico']                          = array(12, 26, 'X:15', $literal_servico);
        $campos['cod_empresa']                              = array(27, 46, '9:20', $cod_empresa);
        $campos['nome_empresa']                             = array(47, 76, 'X:30', $nome_empresa);
        $campos['num_bradesco_camara_compensacao']          = array(77, 79, '9:3', $num_bradesco_camara_compensacao);
        $campos['nome_banco_extenso']                       = array(80, 94, 'X:15', $nome_banco_extenso);
        $campos['data_gravacao_arquivo']                    = array(95, 100, '9:6', $data_gravacao_arquivo);
        $campos['reservado_futuro']                         = array(101, 108, 'X:8', $reservado_futuro);
        $campos['id_sistema']                               = array(109, 110, 'X:2', $id_sistema);
        $campos['numero_sequencial_arquivo']                = array(111, 117, '9:7', $numero_sequencial_arquivo);
        $campos['reservado_futuro2']                        = array(118, 394, 'X:277', $reservado_futuro2);
        $campos['numero_sequencial_registro']               = array(395, 400, '9:6', $numero_sequencial_registro);

        return bradescoCancela400Layout::FormatarCampos($campos);
    }


    public static function Registro1($cfg)
    {
        //Registro de transação - tipo 1 (conf layout para cobrança)
        $cod_registro1                                      = isset($cfg['cod_registro1']) ? $cfg['cod_registro1'] : ' ';
        $agencia_debito                                     = isset($cfg['agencia_debito']) ? $cfg['agencia_debito'] : ' ';
        $razao_conta_corrente                               = isset($cfg['razao_conta_corrente']) ? $cfg['razao_conta_corrente'] : ' ';
        $conta_corrente                                     = isset($cfg['conta_corrente']) ? $cfg['conta_corrente'] : ' ';
        $zero                                               = isset($cfg['zero']) ? $cfg['zero'] : ' ';
        $carteira                                           = isset($cfg['carteira']) ? $cfg['carteira'] : ' ';
        $agencia                                            = isset($cfg['agencia']) ? $cfg['agencia'] : ' ';
        $conta                                              = isset($cfg['conta']) ? $cfg['conta'] : ' ';
        $digito_conta                                       = isset($cfg['digito_conta']) ? $cfg['digito_conta'] : ' ';
        $num_controle_participante                          = isset($cfg['num_controle_participante']) ? $cfg['num_controle_participante'] : ' ';
        $cod_banco_deb_camara_compensacao                   = isset($cfg['cod_banco_deb_camara_compensacao']) ? $cfg['cod_banco_deb_camara_compensacao'] : ' ';
        $campo_multa                                        = isset($cfg['campo_multa']) ? $cfg['campo_multa'] : ' ';
        $percentual_multa                                   = isset($cfg['percentual_multa']) ? $cfg['percentual_multa'] : ' ';
        $id_titulo_banco                                    = isset($cfg['id_titulo_banco']) ? $cfg['id_titulo_banco'] : ' ';
        $digito_autoconferencia_num_bancario                = isset($cfg['digito_autoconferencia_num_bancario']) ? $cfg['digito_autoconferencia_num_bancario'] : ' ';
        $desconto_bonificacao_dia                           = isset($cfg['desconto_bonificacao_dia']) ? $cfg['desconto_bonificacao_dia'] : ' ';
        $condicao_emissao_papeleta_cobranca                 = isset($cfg['condicao_emissao_papeleta_cobranca']) ? $cfg['condicao_emissao_papeleta_cobranca'] : ' ';
        $ident_emite_boleto_deb_auto                        = isset($cfg['ident_emite_boleto_deb_auto']) ? $cfg['ident_emite_boleto_deb_auto'] : ' ';
        $id_operacao_banco                                  = isset($cfg['id_operacao_banco']) ? $cfg['id_operacao_banco'] : ' ';
        $id_rateio_credito                                  = isset($cfg['id_rateio_credito']) ? $cfg['id_rateio_credito'] : ' ';
        $enderacamento_aviso_deb_auto                       = isset($cfg['enderacamento_aviso_deb_auto']) ? $cfg['enderacamento_aviso_deb_auto'] : ' ';
        $quantidade_pagamentos                              = isset($cfg['quantidade_pagamentos']) ? $cfg['quantidade_pagamentos'] : ' ';
        $id_ocorrencia                                      = isset($cfg['id_ocorrencia']) ? $cfg['id_ocorrencia'] : ' ';
        $num_documento                                      = isset($cfg['num_documento']) ? $cfg['num_documento'] : ' ';
        $data_vencimento_titulo                             = isset($cfg['data_vencimento_titulo']) ? $cfg['data_vencimento_titulo'] : ' ';
        $valor_titulo                                       = isset($cfg['valor_titulo']) ? $cfg['valor_titulo'] : ' ';
        $banco_encarregado_cobranca                         = isset($cfg['banco_encarregado_cobranca']) ? $cfg['banco_encarregado_cobranca'] : ' ';
        $agencia_depositaria                                = isset($cfg['agencia_depositaria']) ? $cfg['agencia_depositaria'] : ' ';
        $especie_titulo                                     = isset($cfg['especie_titulo']) ? $cfg['especie_titulo'] : ' ';
        $identificacao                                      = isset($cfg['identificacao']) ? $cfg['identificacao'] : ' ';
        $data_emissao_titulo                                = isset($cfg['data_emissao_titulo']) ? $cfg['data_emissao_titulo'] : ' ';
        $instrucao1                                         = isset($cfg['instrucao1']) ? $cfg['instrucao1'] : ' ';
        $instrucao2                                         = isset($cfg['instrucao2']) ? $cfg['instrucao2'] : ' ';
        $valor_cobrado_dia_atraso                           = isset($cfg['valor_cobrado_dia_atraso']) ? $cfg['valor_cobrado_dia_atraso'] : ' ';
        $data_limite_concessao_desconto                     = isset($cfg['data_limite_concessao_desconto']) ? $cfg['data_limite_concessao_desconto'] : ' ';
        $valor_desconto                                     = isset($cfg['valor_desconto']) ? $cfg['valor_desconto'] : ' ';
        $valor_iof                                          = isset($cfg['valor_iof']) ? $cfg['valor_iof'] : ' ';
        $valor_abatimento                                   = isset($cfg['valor_abatimento']) ? $cfg['valor_abatimento'] : ' ';
        $id_tipo_inscricao_pagador                          = isset($cfg['id_tipo_inscricao_pagador']) ? $cfg['id_tipo_inscricao_pagador'] : ' ';
        $num_inscricao_pagador                              = isset($cfg['num_inscricao_pagador']) ? $cfg['num_inscricao_pagador'] : ' ';
        $nome_pagador                                       = isset($cfg['nome_pagador']) ? $cfg['nome_pagador'] : ' ';
        $endereco_completo                                  = isset($cfg['endereco_completo']) ? $cfg['endereco_completo'] : ' ';
        $mensagem1                                          = isset($cfg['mensagem1']) ? $cfg['mensagem1'] : ' ';
        $cep                                                = isset($cfg['cep']) ? $cfg['cep'] : ' ';
        $mensagem2                                          = isset($cfg['mensagem2']) ? $cfg['mensagem2'] : ' ';
        $numero_sequencial_registro2                        = isset($cfg['numero_sequencial_registro2']) ? $cfg['numero_sequencial_registro2'] : ' ';

        $campos = array();
        $campos['cod_registro1']                            = array(1, 1, '9:1', $cod_registro1);
        $campos['agencia_debito']                           = array(2, 7, '9:6', $agencia_debito);
        $campos['razao_conta_corrente']                     = array(8, 12, '9:5', $razao_conta_corrente);
        $campos['conta_corrente']                           = array(13, 19, '9:8', $conta_corrente);
        $campos['zero']                                     = array(21, 21, '9:1', $zero);
        $campos['carteira']                                 = array(22, 24, '9:3', $carteira);
        $campos['agencia']                                  = array(25, 29, '9:5', $agencia);
        $campos['conta']                                    = array(30, 36, '9:7', $conta);
        $campos['digito_conta']                             = array(37, 37, '9:1', $digito_conta);
        $campos['num_controle_participante']                = array(38, 62, 'X:25', $num_controle_participante);
        $campos['cod_banco_deb_camara_compensacao']         = array(63, 65, '9:3', $cod_banco_deb_camara_compensacao);
        $campos['campo_multa']                              = array(66, 66, '9:1', $campo_multa);
        $campos['percentual_multa']                         = array(67, 70, '9:4', $percentual_multa);
        $campos['id_titulo_banco']                          = array(71, 82, 'X:12', $id_titulo_banco);
        $campos['desconto_bonificacao_dia']                 = array(83, 92, '9:10', $desconto_bonificacao_dia);
        $campos['condicao_emissao_papeleta_cobranca']       = array(93, 93, '9:1', $condicao_emissao_papeleta_cobranca);
        $campos['ident_emite_boleto_deb_auto']              = array(94, 94, 'X:1', $ident_emite_boleto_deb_auto);
        $campos['id_operacao_banco']                        = array(95, 104, 'X:10', $id_operacao_banco);
        $campos['id_rateio_credito']                        = array(105, 105, 'X:1', $id_rateio_credito);
        $campos['enderacamento_aviso_deb_auto']             = array(106, 106, '9:1', $enderacamento_aviso_deb_auto);
        $campos['quantidade_pagamentos']                    = array(107, 108, 'X:2', $quantidade_pagamentos);
        $campos['id_ocorrencia']                            = array(109, 110, '9:2', $id_ocorrencia);
        $campos['num_documento']                            = array(111, 120, 'X:10', $num_documento);
        $campos['data_vencimento_titulo']                   = array(121, 126, '9:6', $data_vencimento_titulo);
        $campos['valor_titulo']                             = array(127, 139, '9:13', $valor_titulo);
        $campos['banco_encarregado_cobranca']               = array(140, 142, '9:3', $banco_encarregado_cobranca);
        $campos['agencia_depositaria']                      = array(143, 147, '9:5', $agencia_depositaria);
        $campos['especie_titulo']                           = array(148, 149, '9:2', $especie_titulo);
        $campos['identificacao']                            = array(150, 150, 'X:1', $identificacao);
        $campos['data_emissao_titulo']                      = array(151, 156, '9:6', $data_emissao_titulo);
        $campos['instrucao1']                               = array(157, 158, '9:2', $instrucao1);
        $campos['instrucao2']                               = array(159, 160, '9:2', $instrucao2);
        $campos['valor_cobrado_dia_atraso']                 = array(161, 173, '9:13', $valor_cobrado_dia_atraso);
        $campos['data_limite_concessao_desconto']           = array(174, 179, '9:6', $data_limite_concessao_desconto);
        $campos['valor_desconto']                           = array(180, 192, '9:13', $valor_desconto);
        $campos['valor_iof']                                = array(193, 205, '9:13', $valor_iof);
        $campos['valor_abatimento']                         = array(206, 218, '9:13', $valor_abatimento);
        $campos['id_tipo_inscricao_pagador']                = array(219, 220, '9:2', $id_tipo_inscricao_pagador);
        $campos['num_inscricao_pagador']                    = array(221, 234, '9:14', $num_inscricao_pagador);
        $campos['nome_pagador']                             = array(235, 274, 'X:40', $nome_pagador);
        $campos['endereco_completo']                        = array(275, 314, 'X:40', $endereco_completo);
        $campos['mensagem1']                                = array(315, 326, 'X:12', $mensagem1);
        $campos['cep']                                      = array(327, 331, '9:8', $cep);
        $campos['mensagem2']                                = array(335, 394, 'X:60', $mensagem2);
        $campos['numero_sequencial_registro2']              = array(395, 400, '9:6', $numero_sequencial_registro2);

        return bradescoCancela400Layout::FormatarCampos($campos);
    }

    
    public static function Registro6($cfg)
    {
        // Registro de Transação -Tipo 6 (conf cadastro para débito automático)
        $cod_registro6                                      = isset($cfg['cod_registro6']) ? $cfg['cod_registro6'] : ' ';
        $carteira                                           = isset($cfg['carteira']) ? $cfg['carteira'] : ' ';
        $agencia_debito                                     = isset($cfg['agencia_debito']) ? $cfg['agencia_debito'] : ' ';
        $conta_corrente2                                    = isset($cfg['conta_corrente2']) ? $cfg['conta_corrente2'] : ' ';
        $numero_bradesco                                    = isset($cfg['numero_bradesco']) ? $cfg['numero_bradesco'] : ' ';
        $tipo_operacao                                      = isset($cfg['tipo_operacao']) ? $cfg['tipo_operacao'] : ' ';
        $utilizacao_cheque_especial                         = isset($cfg['utilizacao_cheque_especial']) ? $cfg['utilizacao_cheque_especial'] : ' ';
        $consulta_saldo_apos_vencimento                     = isset($cfg['consulta_saldo_apos_vencimento']) ? $cfg['consulta_saldo_apos_vencimento'] : ' ';
        $num_cod_id_contrato                                = isset($cfg['num_cod_id_contrato']) ? $cfg['num_cod_id_contrato'] : ' ';
        $prazo_validade_contrato                            = isset($cfg['prazo_validade_contrato']) ? $cfg['prazo_validade_contrato'] : ' ';
        $reservado_futuro_6                                 = isset($cfg['reservado_futuro_6']) ? $cfg['reservado_futuro_6'] : ' ';
        $numero_sequencial_registro3                        = isset($cfg['numero_sequencial_registro3']) ? $cfg['numero_sequencial_registro3'] : ' ';

        $campos = array();
        $campos['cod_registro6']                            = array(1, 1, '9:1', $cod_registro6);
        $campos['carteira']                                 = array(2, 4, '9:3', $carteira);
        $campos['agencia_debito']                           = array(5, 9, '9:5', $agencia_debito);
        $campos['conta_corrente2']                          = array(10, 16, '9:7', $conta_corrente2);
        $campos['numero_bradesco']                          = array(17, 28, 'X:12', $numero_bradesco);
        $campos['tipo_operacao']                            = array(29, 29, '9:1', $tipo_operacao);
        $campos['utilizacao_cheque_especial']               = array(30, 30, 'X:1', $utilizacao_cheque_especial);
        $campos['consulta_saldo_apos_vencimento']           = array(31, 31, 'X:1', $consulta_saldo_apos_vencimento);
        $campos['num_cod_id_contrato']                      = array(32, 57, '9:25', $num_cod_id_contrato);
        $campos['prazo_validade_contrato']                  = array(58, 65, '9:8', $prazo_validade_contrato);
        $campos['reservado_futuro_6']                       = array(66, 395, 'X:330', $reservado_futuro_6);
        $campos['numero_sequencial_registro3']              = array(396, 400, '9:6', $numero_sequencial_registro3);

        return bradescoDebAuto400LayoutCNAB::FormatarCampos($campos);
    }

    public static function Registro9($cfg)
    {
        // Registro 9 - Trailer (conf layout para última linha do arquivo)
        $cod_registro9                                      = isset($cfg['cod_registro9']) ? $cfg['cod_registro9'] : ' ';
        $reservado_futuro_9                                 = isset($cfg['reservado_futuro_9']) ? $cfg['reservado_futuro_9'] : ' ';
        $numero_sequencial_registro3                        = isset($cfg['numero_sequencial_registro3']) ? $cfg['numero_sequencial_registro3'] : ' ';

        $campos                                             = array();
        $campos['cod_registro9']                            = array(1, 1, '9:1', $cod_registro9);
        $campos['reservado_futuro_9']                       = array(2, 394, 'X:393', $reservado_futuro_9);
        $campos['numero_sequencial_registro3']              = array(395, 400, '9:6', $numero_sequencial_registro3);

        return bradescoCancela400Layout::FormatarCampos($campos);
    }


    public static function FormatarCampos($campos)
    {

        $Registro0      = ''; //String do Registro A
        $permiteBrancos = array('reservado_futuro', 'uso_empresa'); //Campos que podem ser vazios

        foreach ($campos as $index => $value) {

            $strInicio    = isset($value[0]) ? $value[0] : 1;
            $strFim       = isset($value[1]) ? $value[1] : 1;
            $strValidacao = isset($value[2]) ? $value[2] : 'X:1';
            $strV         = isset($value[3]) ? $value[3] : '';
            $strValor     = bradescoCancela400Layout::clearString($strV);

            $x = explode(':', $strValidacao); //Identifica tipo de validação x ou 9

            $validacao = isset($x[0]) ? $x[0] : 'X';
            $tamanho   = isset($x[1]) ? $x[1] : 1;

            if (!in_array($index, $permiteBrancos) && $strValor === NULL) {

                die('O campo ' . $index . ' (' . $strValidacao . ') não pode estar em branco! {' . $strValor . '}');
            } else {

                if ($validacao == 'X') {
                    $contaCaracteres = strlen($strValor); //Conta valor recebido 

                    if ($contaCaracteres != $tamanho) {
                        $limitaTamanho    = substr($strValor, 0, $tamanho); //Força string a caber no tamanho
                        $completaTamanho  = str_pad($limitaTamanho, $tamanho, " ", STR_PAD_RIGHT); //completa com espaços caracteres faltantes 
                        $strCampo         = $completaTamanho;
                    } else {
                        $strCampo = $strValor;
                    }

                    $Registro0 .= $strCampo;
                } else {

                    if (ctype_digit($strValor)) {
                        $converToString  = (string) $strValor;
                        $limitaTamanho   = substr($converToString, 0, $tamanho); //Força string a caber no tamanho
                        $completaTamanho = str_pad($limitaTamanho, $tamanho, "0", STR_PAD_LEFT); //Completa com espaços caracteres faltantes 
                        $strCampo        = $completaTamanho;
                        $Registro0 .= $strCampo;
                    } else {
                        echo ('O campo ' . $index . ' (' . $strValidacao . ') deve conter apenas numeros!');
                    }
                }
            }
        } //Fim foreach

        return $Registro0;
    }

    private static function clearString($string)
    {
        $limpa = preg_replace(array("/(ç)/", "/(Ç)/", "/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "c C a A e E i I o O u U n N"), $string);
        return strtoupper(strtolower($limpa));
        // Para usar
    }
}
