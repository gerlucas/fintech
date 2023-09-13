<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/processamento.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<body>
    <?php
    require_once 'classes/autoloader.class.php';
    R::setup('mysql:host=127.0.0.1;dbname=fintech', 'root', '');

    if (
        isset($_GET['nomeCliente']) && isset($_GET['aporteInicial']) &&
        isset($_GET['periodo']) && isset($_GET['rendimentoMensal']) &&
        isset($_GET['aporteMensal']) &&
        is_numeric($_GET['aporteInicial']) && is_numeric($_GET['periodo']) &&
        is_numeric($_GET['rendimentoMensal']) && is_numeric($_GET['aporteMensal'])
    ) {
        $nomeCliente = $_GET['nomeCliente'];
        $aporteInicial = $_GET['aporteInicial'];
        $periodo = $_GET['periodo'];
        $rendimentoMensal = $_GET['rendimentoMensal'];
        $aporteMensal = $_GET['aporteMensal'];

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
    } else {
        echo '<h2 class="erro"><i class="uil uil-exclamation-triangle"></i> Erro ao enviar os dados!</h2>';
        echo '<p class="erro">Por favor, preencha todos os campos com valores válidos/não nulos.</p>';
    }
    ?>
    <div class="dados" id="resultado">
        <?php if (isset($id)) : ?>
            <h1>ID: <?php echo $id ?></h1>
            <h1>Nome: <?php echo $nomeCliente ?></h1>
            <h1>Aporte Inicial: <?php echo number_format($aporteInicial, 2, ',', '.'); ?> (R$)</h1>
            <h1>Período: <?php echo $periodo ?> meses</h1>
            <h1>Rendimento Mensal: <?php echo number_format($rendimentoMensal, 2, ',', '.'); ?> (%)</h1>
            <h1>Aporte Mensal: <?php echo number_format($aporteMensal, 2, ',', '.'); ?> (R$)</h1>
            <h1>Total: <?php echo number_format($total, 2, ',', '.'); ?> (R$)</h1>
        <?php endif; ?>
    </div>
    <?php if (isset($dados) && !empty($dados)) : ?> 
    <table>
        <tr>
            <th>Mês</th>
            <th>Aplicação (R$)</th>
            <th>Rendimento (R$)</th>
            <th>Total (R$)</th>
        </tr>
        <?php if (isset($dados)) : ?>
            <?php foreach ($dados as $linha) : ?>
                <tr>
                    <td><?php echo $linha['mes']; ?></td>
                    <td><?php echo number_format($linha['aplicacaoMes'], 2, ',', '.'); ?></td>
                    <td><?php echo number_format($linha['rendimento'], 2, ',', '.'); ?></td>
                    <td><?php echo number_format($linha['total'], 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <?php endif; ?>
    <footer>
            <div class="icon-container">
                <a href="index.html" class="icon-link">
                    <i class="uil uil-estate"></i> <span class="text-icon">Página Inicial</span>
                </a>
            </div>
            <p>George Lucas e Gabriel Soares &copy; 2023</p>
        </footer>
</body>
</html>
