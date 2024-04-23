<?php


function uploadFile($file_path,$file_name,$file_type){
    include './api-google/vendor/autoload.php';
    putenv('GOOGLE_APPLICATION_CREDENTIALS=credentials.json');
    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->SetScopes(['https://www.googleapis.com/auth/drive.file']);
    try {
        $drive = new Google_Service_Drive($client);
        //$file_path = $_FILES['Ine']['tmp_name'];
        $file = new Google_Service_Drive_DriveFile();
        $file->setName($file_name);//
        $file->setParents(array("1n4JT1pO1-CU0DDTIoLch2r9RWvFVH8r4"));////19w2fZbkL4ggUWpt5Kjc7nultWOIbXZ4f
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file_path);
        $file->setMimeType($mime_type);
    
        
        $result = $drive->files->create(
            $file, array(
                'data' => file_get_contents($file_path),
                'mimeType' => $mime_type,
                'uploadType' => $file_type)
            );
        
       
    return $result->id;

       
        
    } catch (Google_Sevice_Exception $gs) {

        $message = json_decode($gs->getMessage());
        echo $message->error->message;
    } catch (Exception $e) {
        //throw $th;
        echo $e->getMessage();
    }
}