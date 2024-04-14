let logoDropArea = document.getElementById("logo-drop-area");
let logo = document.getElementById("logo");
let gallery = document.getElementById("gallery");

["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
    logoDropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

["dragenter", "dragover"].forEach((eventName) => {
    logoDropArea.addEventListener(eventName, highlight, false);
});

["dragleave", "drop"].forEach((eventName) => {
    logoDropArea.addEventListener(eventName, unhighlight, false);
});

logoDropArea.addEventListener("drop", handleDrop, false);

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    logoDropArea.classList.add("highlight");
}

function unhighlight(e) {
    logoDropArea.classList.remove("highlight");
}

function handleDrop(e) {
    let dt = e.dataTransfer;
    let files = dt.files;
    handleFiles(files);
}

logoDropArea.addEventListener("click", () => {
    logo.click();
});

logo.addEventListener("change", function (e) {
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
