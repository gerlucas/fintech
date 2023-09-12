<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overmind</title>
</head>

<body>
    <main>
        <h1>Overmind</h1>

        <ul>

            <?php
            $paginas = [
                'entrada.html' => 'Simulação',
                'historico.php' => 'Historico'
            ];

            $link = '<li><a href="%s">%s<a/></li>';

            foreach ($paginas as $pagina => $titulo) {
                printf($link, $pagina, $titulo);
            }
            ?>

        </ul>
    </main>

    <footer>
        <p>George Lucas e Gabriel Soares &copy; 2023</p>
    </footer>
</body>

</html>