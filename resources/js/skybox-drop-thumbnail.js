let thumbnailDropArea = document.getElementById("thumbnail-drop-area");
let thumbnail = document.getElementById("thumbnail");
let thumbnailGallery = document.getElementById("thumbnail-gallery");

["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
    thumbnailDropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

["dragenter", "dragover"].forEach((eventName) => {
    thumbnailDropArea.addEventListener(eventName, highlight, false);
});

["dragleave", "drop"].forEach((eventName) => {
    thumbnailDropArea.addEventListener(eventName, unhighlight, false);
});

thumbnailDropArea.addEventListener("drop", handleDrop, false);

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    thumbnailDropArea.classList.add("highlight");
}

function unhighlight(e) {
    thumbnailDropArea.classList.remove("highlight");
}

function handleDrop(e) {
    let dt = e.dataTransfer;
    let files = dt.files;
    handleFiles(files);
}

thumbnailDropArea.addEventListener("click", () => {
    thumbnail.click();
});

thumbnail.addEventListener("change", function (e) {
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

        while (thumbnailGallery.firstChild) {
            thumbnailGallery.removeChild(thumbnailGallery.firstChild);
        }

        thumbnailGallery.appendChild(img);
    };
}
