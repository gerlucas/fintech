<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'classes/autoloader.class.php';
    R::setup('mysql:host=127.0.0.1;dbname=overmind_fintech', 'root', '');

    if (isset($_GET['nomeCliente']) && isset($_GET['aporteInicial']) && isset($_GET['periodo']) && isset($_GET['rendimentoMensal']) && isset($_GET['aporteMensal'])) {
        $nomeCliente = $_GET['nomeCliente'];
        $aporteInicial = $_GET['aporteInicial'];
        $periodo = $_GET['periodo'];
        $rendimentoMensal = $_GET['rendimentoMensal'];
        $aporteMensal = $_GET['aporteMensal'];
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }

    $dadosRendimento = Util::calcularRendimento($aporteInicial, $periodo, $rendimentoMensal, $aporteMensal);
    $dados = $dadosRendimento['dados'];
    $total = $dadosRendimento['total'];

    if (isset($_GET['nomeCliente']) && isset($_GET['aporteInicial']) && isset($_GET['periodo']) && isset($_GET['rendimentoMensal']) && isset($_GET['aporteMensal'])) {
        $simulation = R::dispense('simulation');

        $simulation->cliente = $nomeCliente;
        $simulation->aporteInicial = number_format($aporteInicial, 2, '.', ''); 
        $simulation->periodo = $periodo;
        $simulation->rendimentoMensal = number_format($rendimentoMensal, 2, '.', ''); 
        $simulation->aporteMensal = number_format($aporteMensal, 2, '.', ''); 
        $simulation->total = number_format($total, 2, '.', '');

        $id = R::store($simulation);

        R::close();
    }

    ?>
    <div class="dados">
        <h1>Nome: <?php echo $nomeCliente ?></h1>
        <h1>Aporte Inicial: <?php echo number_format($aporteInicial, 2, ',', '.'); ?> (R$)</h1>
        <h1>Período: <?php echo $periodo ?> meses</h1>
        <h1>Rendimento Mensal: <?php echo number_format($rendimentoMensal, 2, ',', '.'); ?> (%)</h1>
        <h1>Aporte Mensal: <?php echo number_format($aporteMensal, 2, ',', '.'); ?> (R$)</h1>
        <h1>Total: <?php echo number_format($total, 2, ',', '.'); ?> (R$)</h1>
    </div>
    <table>
        <tr>
            <th>Mês</th>
            <th>Valor Inicial (R$)</th>
            <th>Aporte (R$)</th>
            <th>Rendimento (R$)</th>
            <th>Total (R$)</th>
        </tr>
        <?php foreach ($dados as $linha) : ?>
            <tr>
                <td><?php echo $linha['mes']; ?></td>
                <td><?php echo number_format($linha['inicial'], 2, ',', '.'); ?></td>
                <td><?php echo number_format($linha['aporte'], 2, ',', '.'); ?></td>
                <td><?php echo number_format($linha['rendimento'], 2, ',', '.'); ?></td>
                <td><?php echo number_format($linha['total'], 2, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>