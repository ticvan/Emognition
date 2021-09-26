<?php
    $bigImage=imageCreateFromJPEG('original.jpg');
    $bigWidth = imageSX($bigImage);
    $bigHeight = imageSY($bigImage);
    $smallWidth = 300;
    $smallImage = imageCreateTrueColor($smallWidth,$smallWidth);
    imageCopyResampled($smallImage,$bigImage,0,0,($bigWidth-$bigHeight)/2,0,$smallWidth,$smallWidth,$bigHeight,$bigHeight);
    imageWebp($smallImage,'manipulated.webp', 8);

    echo '
    <center>
        <figure>
            <img src="original.jpg" alt="jpg image">
            <figcaption>Original image jpg</figcaption>
        </figure>
        <figure>
            <img src="manipulated.webp" alt="manipulated image">
            <figcaption>New 300X300 image</figcaption>
        </figure>
    </center>
    ';
    imageDestroy($bigImage);
    imageDestroy($smallImage);

?>
