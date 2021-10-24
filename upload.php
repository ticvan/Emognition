<?php
    header('Content-Type: application/json');

    $aResult = array();
function upload_to_server($image_name, $base64_string)
{
    //TODO CUT IMAGE
    $current_date = date("d.m.y");
    $current_time = date("H:i:s");
    $extension = explode('/', mime_content_type($base64_string))[1];
    $target_dir = "./assets/img/upload/" . $image_name . $current_date . '_' . $current_time . '.' . $extension;
    file_put_contents($target_dir, file_get_contents($base64_string));

    return $target_dir;
}

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

if( !isset($aResult['error']) ) {
    
    switch($_POST['functionname']) 
    {
        case 'upload_to_server':
           if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 1) ) 
           {
               $aResult['error'] = 'Error in arguments!';
           }
           else {
            //    $aResult['result'] = add(floatval($_POST['arguments'][0]), floatval($_POST['arguments'][1]));
            $aResult['result']  = upload_to_server($_POST['arguments'][0], $_POST['arguments'][1]);
           }
           break;

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
           break;
    }
    echo json_encode($aResult);
}
?>