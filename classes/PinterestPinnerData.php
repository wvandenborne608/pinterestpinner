<?php

class PinterestPinnerData {
    public $data = null;

    public function __construct()
    {

    }

    public function showAvailablePinterestBoards() {
    	$boards = null;
		try {
		    $pinterest = new PinterestPinner\Pinner;
		    $boards = $pinterest->setLogin(PINTERESTUSER)
		              ->setPassword(PINTERESTPASS)
		              ->getBoards();
		} catch (PinterestPinner\PinnerException $e) {
		    echo $e->getMessage();
		}
		return $boards;
	} //end function


    public function processData() {
    	foreach ($this->data as &$item) {

    		try {
    			echo "Attempting to pin item: " . $item['URL'] ."<br/>\n";
			    $pinterest = new PinterestPinner\Pinner;
			    $pin_id = $pinterest->setLogin(PINTERESTUSER)
				        ->setPassword(PINTERESTPASS)
				        ->setBoardID($item['BoardID'])
				        ->setImage(DOMAIN . '/images/' . $item['ItemID'] . '.png')
				        ->setDescription($item['Description'] . " (" .$item['Extra Info']. ") " . $item['URL'])
				        ->setLink($item['URL'])
				        ->pin();
				echo "Finished (pin_id: " . $pin_id .")<br/>\n<br/>\n";        
			} catch (PinterestPinner\PinnerException $e) {
			    echo $e->getMessage();
			}

		}
    }


    public function loadInputData($filename)
    {
		$array = $fields = array(); $i = 0;
		$handle = @fopen($filename, "r");
		if ($handle) {
		    while (($row = fgetcsv($handle, 4096)) !== false) {
		        if (empty($fields)) {
		            $fields = $row;
		            continue;
		        }
		        foreach ($row as $k=>$value) {
		            $array[$i][$fields[$k]] = $value;
		        }
		        $i++;
		    }
		    if (!feof($handle)) {
		        echo "Error: unexpected fgets() fail\n";
		        die();
		    }
		    fclose($handle);
		}
		$this->data = $array;
    } //end function



}
?>