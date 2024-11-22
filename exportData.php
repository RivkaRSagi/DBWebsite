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
function exportToCSV($data)
{
    header('Content-Type: text/csv');

    //Download file name
    header('Content-Disposition: attachment; filename="data.csv"');

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
    return $file;
}

//Export to PDF
function exportToPDF()
{

}

?>
