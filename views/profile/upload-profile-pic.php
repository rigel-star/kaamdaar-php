<?php 
session_start();

function respondWithHttpError($error)
{
    $errors = [404 => "Not Found", 500 => "Internal Server Error"];
    header("HTTP/1.1 $error " . $errors[$error]);
}

// TODO:: Update database value as well

// Immediate function to execute file upload
(function () {
    if(isset($_FILES['profile-pic']['name']))
    {
        $file_type = $_FILES['profile-pic']['type'];
        $file_ext = end(explode("/", $file_type));
        $src_addr = $_FILES['profile-pic']['tmp_name'];

        $allowed_types = ['jpg', 'jpeg', 'gif', 'png'];
        if(!in_array($file_ext, $allowed_types))
        {
            echo "false";
            return;
        }

        $base_url = $_SERVER['DOCUMENT_ROOT'] . "/kaamdaar-php";
        $user_id = $_SESSION['user_id'];
        $rel_path = "uploads/profile/$user_id/profile.$file_ext";
        $abs_path = $base_url . "/$rel_path";

        foreach($allowed_types as $ext)
        {
            $might_exist = $base_url . "/uploads/profile/$user_id/profile.$ext";
            if(file_exists($might_exist))
                if(!unlink($might_exist))
                    respondWithHttpError(500);
        }

        if(is_uploaded_file($src_addr))
        {
            if(!move_uploaded_file($src_addr, $abs_path))
                respondWithHttpError(500);
            else 
            {
                $_SESSION['user_image'] = "../$rel_path";

                $connection = new mysqli("localhost", "root", "", "kaamdaar");
                if($connection->connect_error)
                    respondWithHttpError(500);

                if(!$connection->query("update users set u_image = '../$rel_path' where u_id = '$user_id';"))
                    respondWithHttpError(500);

                echo "true";
            }
        }
        else 
            respondWithHttpError(500);
    }
})();
?>