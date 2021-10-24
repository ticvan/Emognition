function load_face_api(image_source)
{
    read_expressions_2(image_source);
}

async function read_expressions_2(image_source)
{
    //await to be sure that the image is loaded
    const image = await loadImage(image_source);

    //Canvas to draw expressions on it
    let expression_canvas = await faceapi.createCanvasFromMedia(image);

    //adds canvas onto the image
    const image_preview = document.getElementById("webcam");
    image_preview.append(expression_canvas);


    const displaySize = { width: image.width, height: image.height };
    faceapi.matchDimensions(expression_canvas, displaySize);
    
    //landmarks is needed to get the positon of the face and expression is needed for the expression
    //TinyFaceDetection is a Model used for Faceapi
    const detections = await faceapi.detectAllFaces(image, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions();

    const resizedDetections = faceapi.resizeResults(detections, displaySize);

    expression_canvas.getContext("2d").clearRect(0, 0, expression_canvas.width, expression_canvas.height);

    let detectionBox = resizedDetections[0].detection.box;

    if(Object.keys(detectionBox).length !== 0)
    {
        let expression = detectExpression(resizedDetections[0].expressions);
        jQuery.ajax({
            type: "POST",
            url: "../Emognition/edit_image_beautify.php",
            dataType: "json",
            data: { functionname: 'edit_image', arguments: [detectionBox.x, detectionBox.y, detectionBox.width, detectionBox.height, expression, image_source] },
            success: function (obj, textstatus) {
                if (!('error' in obj)) {
                    var edited_image = obj.result;
                    console.log(edited_image);
                    $('#image_preview').attr("src", edited_image);
                    $('a').attr("href", edited_image)
                }
                else {
                    console.log(obj.error);
                }
            }
        })
    }
}

function loadImage(url) {
    return new Promise(r => { let i = new Image(); i.onload = (() => r(i)); i.src = url; });
  }

  function detectExpression(detections) {
    var result = [];

    for (var i in detections)
        result.push([i, detections[i]]);
    result.sort(sortingExpressions);
    return result[0][0];
}

function sortingExpressions(a, b) {
    if (a[1] === b[1]) {
        return 0;
    }
    else {
        return (a[1] > b[1]) ? -1 : 1;
    }
}