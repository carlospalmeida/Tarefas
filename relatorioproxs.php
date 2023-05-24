<?php
session_start();
require 'vendor/autoload.php';
include 'conn.php';


$dataHoje = new DateTime('now');
$dataf = $dataHoje->format('Y-m-d');
$dataFinal = strtotime("+8 days", time());
$dataFinalObj = new DateTime(date('Y-m-d',$dataFinal));
$datafinalf = $dataFinalObj->format('Y-m-d');

$idU = $_SESSION["idUsuario"];
$nomeu = $_SESSION["usuario"];

$sqlRelatorio = "SELECT * FROM tab_tarefas 
WHERE idUsuario='$idU'
AND statusTarefa='0' 
AND prazoTarefa >= '$dataf' 
AND prazoTarefa < '$datafinalf'";


$result = mysqli_query($conn, $sqlRelatorio);
$numTarefas = mysqli_num_rows($result);

$htmlRel = "<h1>Relatorio de Tarefas em aberto na data atual! <br>
                Usuario:$nomeu <br>
                Quantidade de tarefas:$numTarefas <br></h1>";


while ($linha = mysqli_fetch_assoc($result)) {
    $nome = $linha["nomeTarefa"];
    $desc = $linha["descTarefa"];
    $prazo = $linha["prazoTarefa"];
    $prior = $linha["priorTarefa"];
    $status = $linha["statusTarefa"];
    $status = "Tarefa em aberto";

    $dataHoje = new DateTime('now');
    $dataf = $dataHoje->format('Y-m-d');
    $dataFinal = strtotime("+1 week", time());
    $dataFinalObj = new DateTime(date('Y-m-d',$dataFinal));
    $datafinalf = $dataFinalObj->format('Y-m-d');
    if ($linha["priorTarefa"] == 1) {
        $prior = "Baixa";
    } else if ($linha["priorTarefa"] == 2) {
        $prior = "Média";
    } else {
        $prior = "Alta";
    }

    $htmlRel .= "<p> <strong>Nome da Tarefa:</strong>$nome<br>
                     <strong>Descrição:</strong>$desc <br>
                     <strong>Prazo da tarefa:</strong>$prazo <br>
                     <strong>Prioridade:</strong>$prior <br> 
                     <strong>Status:</strong>$status </p>";
}

// Instancia a classe
use Dompdf\Dompdf;

$dompdf = new Dompdf();

$dompdf->loadHtml($htmlRel);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Gera o PDF
//$dompdf->stream();
$dompdf->stream(
    "saida.pdf", // Nome do arquivo de saída 
    array(
        "Attachment" => false // Para download, altere para true 
    )
);
