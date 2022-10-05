<?php

session_start();

date_default_timezone_set("America/Sao_Paulo");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Sistema de ponto</title>
</head>
<body>
    <br>
    <h2>Registro de ponto</h2>
    <br>
    <hr>

    <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    ?>

    <div class="conteiner">
    <p id="horario"><?php  echo date("d/m/Y H:i:s"); ?></p>
        <br>
    <a href="registrar_ponto.php">Registrar</a><br>
    </div>

    <script>
        function atulizarHorario(){
            var data = new Date().toLocaleString("pt-br", {
                timeZone: "America/Sao_Paulo"
            });
            document.getElementById("horario").innerHTML = data.replace(", ", " - ");
        }
        setInterval(atulizarHorario, 1000);
    </script>
</body>
</html>