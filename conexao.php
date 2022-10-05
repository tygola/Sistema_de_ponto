<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ponto";


try{
    $conn = new PDO("mysql:host=$host;dbname=" . $dbname,
    $user, $pass);
    // echo "conexão com o banco de dados com sucesso";
} catch (PDOException $err) {
    echo "Erro: conexão com o banco não realizado com sucesso. Erro gerado " . $err->getMessage();
}

?>
