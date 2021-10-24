<?php
    header('Content-Type: application/json');

    $aResult = array();
function upload_to_server($base64_string)
{
        $current_date = date("d-m-y");
        $current_time = date("H:i:s");
        //gets the extension of the image from base64 string
        $extension = explode('/', mime_content_type($base64_string))[1];
        
        //uploads image to server 
        $image_path = "./assets/img/upload/" . uniqid() . '_'. $current_date . '_' . $current_time . '.' . $extension;
        file_put_contents($image_path, file_get_contents($base64_string));

        //image manipulation to cut to right size
        list($old_image_width, $old_image_height) = getimagesize($image_path);
        $width = 720;
        $height = 500;

        $cutted_image = imagecreatetruecolor($width, $height);
        
        //creates dg library object from imagepath
        switch($extension)
        {
            case 'jpeg':
                $img = imagecreatefromjpeg($image_path);
                break;
            case 'png':
                $img = imagecreatefrompng($image_path);
                break;
            case 'gif':
                $img = imagecreatefromgif($image_path);
                break;
            case 'webp':
                $img = imagecreatefromwebp($image_path);
                break;
            default:
            $aResult["error"] = 'The image has the wrong format! Please select a valid image!';
            return null;
            break;
        }

        //flips the orientation of the image if it's flipped
        $exif = exif_read_data($image_path);
        if ($img && $exif && isset($exif['Orientation']))
        {
            $ort = $exif['Orientation'];

            if ($ort == 6 || $ort == 5)
                $img = imagerotate($img, 270, null);
            if ($ort == 3 || $ort == 4)
                $img = imagerotate($img, 180, null);
            if ($ort == 8 || $ort == 7)
                $img = imagerotate($img, 90, null);

            if ($ort == 5 || $ort == 4 || $ort == 7)
                imageflip($img, IMG_FLIP_HORIZONTAL);
        }

        //creates the new image
        imagecopyresampled($cutted_image, $img, 0,0,0,0, $width, $height, $old_image_width, $old_image_height);
        
        //path for the maniplulated image
        $manipluated_image_path = "./assets/img/upload/" . uniqid() . '_'. $current_date . '_' . $current_time . '.png';
        
        //saves the image on the server
        imagepng($cutted_image, $manipluated_image_path);

        //deletes the old image
        unlink($image_path);

        //destroy gd library objects
        imagedestroy($cutted_image);
        imagedestroy($img);


        //returns the path of the manipulated image
        return $manipluated_image_path;
    }
    
    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }
    
    if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }
    
    if( !isset($aResult['error']) ) {
        
        switch($_POST['functionname']) 
        {
            case 'upload_image_to_server':
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 0 ) )
               {
                   $aResult['error'] = 'Error in arguments!';
               }
               else
               {
                 $aResult['result']  = upload_to_server($_POST['arguments'][0]);
               }
               break;
    
            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }
        echo json_encode($aResult);
    }

    
?>