
<?php
    header('Content-Type: application/json');

    $aResult = array();

    function test_func($box_pos_x, $box_pos_y, $box_width, $box_height, $emotion, $pictureSource)
    {
        list($width, $height) = getimagesize($pictureSource);
        $png = imagecreatefrompng('assets/img/Emotions/'. $emotion .'.png');

        // After the last point is naturally the format.
        $dots = explode(".", $pictureSource);

        // We assign the last data of $dots to the variable $type.
        $type = $dots[(count($dots)-1)];
        

        switch($type)
        {
            case 'jpeg':
                $img = imagecreatefromjpeg($pictureSource);
                break;
            case 'png':
                $img = imagecreatefrompng($pictureSource);
                break;
            case 'gif':
                $img = imagecreatefromgif($pictureSource);
                break;
            case 'webp':
                $img = imagecreatefromwebp($pictureSource);
                break;
            default:
                $img = imagecreatefromfile($pictureSource);
                break;
        }

            

        $exif = exif_read_data($pictureSource);
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

        
        list($oldwidth, $oldheight) = getimagesize($pictureSource);
        
        // Grösse von HTML Bild nehmen
        $width = 535;
        $height = 535;

        list($newwidth, $newheight) = getimagesize('assets/img/Emotions/'. $emotion. '.png');
        
        $cutted_pic = imagecreateTrueColor($width, $height);
        imagecopyresampled($cutted_pic, $img, 0,0,0,0, $width, $height, $oldwidth, $oldheight);
        imagepng($cutted_pic, 'assets/img/output_test.png');

        $cutted_emoji = imagecreate($box_width, $box_height);
        imagecopyresampled($cutted_emoji, $png, 0,0, 0, 0, $box_width, $box_height, $newwidth, $newheight);

        imagecopy($cutted_pic, $cutted_emoji, $box_pos_x , $box_pos_y, 0, 0, $box_width, $box_height);

        imagepng($cutted_pic, 'assets/img/out_new.png', 8);

        $current_date = date("H-i-s");

        $manipulated_pic_path = 'assets/img/output/' . $pictureSource . '_' . $current_date . '_manipulated.png';

        imagepng($cutted_pic, $manipulated_pic_path, 8);
        
        return $manipulated_pic_path;
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