<?php

public function onBancoDoBrasil($param = null)
{
        TTransaction::open(self::$database);
            
        $data               = $param['data'];
            
        $arruma_data        = explode('-',$param['data']);
            
        $message            = "";
            
        $convenio           = $param['convenio'];
            
        $dia_inicial        = $param['dia_inicial'];
            
        $dia_final          = $param['dia_final'];
            
        $vendedor           = $param['id_vendedor'];
        
        $parcela_optante    = $param['parcela_optante'];
            
        $dia                = $dia_final;
            
        $mes                = $arruma_data[1];
            
        $ano                = $arruma_data[0];
            
        $_count_sem_conta   = 0;
            
        $_count_parcelas    = 0;

        if(!empty($param['convenio']))
        {
            // Busca os dados do convenio
            $convenio_deb_conta = ConveniosDebitoEmConta::where('cod_convenio',  '=', $convenio)->orderBy('id')->first();
            
            $banco = Bancos::where('id',  '=', $convenio_deb_conta->banco_id)->orderBy('id')->first();
            
            $forma_pagamento = FormaPagamento::where('cod_convenio',  '=', $convenio_deb_conta->id)->orderBy('id')->first();
        
            if($banco->codigo_febraban == 1)
            {
                $data_original = date('Y-m-d', strtotime($negocio->dia_debito . '-' . substr($param['data'],5,2) . '-' . substr($param['data'],0,4)));
                
                $log_gerador_parcelas  = new LogGeradorParcelas();
                
                $nr_parcelas_coletivas = 0;
                
                while($dia >= $dia_inicial)
                {
                    $nr_parcelas = 0;
                   
                    $negocios = Negocios::where('dia_debito',  '=', $dia)->where('forma_pagamento', '=', $forma_pagamento->id)->where('status_negocio', '=', 1)->where('valor_total', '!=', 0)->load();
                    
                    foreach ($negocios as $negocio)
                    {
                        $_conta_cliente = ClientesDadosDebito::where('id', '=', $negocio->conta_debito)->first();
                        
                        if(!empty($_conta_cliente->conta_corrente))
                        {
                            $data_mes_atual = date('Y-m-d', strtotime( 1 . '-' . substr($param['data'],5,2) . '-' . substr($param['data'],0,4)));
                                    
                            $ano_seguinte   = substr($param['data'],5,2) == 12 ?  substr($param['data'],0,4) + 1  : substr($param['data'],0,4);
                                    
                            $mes_seguinte   = substr($param['data'],5,2) == 12 ? 1 : substr($param['data'],5,2) + 1;
                                    
                            $data_mes_seguinte = date('Y-m-d', strtotime( 1 . '-' . $mes_seguinte . '-' . $ano_seguinte));
                            
                            // Gera parcelas aonde o meu vendedor é informado
                            if(!empty($vendedor))
                            {
                                if($negocio->vendedor_id == $vendedor)
                                {
                                    // Gera apenas parcelas aonde minha data original (dia + mês + ano) seja maior ou igual a minha data de venda de negócios, evitando cobrança retroativa 
                                    if($data_original >= $negocio->data_venda)
                                    {
                                      //Verifica se as parcelas já foram geradas
                                      $negocio_parcelas = NegocioParcelas::where('negocio_id', '=' , $negocio->id)->where('vencimento' , '>=' , "$data_mes_atual")->where('vencimento', '<' , "$data_mes_seguinte")->first(); 
                                        
                                        if(empty($negocio_parcelas))
                                        {
                                            $conn = TTransaction::get();
                                            $result2 = $conn->query("SELECT max(numero_parcela) FROM negocio_parcelas WHERE negocio_id = $negocio->id");
                                            $conta_parcelas = $result2->fetch();
                                                
                                            $cliente_dados_debito = ClientesDadosDebito::where('cliente_id', '=', $negocio->cliente_id)->first();
                                            
                                            $id_usuario_logado = TSession::getValue('userid');
                                                
                                            $parcela                                        = new NegocioParcelas();
                                            $parcela->negocio_id                            = $negocio->id;
                                            $parcela->vencimento                            = $data;
                                            $parcela->valor                                 = $negocio->optin_pendente == 1 ? 0 : $negocio->valor_total; 
                                            $parcela->total                                 = $negocio->optin_pendente == 1 ? 0 : $negocio->valor_total;
                                            $parcela->pagamento_parcelas                    = 0;
                                            $parcela->numero_parcela                        = $conta_parcelas[0] + 1;
                                            $parcela->vencimento_original                   = $data_original;
                                            $parcela->numero_agendamento_cliente            = 0;
                                            $parcela->numero_registro_e                     = 0;
                                            $parcela->banco                                 = $cliente_dados_debito->banco_id;
                                            $parcela->agencia                               = $cliente_dados_debito->agencia_bancaria;
                                            $parcela->conta_corrente                        = $cliente_dados_debito->conta_corrente;
                                            $parcela->cod_operacao                          = $cliente_dados_debito->cod_operacao;
                                            $parcela->status                                = 1;
                                            $parcela->data_criacao                          = date('Y-m-d H:i:s');
                                            $parcela->convenio_id                           = $convenio_deb_conta->id;
                                            $parcela->store();
                                            
                                            $nr_parcelas += 1;
                                            
                                            $nr_parcelas_coletivas++;
                                            
                                            $_count_parcelas++;
                                        }
                                    }
                                }
                                
                            } else {
    
                                    $data_original = date('Y-m-d', strtotime($negocio->dia_debito . '-' . substr($param['data'],5,2) . '-' . substr($param['data'],0,4)));
                                    
                                    // Gera parcelas sem id do vendedor, aonde minha data original (dia + mês + ano) seja maior ou igual a minha data de venda de negócios assim evitando cobrança retroativa 
                                    if($data_original >= $negocio->data_venda)
                                    {
                                        if($parcela_optante == 0)
                                        {
                                            // Verifica minhas parcelas com retorno do banco com base no valor da parcela = 0
                                            $negocio_parcelas = NegocioParcelas::where('negocio_id', '=' , $negocio->id)
                                                                               ->where('vencimento' , '>=' , "$data_mes_atual")
                                                                               ->where('vencimento', '<' , "$data_mes_seguinte")
                                                                               ->where('valor', '=', 0)
                                                                               ->first();
                                            
                                            // Gera minhas parcelas quando deixar de ser optante       
                                            if($negocio_parcelas)
                                            {
                                                $conn = TTransaction::get();
                                                $result2 = $conn->query("SELECT max(numero_parcela) FROM negocio_parcelas WHERE negocio_id = $negocio->id");
                                                $conta_parcelas = $result2->fetch();
                                                
                                                $cliente_dados_debito = ClientesDadosDebito::where('cliente_id', '=', $negocio->cliente_id)->first();
                                            
                                                $id_usuario_logado = TSession::getValue('userid');
                                            
                                                $parcela                                        = new NegocioParcelas();
                                                $parcela->negocio_id                            = $negocio->id;
                                                $parcela->vencimento                            = $data;
                                                $parcela->valor                                 = $negocio->valor_total; 
                                                $parcela->total                                 = $negocio->valor_total;
                                                $parcela->pagamento_parcelas                    = 0;
                                                $parcela->numero_parcela                        = $conta_parcelas[0] + 1;
                                                $parcela->vencimento_original                   = $data_original;
                                                $parcela->numero_agendamento_cliente            = 0;
                                                $parcela->numero_registro_e                     = 0;
                                                $parcela->banco                                 = $cliente_dados_debito->banco_id;
                                                $parcela->agencia                               = $cliente_dados_debito->agencia_bancaria;
                                                $parcela->conta_corrente                        = $cliente_dados_debito->conta_corrente;
                                                $parcela->cod_operacao                          = $cliente_dados_debito->cod_operacao;
                                                $parcela->status                                = 1;
                                                $parcela->data_criacao                          = date('Y-m-d H:i:s');
                                                $parcela->convenio_id                           = $convenio_deb_conta->id;
                                                $parcela->store();
                                        
                                                $nr_parcelas += 1;
                                            
                                                $nr_parcelas_coletivas++;
                                            
                                                $_count_parcelas++;
                                            }
                                            
                                        } else {
                                            
                                                $negocio_parcelas = NegocioParcelas::where('negocio_id', '=' , $negocio->id)
                                                                                   ->where('vencimento' , '>=' , "$data_mes_atual")
                                                                                   ->where('vencimento', '<' , "$data_mes_seguinte")
                                                                                   ->first();
                                                                               
                                                // Gera minhas parcelas quando for optante por padrão 
                                                if(empty($negocio_parcelas))
                                                {
                                                    $conn = TTransaction::get();
                                                    $result2 = $conn->query("SELECT max(numero_parcela) FROM negocio_parcelas WHERE negocio_id = $negocio->id");
                                                    $conta_parcelas = $result2->fetch();
                                                    
                                                    $cliente_dados_debito = ClientesDadosDebito::where('cliente_id', '=', $negocio->cliente_id)->first();
                                                
                                                    $id_usuario_logado = TSession::getValue('userid');
                                                
                                                    $parcela                                        = new NegocioParcelas();
                                                    $parcela->negocio_id                            = $negocio->id;
                                                    $parcela->vencimento                            = $data;
                                                    $parcela->valor                                 = 0;   
                                                    $parcela->total                                 = 0;  
                                                    $parcela->pagamento_parcelas                    = 0;
                                                    $parcela->numero_parcela                        = $conta_parcelas[0] + 1;
                                                    $parcela->vencimento_original                   = $data_original;
                                                    $parcela->numero_agendamento_cliente            = 0;
                                                    $parcela->numero_registro_e                     = 0;
                                                    $parcela->banco                                 = $cliente_dados_debito->banco_id;
                                                    $parcela->agencia                               = $cliente_dados_debito->agencia_bancaria;
                                                    $parcela->conta_corrente                        = $cliente_dados_debito->conta_corrente;
                                                    $parcela->cod_operacao                          = $cliente_dados_debito->cod_operacao;
                                                    $parcela->status                                = 1;
                                                    $parcela->data_criacao                          = date('Y-m-d H:i:s');
                                                    $parcela->convenio_id                           = $convenio_deb_conta->id;
                                                    $parcela->store();
                                            
                                                    $nr_parcelas += 1;
                                                
                                                    $nr_parcelas_coletivas++;
                                                
                                                    $_count_parcelas++;
                                                }
                                            }
                                        }   
                                    }
                                
                            } else {
                                
                                $_count_sem_conta++;
                            }
                        }
                        
                        $array[] = ['dia' => intval($dia), 'nr_parcelas' => $nr_parcelas];
                
                        $log_gerador_parcelas->data_vencimento  = $data;
                        $log_gerador_parcelas->quantidade       = $nr_parcelas_coletivas;
                        $log_gerador_parcelas->store();
                        
                        $log_gerador_parcelas_detalhes                           = new LogGeradorParcelasDetalhes();
                        $log_gerador_parcelas_detalhes->log_gerador_parcelas_id  = $log_gerador_parcelas->id;
                        $log_gerador_parcelas_detalhes->data_hora                = date('Y-m-d H:i:s');
                        $log_gerador_parcelas_detalhes->user_id                  = $id_usuario_logado;
                        $log_gerador_parcelas_detalhes->vendedor                 = !empty($vendedor) ? $log_gerador_parcelas_detalhes->vendedor = $vendedor : "";        
                        $log_gerador_parcelas_detalhes->convenio                 = $convenio;  
                        $log_gerador_parcelas_detalhes->data_vencimento_original = $data_original;    
                        $log_gerador_parcelas_detalhes->dia_inicial              = $dia_inicial;
                        $log_gerador_parcelas_detalhes->dia_final                = $dia_final;
                        $log_gerador_parcelas_detalhes->cod_operacao             = "";
                        $log_gerador_parcelas_detalhes->total_parcelas_gerada    = $nr_parcelas;
                        $log_gerador_parcelas_detalhes->store();
                        
                        $dia += -1;
                    }
                    
                    //Ação a ser executada quando a mensagem de sucesso for fechada
                    $closeAction = new TAction(['GeradorParcelasClass', 'onShow']);
                    
            
                    for($i = 0; $i <= 31; $i++)
                    {
                        $message = $array[$i]['nr_parcelas'] != 0 ? $message . $array[$i]['nr_parcelas'] . ' parcela(s) gerada(s) em ' . $array[$i]['dia'] . '/' . $mes . '/' . $ano . "</br>" : $message ;
                        
                    }
                
                    if($_count_parcelas > 1)
                    {
                        $message = "Convênio: $convenio - BANCO DO BRASIL <br> {$message}
                                    {$_count_sem_conta} negócio(s) não possuem conta corrente!";
                                    
                        new TMessage('info', "{$message}", $closeAction); 
        
                    } elseif($_count_parcelas == 0){
                        
                        $message = "Convênio: {$convenio} - BANCO DO BRASIL <br> {$message} Parcelas já geradas anteriormente!";
                         
                        new TMessage('info', "{$message}", $closeAction); 
                    }
                }
            }
            
        TTransaction::close();
}