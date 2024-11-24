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
function exportToCSV($header, $data, $fileName)
{
    //Path
    $file = $fileName . ".csv";
    header("Content-Type: text/csv");
    header('Content-Disposition: attachment; filename="' . $file . '"');

    //Open file to output stream
    $fp = fopen('php://output', 'w');

    //Header Row
    fputcsv($fp, $header);

    //Write Data
    foreach ($data as $row)
    {
        fputcsv($fp, $row);
    }

    //Close file
    fclose($fp);
}
?>
