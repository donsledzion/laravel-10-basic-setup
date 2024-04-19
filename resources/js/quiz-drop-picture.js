let pictureDropArea = document.getElementById("picture-drop-area");
let question_picture = document.getElementById("question_picture");
let gallery = document.getElementById("gallery");

["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
    pictureDropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

["dragenter", "dragover"].forEach((eventName) => {
    pictureDropArea.addEventListener(eventName, highlight, false);
});

["dragleave", "drop"].forEach((eventName) => {
    pictureDropArea.addEventListener(eventName, unhighlight, false);
});

pictureDropArea.addEventListener("drop", handleDrop, false);

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    pictureDropArea.classList.add("highlight");
}

function unhighlight(e) {
    pictureDropArea.classList.remove("highlight");
}

function handleDrop(e) {
    let dt = e.dataTransfer;
    let files = dt.files;
    handleFiles(files);
}

pictureDropArea.addEventListener("click", () => {
    question_picture.click();
});

question_picture.addEventListener("change", function (e) {
    handleFiles(this.files);
});

function handleFiles(files) {
    files = [...files];
    files.forEach(previewFile);
}

function previewFile(file) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onloadend = function () {
        let img = document.createElement("img");
        img.src = reader.result;
        img.classList.add("img-fluid");
        while (gallery.firstChild) {
            gallery.removeChild(gallery.firstChild);
        }

        gallery.appendChild(img);
    };
}
