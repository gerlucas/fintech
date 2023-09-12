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
            $dados[] = array('mes' => $i, 'inicial' => $aporteInicial, 'aporte' => $aporte, 'rendimento' => $rendimento, 'total' => $total);
        }
        return array('dados' => $dados, 'total' => $total);
    }
}
