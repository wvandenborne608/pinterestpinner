<?php

class PinterestPinnerData {
    public $boards = null;
    public $data = null;
    public $status = null;

    public function __construct()
    {

    }


    public function displayBoards() {
		echo "AVAILABLE PINTEREST BOARDS:\n";
        if ($this->boards == null)
       	  echo "No boards found!\n";
        else {
          foreach ($this->boards as $key => $value) {
          	echo "* $key -> $value\n";
          }
       	}
       	echo "---\n";
    } //end function


    public function displayData() {
		echo "AVAILABLE DATA:\n";
        if ($this->data == null)
       	  echo "No data found!\n";
        else {
          foreach ($this->data as $key => $value) {
          	echo "* ItemID: " . $value['ItemID'] . " (" . $value['Title'] .") [" . $value['Status'] ."]\n";
          }
       	}
       	echo "---\n";
    } //end function


    public function displayStatus() {
		echo "ALREADY PINNED ITEMS (STATUS):\n";
        if ($this->status == null)
       	  echo "No status found!\n";
        else {
          foreach ($this->status as $key => $value) {
          	echo "* ItemID: " . $key . " (PinID: " . $value . ")\n";
          }
       	}
       	echo "---\n";
    } //end function    


    public function displayWhatNeedsToBeDone() {
		echo "WHAT NEEDS TO BE DONE:\n";
        foreach ($this->data as $data_key => $data_value) {
        	if ($data_value['Status'] == "todo") {
        		if (is_array($this->status)) {
		        	if (!array_key_exists( $data_value['ItemID'] , $this->status)) {
		        	   echo "* ItemID: " . $data_value['ItemID'] . " (" . $data_value['Title'] .") \n";
					}
        		} else {
	        	   echo "* ItemID: " . $data_value['ItemID'] . " (" . $data_value['Title'] .") \n";
				}
			}
        }
       	echo "---\n";
    } //end function  



    public function readStatusEntry() {
		$lines = file(LOGFILE);
		foreach ($lines as $line_num => $line) {
		    $items = explode ("|", $line);
		    $this->status[ trim( $items[1] ) ]=trim( $items[2] );
		}
    }


    public function writeStatusEntry($itemID, $pinID) {
    	$log = date("F j, Y, g:i a")."|$itemID|$pinID".PHP_EOL;
		$current = file_get_contents(LOGFILE);
		file_put_contents(LOGFILE, $current.$log);
		echo $log . "\n";
    }


    public function getAvailablePinterestBoards() {
    	$boards = null;
		try {
		    $pinterest = new PinterestPinner\Pinner;
		    $boards = $pinterest->setLogin(PINTERESTUSER)
		              ->setPassword(PINTERESTPASS)
		              ->getBoards();
		} catch (PinterestPinner\PinnerException $e) {
		    echo "Fatal error. Script halted.";
			if (strpos( $e->getMessage() , "429 Unknown") > 1) echo " Too many connections. Try again later. (Estimated requests is 30 per hour.)";
			die();
		}
		$this->boards=$boards;
	} //end function


    public function processData() {
        foreach ($this->data as $data_key => $data_value) {
        	if ($data_value['Status'] == "todo") {
	        	if (!array_key_exists( $data_value['ItemID'] , $this->status)) {
	        	   echo "* ItemID: " . $data_value['ItemID'] . " (" . $data_value['Title'] .") \n";
					try {
					    $pinterest = new PinterestPinner\Pinner;
					    $pin_id = $pinterest->setLogin(PINTERESTUSER)
						        ->setPassword(PINTERESTPASS)
						        ->setBoardID($data_value['BoardID'])
						        ->setImage(DOMAIN . '/images/' . $data_value['ItemID'] . '.png')
						        ->setDescription($data_value['Description'] . " (" .$data_value['Extra Info']. ") " . $data_value['URL'])
						        ->setLink($data_value['URL'])
						        ->pin();
					} catch (PinterestPinner\PinnerException $e) {
						echo "Fatal error. Script halted.";
						if (strpos( $e->getMessage() , "429 Unknown") > 1) echo " Too many connections. Try again later. (Estimated requests is 30 per hour.)";
						die();
					}
					$this->writeStatusEntry($data_value['ItemID'], $pin_id);
				}
			}
        }
    }


    public function loadInputData()
    {
		$array = $fields = array(); $i = 0;
		$handle = @fopen(INPUTFILE, "r");
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