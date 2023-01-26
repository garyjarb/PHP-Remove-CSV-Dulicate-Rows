<?php
ini_set('memory_limit', '1024M'); // or you could use 1G
/*
Read multiple csv files and remove all duplicate values on multiple rows, and update the csv files with the unique values.
CSV files must have the following naming structure index-x.csv / You can always change this name structure below.
*/
$firstCharacter = "a";
while (strlen($firstCharacter)==1) {

  $csv = 'index-'.$firstCharacter.'.csv';
  
  if (file_exists($csv)) {
    echo $csv . '<br />';
    $data = parse($csv);
    $unique = unique($data);
    update($unique,$csv);
  }
$firstCharacter++; //get the next character
  
}

$firstCharacter = 0; 
while ($firstCharacter<10) {

  $csv = 'index-'.$firstCharacter.'.csv';
  
  if (file_exists($csv)) {
    echo $csv . '<br />';
    $data = parse($csv);
    $unique = unique($data);
    update($unique,$csv);
  }
$firstCharacter++; //get the next character

}


// Read data from csv and return data
function parse($csv) {
	$data = [];
	$data = array_map('str_getcsv', file($csv));
  
	return $data;
}


// Remove duplicate values from data
function unique(array $data = []) {
	$serialized = array_map('serialize', $data);
	
	
	
	$result = [];

	foreach ($serialized as $key => $val) {
	    $result[$val] = true;
	}

	return array_map('unserialize', (array_keys($result)));
}

// Update csv with unique data
function update(array $unique = [], $csv) {
	$fp = fopen($csv, 'w');

	foreach($unique as $fields) {
    
		//fputcsv($fp, $fields);
		fwrite($fp, implode(',', $fields) . "\r\n");
	}

	fclose($fp);
	echo "Done!".PHP_EOL;
}

?>