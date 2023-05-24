<?php
session_start();
require 'vendor/autoload.php';
include 'conn.php';

$sqlNome = "SELECT * FROM tab_usuarios";
$result2 = mysqli_query($conn, $sqlNome);

$idU = $_SESSION["idUsuario"];
$nomeu = $_SESSION["usuario"];

$sqlRelatorio = "SELECT * FROM tab_tarefas
WHERE idUsuario='$idU' AND statusTarefa='1'
";

$result = mysqli_query($conn, $sqlRelatorio);
$numTarefas = mysqli_num_rows($result);

$htmlRel = "<h1>Relatorio de Tarefas Finalizadas! <br>
                Usuario:$nomeu <br>
                Quantidade de tarefas:$numTarefas <br></h1>";


while ($linha = mysqli_fetch_assoc($result)) {
    $nome = $linha["nomeTarefa"];
    $desc = $linha["descTarefa"];
    $prazo = $linha["prazoTarefa"];
    $prior = $linha["priorTarefa"];
    $status = $linha["statusTarefa"];
    $status = "Tarefa Finalizada";


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
                 <strong>Prioridade:</strong>$prior <br>";
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
