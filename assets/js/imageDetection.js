function showVideo(expression) {
  console.log(expression);
  $.getJSON("assets/json/videos.json")
    .done(function (videos) {
      console.log(videos[expression][Math.floor(Math.random() * 2)].url);

      $("#infoMessages").html(
        '<div class="alert alert-info" role="alert">' +
          'Video suggestion on your <a href="' +
          videos[expression][Math.floor(Math.random() * 2)].url +
          '" class="alert-link">mood</a>.' +
          "</div>"
      );
    })
    .fail(function (error) {
      console.log("Request Failed: " + error);
    });

  return;
}

function load_face_api(image_source) {
  read_expressions(image_source);
}

async function read_expressions(image_source) {
  //await to be sure that the image is loaded
  const image = await loadImage(image_source);

  //landmarks is needed to get the positon of the face and expression is needed for the expression
  //TinyFaceDetection is a Model used for Faceapi
  const detections = await faceapi
    .detectAllFaces(image, new faceapi.TinyFaceDetectorOptions())
    .withFaceLandmarks()
    .withFaceExpressions();
  //gets the box of where the face was detected
  let detection = detections[0];

  //check if a face was found
  if (detection !== undefined) {
    let detectionBox = detections[0].detection.box;
    //get the expression of the face
    let expression = detectExpression(detections[0].expressions);
    //ajax call to edit the picure
    jQuery.ajax({
      type: "POST",
      url: "../Emognition/editImage.php",
      dataType: "json",
      data: {
        functionname: "edit_image",
        arguments: [
          detectionBox.x,
          detectionBox.y,
          detectionBox.width,
          detectionBox.height,
          expression,
          image_source,
        ],
      },
      success: function (obj, textstatus) {
        //if no errors found in php file
        if (!("error" in obj)) {
          //set the edited image to the preview image
          var edited_image = obj.result;
          $("#image_preview").attr("src", edited_image);
          //set href for download
          $("a").attr("href", edited_image);
          showVideo(expression);
        } else {
          alert(obj.error);
        }
      },
    });
  } else {
    $("#infoMessages").html(
      '<div class="alert alert-danger" role="alert">There was no face detected! Please try again! :)</div>'
    );
  }
}

function loadImage(url) {
  return new Promise((r) => {
    let i = new Image();
    i.onload = () => r(i);
    i.src = url;
  });
}

function detectExpression(detections) {
  var result = [];

  for (var i in detections) result.push([i, detections[i]]);
  result.sort(sortingExpressions);
  return result[0][0];
}

//sorting expressions
function sortingExpressions(a, b) {
  if (a[1] === b[1]) {
    return 0;
  } else {
    return a[1] > b[1] ? -1 : 1;
  }
}