<?php
//https://github.com/dzafel/pinterest-pinner

require "../config/config.php";
require "../vendor/autoload.php";

$pinterest = new PinterestPinner\Pinner;
$pinterestData = new PinterestPinnerData();

$boards = $pinterestData->showAvailablePinterestBoards();
echo "<pre>";
var_dump($boards);
echo "</pre>";

$pinterestData->loadInputData(INPUTFILE);
echo "<pre>";
var_dump($pinterestData->data);
echo "</pre>";

//$pinterestData->processData();



?>