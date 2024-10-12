let textureDropArea = document.getElementById("texture-drop-area");
let texture = document.getElementById("texture");
let textureGallery = document.getElementById("texture-gallery");

["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
    textureDropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

["dragenter", "dragover"].forEach((eventName) => {
    textureDropArea.addEventListener(eventName, highlight, false);
});

["dragleave", "drop"].forEach((eventName) => {
    textureDropArea.addEventListener(eventName, unhighlight, false);
});

textureDropArea.addEventListener("drop", handleDrop, false);

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    textureDropArea.classList.add("highlight");
}

function unhighlight(e) {
    textureDropArea.classList.remove("highlight");
}

function handleDrop(e) {
    let dt = e.dataTransfer;
    let files = dt.files;
    handleFiles(files);
}

textureDropArea.addEventListener("click", () => {
    texture.click();
});

texture.addEventListener("change", function (e) {
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

        while (textureGallery.firstChild) {
            textureGallery.removeChild(textureGallery.firstChild);
        }

        textureGallery.appendChild(img);
    };
}
