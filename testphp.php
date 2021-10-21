<!DOCTYPE html>
<html lang="en">
<head>
 
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" 
  rel="stylesheet" 
  integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" 
  crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/style.scss">
  <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
  <script src="assets/js/face-api.min.js"></script>
  <!-- <script defer src="assets/js/face_detection.js"></script> -->

  <title>Emognition</title>
</head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="mt-5">Emognition</h1>
        </div>
      </div>
      <br />
      <div class="row">
        <div class="col-lg-12 text-center">
          <figure class="col-5 mx-4 figure" height="535" width="535">
            <!-- <div id="Webcam" class="col-12 d-flex justify-content-center">
              </div>             -->
              <div id="Webcam" class="col-12 d-flex justify-content-center">
                <!-- <video id="video" width="720" height="500" autoplay muted></video> -->
                <div id="detctionVariant">
                  
                  <!-- <video id="video" style="background-color: #000;" width="720" height="500" autoplay muted></video>
                  <img id="temp_image" src="" alt="Temp Bild" width="720" height="500"> -->
                </div>
              <!-- <img id="temp2" alt="Temp Bild" width="720" height="500"> -->
            </div>     
          <figcaption class="figure-caption">facecam or uploaded img figure</figcaption>
          </figure>

          <!-- TODO => Add radio button for face or image for  id="userSelection" -->
          <figure class="col-5 mx-4 figure">

            <div class="responsive-video shadow col-12 figure-img img-fluid rounded-3">
              <iframe src="https://www.youtube.com/embed/EIm4HvDgQCM" frameborder="0" height="300" width="100%" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
            <figcaption class="figure-caption">youtube video shown after api recognized face</figcaption>
          </figure>
        </div>
      </div>
      <br />
      <div class="row">
        <div class="col-lg-12 text-center">
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
          Select image to upload:
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="submit" value="Upload und analisieren" name="uploadImage">
        </form>
          <!-- <button type="button" class="shadow col-5 mx-4 my-4 btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#downlaodModal">Download</button>
          <input id="fileInput" type="file"  class="btn btn-light" accept="image/*" name="image" id="file"  onchange="loadFile(event)" style="display: none;">
          <button id="uploadBtn" type="button" class="shadow col-5 mx-4 my-4 btn btn-light btn-lg" >Upload</button> -->
        </div>
      </div>
    </div>

    <!-- Faceapi Implementation -->

    <!-- <div class="container">

  
      <div class="row">
          <div id="Webcam" class="col-12 d-flex justify-content-center">
              <video id="video" width="720" height="500" autoplay muted></video>
          </div>
      </div>
      <div class="row">
          <div class="col-12 d-flex justify-content-center">
              <button id="btnScreenshot">Take a Screenshot!</button>
          </div>
      </div>
  
      <div class="row">
          <div class="col-12 d-flex justify-content-center">
              <img id="img">
          </div>
      </div>
  </div> -->




  <!-- End of implementation -->

    <div class="modal fade" id="downlaodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">options</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h3 class="h3">format</h3>
            <div class="col-lg-12 text-center">  
              <input type="radio" class="btn-check" name="format" id="JPG-outlined" value="jpg" autocomplete="off" checked>
              <label class="col-3 btn btn-outline-primary" for="JPG-outlined">JPG</label>
              
              <input type="radio" class="btn-check" name="format" id="WEBP-outlined" value="webp" autocomplete="off">
              <label class="col-3 btn btn-outline-primary" for="WEBP-outlined">WEBP</label>
              
              <input type="radio" class="btn-check" name="format" id="PNG-outlined" value="png" autocomplete="off">
              <label class="col-3 btn btn-outline-primary" for="PNG-outlined">PNG</label>
            </div>
            <br />
            <h3 class="h3">resolution</h3>
            <div class="col-lg-12 text-center">  
              <div class="row">
                <div class="col">
                  <input type="text" class="form-control" id="height" placeholder="Height" aria-label="Height">
                </div>
                x
                <div class="col">
                  <input type="text" class="form-control" id="width" placeholder="Width" aria-label="Width">
                </div>
              </div>
            </div>
            <br />
            <h3 class="h3">name</h3>
            <div class="col-lg-12 text-center">  
              <input type="text" class="form-control" id="pictureName" placeholder="name" aria-label="name">
            </div>
          </div>           
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="downloadImage()">download</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">options</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <input type="file" class="my-pond" name="filepond" accept="image/png, image/jpeg, image/gif image/webm" ondrag="loadFile(event)"/>

          <p><input type="file"  class="btn btn-light" accept="image/*" name="image" id="file"  onchange="loadFile(event)" style="display: none;"></p>
          <p><label for="file" style="cursor: pointer;">Upload Image</label></p>
          <p><img id="output" width="200" /></p>
        </div>
      </div>

    </div>
      
    <button onclick="myFunction()">Click me</button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
  crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="assets/js/index.js"></script>
<!-- include jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

<script src="assets/js/image_detection.js"></script>
<script>
  

  $('#submit').click(function() {
    $.ajax({
        url: '',
        type: 'POST',
        success: function(msg) {
            alert('Email Sent');
        }               
    });
});
</script>
<?php
      $target_dir = "./assets/img/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }
    if ($uploadOk == 0) {
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
        {
          // echo '<script type="text/javascript">',
          //      'detectPic(' + $_FILES["fileToUpload"]["tmp_name"] + ');',
          //      '</script>';
          $filename = $_FILES["fileToUpload"]["name"];
          echo "<script type='text/javascript'>detectPic('$filename');</script>";
        } 
        else 
        {
          echo "Sorry, there was an error uploading your file.";
        }
      }

  
  
?>


</body>
</html>