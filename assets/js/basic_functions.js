let base64_image_string = '';
const image_to_upload = document.getElementById("image_upload");
const preview_image = document.getElementById("image_preview");

image_to_upload.addEventListener("change", function(){
    const selected_image = this.files[0];

    if(selected_image)
    {
        const base_reader = new FileReader();
        base_reader.addEventListener("load", function(){
            base64_image_string = this.result;
            preview_image.setAttribute("src", base64_image_string);
        })

        base_reader.readAsDataURL(selected_image);
    }
})

document.getElementById("snapshot_button").onclick = async () =>
{
    //Webcam element wird erstellt
    let webcam_display = document.createElement("video");

    //set attributes to webcam
    webcam_display.id = 'webcam_display';
    webcam_display.setAttribute("autoplay", "");
    webcam_display.setAttribute("playinline", "");
    webcam_display.style.opacity = "0";

    //display webcam to site and do a screenshot
    document.body.appendChild(webcam_display);
    const canvasElement = document.getElementById("webcam_canvas");
    const webcam = new Webcam(webcam_display, "user", canvasElement);
    
    //starts webcam and waits 2 seconds to be really sure that the webcam is active
    webcam.start();
    await new Promise(start_up => setTimeout(start_up, 2000));
    
    //creates a snapshot and displays to the site
    base64_image_string = webcam.snap();
    preview_image.setAttribute("src", base64_image_string);

    //removes webcam from site and stops it
    webcam.stop();
    webcam_display.remove();
}

document.getElementById("btn_upload_image").onclick = function()
{
    jQuery.ajax({
        type: "POST",
        url: "../Emognition/upload_beautify.php",
        dataType: "json",
        data: {functionname: "upload_image_to_server", arguments: [base64_image_string]},
        success: function(obj, textstatus)
        {
            if(!('error' in obj))
            {
                //wenn the array error is empty starting to detect emotions of the image
                var image_path = obj.result;
                console.log(image_path);
                load_face_api(image_path);
            }
            else
            {
                alert(obj.error);
            }
        }
    })
}