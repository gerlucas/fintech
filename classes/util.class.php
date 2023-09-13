<?php

class Util
{

    public static function calcularRendimento($aporteInicial, $periodo, $rendimentoMensal, $aporteMensal)
    {
        $total = $aporteInicial;
        $dados = array();
        for ($i = 1; $i <= $periodo; $i++) {
            $aporte = ($i == 1) ? 0 : $aporteMensal;
            $rendimento = ($total + $aporte) * ($rendimentoMensal / 100);
            $total += $aporte + $rendimento;
            if($i == 1){
                $aplicacao = $aporteInicial;
                $aplicacaoMes = $aplicacao;
            }
            else{
                $aplicacao = $total;
                $aplicacaoMes = $total -  $aporteMensal - $rendimento;
            }
                
            $dados[] = array('mes' => $i, 'aplicacao' => $aplicacao, 'aporte' => $aporte, 'rendimento' => $rendimento, 'total' => $total, 'aplicacaoMes' => $aplicacaoMes);
        }
        return array('dados' => $dados, 'total' => $total);
    }
}
