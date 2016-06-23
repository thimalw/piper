<?php

function unzip($zip_file_path, $name) {
    $home_folder = dirname(__FILE__)."/uploads/zip/extracted/$name";
    $zip = new ZipArchive;
    $res = $zip->open($zip_file_path);
    
    if ($res) {
        @mkdir($home_folder, 0700, true);

        for($i = 0; $i < $zip->numFiles; $i++)
        {
            $full_path = $zip->statIndex($i);
            if ($full_path['name'][strlen($full_path['name'])-1] =="/")
            {
                @mkdir($home_folder."/".$full_path['name'],0700,true);
            }
        }

        for($i=0; $i<$zip->numFiles; $i++) {
            $file_name = $zip->getNameIndex($i);
            $full_path = $zip->statIndex($i);
            if($full_path['size'] != 0) {
                copy('zip://'.$zip_file_path.'#'.$file_name, $home_folder.'/'.$full_path['name']);
                echo  "Copied to : " . $home_folder.'/'.$full_path['name'] . "<br/>";

            }
        }

        $zip->close();
    }
}

function getExtension($file) {
    return pathinfo($file, PATHINFO_EXTENSION);
}

function processUpload($file) {
    $target_dir = 'uploads/';
    $save_to_path = $target_dir . basename($file["name"]);
    $name = basename($file["name"]);

    $read_from_path = $file['tmp_name'];
    $extention = pathinfo($save_to_path, PATHINFO_EXTENSION);

    //echo "Read from path : $save_to_path";

    if ($extention == "png") {
        $compressed_png_content = compress_png($read_from_path);
        file_put_contents($save_to_path, $compressed_png_content);

        // echo the uploaded file URL
        // echo ABS_URL.'/'.$save_to_path;
        $file_url = ABS_URL.'/'.$save_to_path;
        // echo json_encode(['file_url' => $file_url, 'file_name' => $name]);
        return array('file_url' => $file_url, 'file_name' => $name);
    }

    else if($extention == "zip") {
        //echo "zip file  $read_from_path <br/>";
        extract_from_zip($read_from_path, $name);
    }
}

function reArrayFiles(&$file_post) {
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
