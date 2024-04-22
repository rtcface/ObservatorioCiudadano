<?php
include './api-google/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=./credentials.json');
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->SetScopes(['https://wwww.googleapis.com/auth/drive/drive.file']);
try {
    //code...
    $drive = new Google_Service_Drive($client);
    $file_path = './test.png';
    $file = new Google_Service_Drive_DriveFile();
    $file->setName('test.png');
    $file->setParents(array("1n4JT1pO1-CU0DDTIoLch2r9RWvFVH8r4"));
    $file->setDescription('test.png');
    $file->setMimeType('image/png');
    $result = $drive->files->create(
        $file, array(
            'data' => file_get_contents($file_path),
            'mimeType' => 'image/png',
            'uploadType' => 'media')
        );
} catch (Google_Sevice_Exception $gs) {
    //throw $th;
    $message = json_decode($gs->getMessage());)
    echo $message->error->message;
} catch (Exception $e) {
    //throw $th;
    echo $e->getMessage();
}