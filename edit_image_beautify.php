<?php
    //header for response
    header('Content-Type: application/json');

    //is used to write the results and gets read in js
    $aResult = array();

    //function to edit the picture(puts emoji on the face)
    function edit_image($box_pos_x, $box_pos_y, $box_width, $box_height, $emotion, $pictureSource)
    {
        //create gd library object with the emotion
        $base_emotion_image = imagecreatefrompng("assets/img/Emotions/" . $emotion . ".png");
        
        //gets width and height from base image
        $base_emotion_width  = imagesx($emotion_image);
        $base_emotion_height = imagesy($emotion_image);

        //cuts emoji pic to fit it on the head
        $cutted_emotion_image = imagecreateTrueColor($box_width, $box_height);
        imagecopyresampled($cutted_emotion_image, $base_emotion_image, 0, 0, 0, 0, $box_width, $box_height, $base_emotion_width, $base_emotion_height);

        //creates gd library object from picturesource
        $base_image = imagecreatefrompng($pictureSource);

        imagecopy($base_image, $cutted_emotion_image, $box_pos_x , $box_pos_y, 0, 0, $box_width, $box_height);

        $current_date = date("d.m.y");
        $current_time = date("H:i:s");
        $manipulated_pic_path = 'assets/img/output/' . uniqid() . '_' . $current_date . '_' . $current_time . '_manipulated.png';
        
        imagepng($base_image, $manipulated_pic_path);

        return $manipulated_pic_path;
    }

    if( !isset($_POST['functionname']) ) 
    { 
        $aResult['error'] = 'No function name!'; 
    }

    if( !isset($_POST['arguments']) )
    { 
        $aResult['error'] = 'No function arguments!'; 
    }

    if( !isset($aResult['error']) ) 
    {
        switch($_POST['functionname']) 
        {
            case 'edit_image':
                if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 3) ) 
                {
                    $aResult['error'] = 'Error in arguments!';
                }
                else 
                {
                    $aResult['result']  = edit_image($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2], $_POST['arguments'][3], $_POST['arguments'][4], $_POST['arguments'][5]);
                }
            break;

            default:
                $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
            break;
    }

    }
    echo json_encode($aResult);
?>