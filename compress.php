<?php

define( 'ABS_DIR', dirname(__FILE__) . '/' );
define( 'ABS_URL', 'http://' . $_SERVER['HTTP_HOST'] );

include("functions.php");

if ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {

    // if (isset($_FILES['files'][1])) {
        // loop through each uploaded file

    $files = reArrayFiles($_FILES['files']);

    $respondArray = array();

    foreach ($files as $file) {
        $upload_results = processUpload($file);
        if (!empty($upload_results)) {
            array_push($respondArray, $upload_results);
        }
    }

    echo json_encode($respondArray);

    // } else {        
    //     echo json_encode(['itsalooop'=>'nuuu']);
    //     processUpload($_FILES['files']);
    // }    
    

} else {
    header('Location: '.ABS_URL);
    die();
}

function extract_from_zip($zipfile, $name) {
    //For each file in zip
    //Check extenstion
    //Add to local path
    //Compress
    unzip($zipfile, $name);
}
