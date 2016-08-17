<?php
//https://github.com/dzafel/pinterest-pinner

require "../config/config.php";
require "../vendor/autoload.php";

$pinterest = new PinterestPinner\Pinner;
$pinterestData = new PinterestPinnerData();

echo "<pre>\n";
$pinterestData->getAvailablePinterestBoards();
$pinterestData->displayBoards();

$pinterestData->loadInputData();
$pinterestData->displayData();

$pinterestData->readStatusEntry();
$pinterestData->displayStatus();

$pinterestData->displayWhatNeedsToBeDone();

$pinterestData->processData();
echo "</pre>\n";

?>