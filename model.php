<?php
session_start();
include('conn.php');
include('funcoes.php');


  if (
    !empty($_GET["nometarefa"])
    && !empty($_GET["descricao"])
    && !empty($_GET["datatarefa"])
    && !empty($_GET["prioridade"])
  ) {

    $nomeT = testar_valor($_GET["nometarefa"]);
    $descT = testar_valor( $_GET["descricao"]);
    $dataT = testar_valor($_GET["datatarefa"]);
    $priorT = testar_valor($_GET["prioridade"]);
    $id = $_SESSION["idUsuario"];

    $sql = "INSERT INTO 
    tab_tarefas(nomeTarefa,descTarefa,prazoTarefa,priorTarefa,idUsuario)
    VALUES('$nomeT','$descT','$dataT','$priorT','$id')";

    if (mysqli_query($conn, $sql)) {
      header('location:index.php?msg=cadok');
    } else {
      header('location:index.php?msg=caderro');
    }
  } else {
    header('location:index.php?msg=uperro1');
  }

