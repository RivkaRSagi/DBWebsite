<?php

//Export to JSON
function exportToJSON($data)
{
    //header('Content-Type: application/json');

    //echo json_encode($data);

    //Save data as JSON file
    //$file = 'data.json';
    //file_put_contents($file, json_encode($data));

    //echo "Data has been exported to $file";
    return json_encode($data);
}

//Export to CSV
function exportToCSV( $data, $fileName)
{
    //Path
    $file = $fileName . ".csv";

    //Open file to output stream
    $fp = fopen($file, 'w');

    //Write Data
    foreach ($data as $row)
    {
        fputcsv($fp, $row);
        echo $row;
    }

    //Close file
    fclose($fp);
    echo $data;

    //header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
header("Content-Type: text/csv");
readfile($file);
echo $data;
}
?>
