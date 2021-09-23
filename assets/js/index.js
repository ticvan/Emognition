var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
};

document.getElementById('uploadBtn').addEventListener('click', () => {
  document.getElementById('fileInput').click()
})