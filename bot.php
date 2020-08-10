<?php

$path = "https://api.telegram.org/botTOKENHERE";
 
$update = json_decode(file_get_contents("php://input"), TRUE);
 
$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

if (strpos($message, "/start") === 0) {
	file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Ready!");
}

if (strpos($message, "/corona") === 0) {

	$covidJSONSrc = file_get_contents("https://api.covid19api.com/summary");
	$covidJSON = json_decode($covidJSONSrc);

	$newConfirmedCases = number_format($covidJSON->Global->NewConfirmed);
	$totalConfirmedCases = number_format($covidJSON->Global->TotalConfirmed);
	$newDeaths = number_format($covidJSON->Global->NewDeaths);
	$totalDeaths = number_format($covidJSON->Global->TotalDeaths);
	$newRecoveries = number_format($covidJSON->Global->NewRecovered);
	$totalRecoveries = number_format($covidJSON->Global->TotalRecovered);
	$dateUpdate = date("d/m/Y H:i:s", strtotime($covidJSON->Date));

	file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=🌍 *Global COVID-19 Statistics*%0A😷 Total Confirmed Cases: ".$totalConfirmedCases." (📈 ＋".$newConfirmedCases." New Cases)%0A💀 Total Deaths: ".$totalDeaths." (📈 ＋".$newDeaths." New Deaths)%0A💪 Total Recoveries: ".$totalRecoveries." (📈 ＋".$newRecoveries." New Recoveries)%0A%0ALast Updated: ".$dateUpdate."&parse_mode=markdown");
}

?>