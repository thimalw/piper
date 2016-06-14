<?php

define( 'ABS_DIR', dirname(__FILE__) . '/' );
define( 'ABS_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/piper' );

function compress_png($path_to_png_file, $max_quality = 90)
{
    if (!file_exists($path_to_png_file)) {
        throw new Exception("File does not exist: $path_to_png_file");
    }

    // guarantee that quality won't be worse than that.
    $min_quality = 60;

    // '-' makes it use stdout, required to save to $compressed_png_content variable
    // '<' makes it read from the given file path
    // escapeshellarg() makes this safe to use with any path
    $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - < ".escapeshellarg($path_to_png_file));

    if (!$compressed_png_content) {
        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
    }

    return $compressed_png_content;
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    $target_dir = "uploads/";
    $save_to_path = $target_dir . basename($_FILES["uploadFile"]["name"]);

    $read_from_path = $_FILES['uploadFile']['tmp_name'];
    $extention = pathinfo($save_to_path, PATHINFO_EXTENSION);

    if ($extention == "png") {
        $compressed_png_content = compress_png($read_from_path);
        file_put_contents($save_to_path, $compressed_png_content);
        echo ABS_URL.'/'.$save_to_path;
    }

} else {
    header('Location: '.ABS_URL);
    die();
}

