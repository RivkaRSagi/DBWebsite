<?php

$data = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com'],
    ['id' => 3, 'name' => 'Sam Brown', 'email' => 'sam.brown@example.com']
];

//Export to JSON
header('Content-Type: application/json');

echo json_encode($data);

//Save data as JSON file
$file = 'data.json';
file_put_contents($file, json_encode($data));

echo "Data has been exported to $file";
?>
