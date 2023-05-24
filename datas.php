<?php
//definir o fuso horario
date_default_timezone_set("America/Sao_Paulo");
//Horas e minutos
//echo date('H:i:s')."<br>";
//dia
// echo date('d/m/y')."<br>";

// mktime
// $datamk = mktime(00,00,00,01,01,1970);
// echo "Data Criada com o mktime= ".date("d-m-Y",$datamk)."<br>";

// echo ($datamk - 10800);

// //diff
// $data1 = date_create("2023-01-01");
// $data2 = date_create("2023-02-01");
// $diff = date_diff($data1,$data2);

// echo $diff->format("Total de diferença em dias= %a.");

//exemplo para pegar os proximos dias
// $datainicial = strtotime("Saturday");
// $datafinal = strtotime("+10 weeks", $datainicial);

// while($datainicial < $datafinal){
//     echo date("d-m",$datainicial)."<br>";
//     $datainicial = strtotime("+1 week", $datainicial);
// }

$dataHoje = new DateTime('now');
$dataf = $dataHoje->format('Y-m-d');
$dataFinal = strtotime("+1 week", time());
$dataFinalObj = new DateTime(date('Y-m-d',$dataFinal));
$datafinalf = $dataFinalObj->format('Y-m-d');

echo $dataf;
echo $datafinalf;