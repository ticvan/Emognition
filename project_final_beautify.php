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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
  <script src="assets/js/face-api.min.js"></script>
  
  <title>Emognition</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Emognition</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <figure class="col-5 mx-4 figure" height="535" width="535">
                    <div id="webcam" class="d-flex justify-content-center">
                        <img src="" alt="Preview vom Bild" id="image_preview">
                    </div>
                    <figcaption class="figure-caption">Facecam or uploaded Image</figcaption>
                </figure>
            </div>
        </div>

        <div class="container my-5">
      <div class="form-group my-2 shadow">
        <input type="file" name="image_upload" id="image_upload" class="form-control gap-2" accept=".png, .jpeg, .gif, webp">
      </div>
      <div class="row">
        <div class="col-lg-4 my-2">
          <button type="button" class="btn shadow col-12 btn-light btn-block py-3" id="snapshot_button">Take a snapshot!</button>
        </div>
        <div class="col-lg-4 my-2">
          <a type="button" class="btn shadow col-12 btn-success btn-block py-3" href="" id="downloadPic" download="Mood.webp">Download</a>
        </div>
        <div class="col-lg-4 my-2">
          <input type="submit" class="btn shadow col-12 btn-dark btn-block py-3" value="Analyse beginnen" name="uploadImage" id='btn_upload_image'>
        </div>
      </div>
    </div>
        </div>
    </div>
    <canvas class="d-none" id="webcam_canvas"></canvas>
    <script>
            Promise.all([
        faceapi.nets.tinyFaceDetector.loadFromUri('assets/models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('assets/models'),
        faceapi.nets.faceRecognitionNet.loadFromUri('assets/models'),
        faceapi.nets.faceExpressionNet.loadFromUri('assets/models')
    ])
    </script>
    <script src="assets/js/image_detection_beautify.js"></script>
    <script src="assets/js/basic_functions.js"></script>
</body>
</html>