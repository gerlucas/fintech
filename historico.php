<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overmind</title>
    <link rel="stylesheet" href="./css/processamento.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>

<body>
    <header>
        <h5>Recuperar Simulação por ID</h5>
    </header>

    <form method="post" action="">
        <fieldset>
            <legend>Recupere sua simulação</legend>
            <label for="id">ID da simulação:</label>
            <input type="text" name="id" id="id">
            <input type="submit" class="input-botao" value="Recuperar">
        </fieldset>

        </div>

        <?php
        require_once 'classes/autoloader.class.php';
        R::setup('mysql:host=127.0.0.1;dbname=fintech', 'root', '');

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $simulation = R::load('simulation', $id);
            if ($simulation->id) {
        ?>

                <div class="dados" id="resultado">
                    <h1>ID: <?php echo $id ?></h1>
                    <h1>Nome: <?php echo $simulation->cliente ?></h1>
                    <h1>Aporte Inicial: <?php echo number_format($simulation->aporteInicial, 2, ',', '.'); ?> (R$)</h1>
                    <h1>Período: <?php echo $simulation->periodo ?> meses</h1>
                    <h1>Rendimento Mensal: <?php echo number_format($simulation->rendimentoMensal, 2, ',', '.'); ?> (%)</h1>
                    <h1>Aporte Mensal: <?php echo number_format($simulation->aporteMensal, 2, ',', '.'); ?> (R$)</h1>
                    <h1>Total: <?php echo number_format($simulation->total, 2, ',', '.'); ?> (R$)</h1>
                </div>
                <table>
                    <tr>
                     <th>Mês</th>
                     <th>Aplicação (R$)</th>
                     <th>Rendimento (R$)</th>
                     <th>Total (R$)</th>
                    </tr>

                    <?php
                    $dados = Util::calcularRendimento($simulation->aporteInicial, $simulation->periodo, $simulation->rendimentoMensal, $simulation->aporteMensal)['dados'];
                    foreach ($dados as $linha) :

                    ?>
                        <tr>
                         <td><?php echo $linha['mes']; ?></td>
                         <td><?php echo number_format($linha['aplicacaoMes'], 2, ',', '.'); ?></td>
                         <td><?php echo number_format($linha['rendimento'], 2, ',', '.'); ?></td>
                         <td><?php echo number_format($linha['total'], 2, ',', '.'); ?></td>
                        </tr>

                    <?php endforeach; ?>
                </table>
        <?php } else {
                echo '<p class="id-invalida">ID de simulação inexistente.</p>';
            }
        }
        ?>
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