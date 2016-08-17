<?php
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
if (htmlspecialchars($_GET["action"])=="go") $pinterestData->processData();
echo "[<a href='index.php?action=go'>go</a>]";

echo "</pre>\n";
?>