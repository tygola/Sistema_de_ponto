<?php
session_start();

ob_start();

date_default_timezone_set("America/Sao_Paulo");

$horario_atual = date("H:i:s");
// var_dump($horario_atual);

$data_entrada = date('Y/m/d');


include_once "conexao.php";

$id_usuario = 1;

$query_ponto =  "SELECT id AS id_ponto,saida_intervalo, retorno_intervalo, saida 
                     FROM pontos
                     WHERE usuario_id =:usuario_id
                     ORDER BY id DESC
                     LIMIT 1";

$result_ponto = $conn->prepare($query_ponto);

$result_ponto->bindParam(':usuario_id', $id_usuario);

$result_ponto->execute();

if(($result_ponto) and ($result_ponto->rowCount() != 0)) {
   $row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC);
    // var_dump($row_ponto);
    extract($row_ponto);

    if(($saida_intervalo == "") or ($saida_intervalo == null)){
        $col_tipo_registro = "saida_intervalo";
        $tipo_registro = "editar";
        $text_tipo_registro = "saida intervalo";

    }elseif(($retorno_intervalo == "") or ($retorno_intervalo == null)){
        $col_tipo_registro = "retorno_intervalo";
        $tipo_registro = "editar";
        $text_tipo_registro = "retorno intervalo";

    }elseif(($saida == "") or ($saida == null)){
        $col_tipo_registro = "saida";
        $tipo_registro = "editar";
        $text_tipo_registro = "saida";
        
    }else {
        $tipo_registro = "entrada";
        $text_tipo_registro = "entrada";
        
    }

} else{
        $tipo_registro = "entrada";
        $text_tipo_registro = "entrada";
}

switch($tipo_registro){
    case "editar":
        $query_horario = "UPDATE pontos SET $col_tipo_registro =:horario_atual
                        WHERE id=:id
                        LIMIT 1";
        $cad_horario = $conn->prepare($query_horario);
        $cad_horario->bindParam(':horario_atual', $horario_atual);
        $cad_horario->bindParam(':id', $id_ponto);
        break;
    default:
    $query_horario = "INSERT INTO pontos (data_entrada, entrada, usuario_id) VALUES (:data_entrada, :entrada, :usuario_id)";

    $cad_horario = $conn->prepare($query_horario);
    
    $cad_horario->bindParam(':data_entrada', $data_entrada);
    $cad_horario->bindParam(':entrada', $horario_atual);
    $cad_horario->bindParam(':usuario_id', $id_usuario);

    break;
}

$cad_horario->execute();

if($cad_horario->rowCount()){
    $_SESSION['msg'] = "<p style='color: green;'>Horário de $text_tipo_registro cadastrado com sucesso!</p>";
    header("Location: index.php");
}else{
    $_SESSION['msg'] = "<p style='color: #f00;'>Horário de $text_tipo_registro não cadastrado com sucesso!</p>";
    header("Location: index.php");
}