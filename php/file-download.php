<?php

include '../classes/classes.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);

function readfile_chunked($filename, $retbytes = true) {
    $chunksize = 1 * (1024 * 1024); // how many bytes per chunk
    $buffer = '';
    $cnt = 0;
    // $handle = fopen($filename, 'rb');
    $handle = fopen($filename, 'rb');
    if ($handle === false) {
        return false;
    }
    while (!feof($handle)) {
        $buffer = fread($handle, $chunksize);
        echo $buffer;
        ob_flush();
        flush();
        if ($retbytes) {
            $cnt += strlen($buffer);
        }
    }
    $status = fclose($handle);
    if ($retbytes && $status) {
        return $cnt; // return num. bytes delivered like readfile() does.
    }
    return $status;

}

function create_zip($files = array(), $destination = '', $overwrite = false) {
    //if the zip file already exists and overwrite is false, return false
    if (file_exists($destination) && !$overwrite) {
        return false;
    }
    //create the archive
    $zip = new ZipArchive();
    echo 'before';
    if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
        return false;
    }
    echo 'hi';
    //add the files
    foreach ($files as $file) {
        $zip->addFile($file, $file);
    }
    //debug
    //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

    //close the zip -- done!
    $zip->close();

    //check to make sure the file exists
    return file_exists($destination);
}

$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
$file_type = filter_var($_GET['file-type'], FILTER_SANITIZE_STRING);
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

if ($type == 'extended') {
    $data = new Extended_Data();
    $data->getByID($id);
    $file = '../upload/extended-data/' . $data->file;
    $fileName = $data->file;
} elseif ($type == 'zip') {
    $holder = new Extended_Data();
    $files = $holder->getByData($id, true);
    foreach ($files[$file_type] as $file) {
        $fileArray[] = '../upload/extended-data/' . $file->file;
    }
    print_r($fileArray);
    $fileName = rand(0, 10000000) . '.zip';
    $return = create_zip($fileArray, '../upload/zips/' . $name,true);
    $file = '../upload/zips/' . $name;
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $fileName);
header('Pragma: no-cache');
ob_clean();
flush();
readfile_chunked($file);
// You need to exit after that or at least make sure that anything other is not echoed out:
?>