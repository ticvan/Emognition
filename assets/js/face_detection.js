const video = document.getElementById("video");
const screenshotButton = document.getElementById("btnScreenshot");

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('assets/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('assets/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('assets/models'),
    faceapi.nets.faceExpressionNet.loadFromUri('assets/models')
  ]).then(startVideo)

function startVideo() 
{
    navigator.getUserMedia(
      { video: {} },
      stream => video.srcObject = stream,
      err => console.error(err)
    )
}

var canvas;
video.addEventListener('play', () => 
{
    canvas = faceapi.createCanvasFromMedia(video);
    const b = document.getElementById("Webcam");
    b.append(canvas);
    const displaySize = { width: video.width, height: video.height }
    setInterval(async () => 
    {
    faceapi.matchDimensions(canvas, displaySize)
        const detections = await faceapi.detectAllFaces(video, 
            new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
            const resizedDetections = faceapi.resizeResults(detections, displaySize)
            canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height)
            faceapi.draw.drawDetections(canvas, resizedDetections)
            faceapi.draw.drawFaceLandmarks(canvas, resizedDetections, { drawLines: true })
            faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
    }, 0)
})

screenshotButton.onclick = video.onclick = function () {
    const img = document.getElementById("img");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0);
    // Other browsers will fall back to image/png
    img.src = canvas.toDataURL("image/webp");
  };