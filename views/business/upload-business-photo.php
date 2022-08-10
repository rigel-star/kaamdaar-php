<?php 
session_start();

function respondWithHttpError($error, ?string $msg)
{
    $errors = [404 => "Not Found", 500 => "Internal Server Error"];
    header("HTTP/1.1 $error " . ($msg ? $msg : $errors[$error]));
}

// Immediate function to execute file upload
(function () {
    if(isset($_FILES['bphoto']))
    {
        $file_type = $_FILES['bphoto']['type'];
        $file_type_info = explode("/", "$file_type");
        $file_ext = end($file_type_info);
        $src_addr = $_FILES['bphoto']['tmp_name'];

        $allowed_types = ['jpg', 'jpeg', 'gif', 'png'];
        if(!in_array($file_ext, $allowed_types))
        {
            echo "false";
            return;
        }

        $base_url = $_SERVER['DOCUMENT_ROOT'] . "/kaamdaar-php";

        if(!isset($_POST['bid']) || !isset($_POST['btype']))
        {
            echo "false";
            return;
        }

        $business_id = $_POST['bid'];
        $btype = $_POST['btype'];

        $business_dir_path = "$base_url/uploads/business/$business_id";
        if(!file_exists($business_dir_path))
        {
            if(!mkdir($business_dir_path))
                respondWithHttpError(500, "Could not create directory: $business_dir_path");
        }

        $business_type_path = "$base_url/uploads/business/$business_id/type$btype";

        // If the business is new
        if(file_exists($business_dir_path))
        {
            if(!file_exists($business_type_path))
            {
                if(!mkdir($business_type_path))
                    respondWithHttpError(500, "Could not create directory: $business_type_path");
            }
        }
        else
            respondWithHttpError(500, "Directory does not exist: $business_dir_path");

        if(is_uploaded_file($_FILES['bphoto']['tmp_name']))
        {
            $existing_files = array_values(array_diff(scandir($business_type_path), ['.', '..']));
            sort($existing_files);
            $new_filename = "1";

            if(count($existing_files))
            {
                $last_uploaded_file = end($existing_files);
                $luf_info = explode(".", $last_uploaded_file);
                $new_filename = (int) $luf_info[0];
                $new_filename++;
            }

            $new_file_path = "$business_type_path/$new_filename.$file_ext";
            if(!move_uploaded_file($_FILES['bphoto']['tmp_name'], "$new_file_path"))
                respondWithHttpError(500, "Can't move uploaded file: $new_file_path");
        }
        else 
            respondWithHttpError(500, "File not uploaded");
    }
    else 
        echo "false";
})();
?>