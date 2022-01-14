<?php

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$raw_data = json_decode($json, true);

$valid = false;

//A PHP array containing the data that we want to log.
$dataToLog = array(
    
    date("Y-m-d H:i:s"), //Date and time
    $_SERVER['REMOTE_ADDR'], //IP address
    $raw_data['name'], 
    $raw_data['email'],
    GUID(), //ID used to verify entry
    
);
if(filter_var($raw_data['email'], FILTER_VALIDATE_EMAIL)){
    if($valid == false)
        $valid = true;

    // print("email valid: " . $raw_data['email']. PHP_EOL);
} else {
    // print("email NOT valid: " . $raw_data['email'] . PHP_EOL);
}
$data = implode(" , ", $dataToLog);

// var_dump($data); 
if($valid)
    echo('{"message": "success" }');

//Add a newline onto the end.
$data .= PHP_EOL;

//The name of your log file.
$pathToFile = 'mylogname.log';

//Log the data to your file using file_put_contents.
if($valid){
    file_put_contents($pathToFile, $data, FILE_APPEND);
}
    


function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}