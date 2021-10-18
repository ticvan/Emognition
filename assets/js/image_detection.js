Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('assets/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('assets/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('assets/models'),
    faceapi.nets.faceExpressionNet.loadFromUri('assets/models')
])

function detectPic(image_name) 
{
    console.log('WHUUUUT');
    // var source_image = $('#temp_image').attr('src') ;
    // var new_source = $('#temp_image').attr('src').replace(source_image, 'assets/img/' + image_name);
    // $("#temp2").attr("src", new_source);

    document.getElementById("temp_image").src="assets/img/" + image_name;

    // $(document).ready(function()
    // {
    //     const imageDet = document.getElementById("temp_image");
    // var canvas = faceapi.createCanvasFromMedia(imageDet);

    // const b = document.getElementById("Webcam");
    // b.append(canvas);
    // var detectionInterval = setInterval(async () => {
    //     const displaySize = { width: imageDet.width, height: imageDet.height }
    //     faceapi.matchDimensions(canvas, displaySize)
    //     const detections = await faceapi.detectAllFaces(imageDet,
    //         new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
    //     const resizedDetections = faceapi.resizeResults(detections, displaySize)
    //     canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height)
    //     faceapi.draw.drawDetections(canvas, resizedDetections)
    //     faceapi.draw.drawFaceLandmarks(canvas, resizedDetections, { drawLines: false })
    //     faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
        
    //     var expression = detectExpression(resizedDetections[0].expressions);
    //     var detectionBox = resizedDetections[0].detection.box;


    //     if (Object.keys(detectionBox).length !== 0) {
    //         clearInterval(detectionInterval);
    //         console.log(detectionBox);
    //         var canvas2;

    //         canvas2 = faceapi.createCanvasFromMedia(imageDet);
    //         faceapi.matchDimensions(canvas2, displaySize);
    //         var ctx = canvas2.getContext("2d")
    //         ctx.rect(detectionBox.x, detectionBox.y, detectionBox.width, detectionBox.height);
    //         ctx.fill();
    //         b.append(canvas2);

    //         jQuery.ajax({
    //             type: "POST",
    //             url: '../Emognition/edit_pic.php',
    //             dataType: 'json',
    //             data: { functionname: 'test_func', arguments: [detectionBox.x, detectionBox.y, detectionBox.width, detectionBox.height, expression] },

    //             success: function (obj, textstatus) {
    //                 if (!('error' in obj)) {
    //                     var yourVariable = obj.result;
    //                     console.log(obj.result);
    //                 }
    //                 else 
    //                 {
    //                     console.log(obj.error);
    //                 }
    //             }
    //         });
    //     }
    // }, 2500)
    // })
    
    console.log('is finished');

}


function detectExpression(detections)
{
    var result = [];

    for(var i in detections)
    result.push([i, detections [i]]);
    result.sort(sortingExpressions);
    return result[0][0];
}

function sortingExpressions(a, b)
{
    if (a[1] === b[1]) {
        return 0;
    }
    else {
        return (a[1] > b[1]) ? -1 : 1;
    }
}