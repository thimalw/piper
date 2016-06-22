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