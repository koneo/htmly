<?php

$whitelist = array('jpg', 'jpeg', 'png', 'gif');
$name      = null;
$dir       = 'content/images/';
$error     = null;
$timestamp = date('YmdHis');
$path      = null;

if (is_dir($dir)) {
} else {
    mkdir($dir, 0755, true);
}

if (isset($_FILES)) {
    if (isset($_FILES['file'])) {
        $tmp_name = $_FILES['file']['tmp_name'];
        $name     = basename($_FILES['file']['name']);
        $error    = $_FILES['file']['error'];
        $path     = $dir . $timestamp . '-' . $name;
		
        $check = getimagesize($tmp_name);
		
        if($check !== false) {
            if ($error === UPLOAD_ERR_OK) {
                $extension = pathinfo($timestamp . '-' . $name, PATHINFO_EXTENSION);
                if (!in_array($extension, $whitelist)) {
                    $error = 'Invalid file type uploaded.';
                } else {
                    move_uploaded_file($tmp_name, $dir . $timestamp . '-' . $name);
                }
            }
        }
        else {
            $error = "File is not an image.";
        }
    }
}

echo json_encode(array(
    'path' => $path,
    'name'  => $name,
    'error' => $error,
));
die();
