<?php
    header('Content-Type: application/json');

    $aResult = array();
function upload_to_server($base64_string)
{
        $current_date = date("d.m.y");
        $current_time = date("H:i:s");
        //gets the extension of the image
        $extension = explode('/', mime_content_type($base64_string))[1];
        $image_path = "./assets/img/upload/" . uniqid() . '_'. $current_date . '_' . $current_time . '.' . $extension;
        file_put_contents($image_path, file_get_contents($base64_string));

        $data = base64_decode($base64_string);

        $formImage = imagecreatefromstring($data);

        imagepng($formImage, './assets/image/upload/dasisteintest.png');

        return $image_path;
    }
    
    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }
    
    if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }
    
    if( !isset($aResult['error']) ) {
        
        switch($_POST['functionname']) 
        {
            case 'upload_image_to_server':
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 1) ) 
               {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                //    $aResult['result'] = add(floatval($_POST['arguments'][0]), floatval($_POST['arguments'][1]));
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