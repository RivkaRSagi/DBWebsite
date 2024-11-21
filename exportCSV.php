<?php

$data = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com'],
    ['id' => 3, 'name' => 'Sam Brown', 'email' => 'sam.brown@example.com']
];

//Path
$file = 'data.csv';

//Open file
$fp = fopen($file, 'w');

//Header Row
fputcsv($fp, ['ID', 'Name', 'Email']);

//Write Data
foreach ($data as $row)
{
    fputcsv($fp, $row);
}

//Close file
fclose($fp);

echo "Data has been exported to $file";
?>