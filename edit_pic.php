
<?php
    header('Content-Type: application/json');

    $aResult = array();

    function test_func($box_pos_x, $box_pos_y, $box_width, $box_height, $emotion, $pictureSource)
    {
        list($width, $height) = getimagesize($pictureSource);
        
        echo $pictureSource;
        // // return $test_value . 'pls work man';
        $png = imagecreatefrompng('assets/img/Emotions/'. $emotion. '.png');
        // list($newwidth, $newheight) = getimagesize('assets/img/Emotions/'. $emotion. '.png');
        // $png = imagecreatefrompng('assets/img/Emotions/happy.png');
        list($newwidth, $newheight) = getimagesize('assets/img/Emotions/happy.png');
        $webp = imagecreatefromjpeg($pictureSource);
        
        $cutted_emoji = imagecreateTrueColor($box_width, $box_height);
        imagecopyresampled($cutted_emoji, $png, 0,0, 0, 0, $box_width, $box_height, $newwidth, $newheight);

        // $out = imagecreatetruecolor($newwidth, $newheight);
        // imagecopyresampled($out, $webp, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagecopy($webp, $cutted_emoji, $box_pos_y, $box_pos_x, 0, 0, $box_width, $box_height);

        imagepng($webp, 'assets/img/out_new.png', 8);
        
        return $emotion;
    }

    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

    if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

    if( !isset($aResult['error']) ) {
        
        switch($_POST['functionname']) 
        {
            case 'test_func':
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 3) ) 
               {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                //    $aResult['result'] = add(floatval($_POST['arguments'][0]), floatval($_POST['arguments'][1]));
                $aResult['result']  = test_func($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2], $_POST['arguments'][3], $_POST['arguments'][4], $_POST['arguments'][5]);
               }
               break;

            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }
    echo json_encode($aResult);
?>