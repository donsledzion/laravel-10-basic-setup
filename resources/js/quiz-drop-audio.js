let audioDropArea = document.getElementById("audio-drop-area");
let question_audio = document.getElementById("question_audio");
let audioPreview = document.getElementById("audio-preview");

["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
    audioDropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

["dragenter", "dragover"].forEach((eventName) => {
    audioDropArea.addEventListener(eventName, highlight, false);
});

["dragleave", "drop"].forEach((eventName) => {
    audioDropArea.addEventListener(eventName, unhighlight, false);
});

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

audioDropArea.addEventListener("drop", handleDrop, false);

audioDropArea.addEventListener("click", () => {
    question_audio.click();
});

question_audio.addEventListener("change", function (e) {
    handleAudios(this.files);
});

function handleAudios(files) {
    files = [...files];
    files.forEach(previewAudio);
}

function previewAudio(file) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onloadend = function () {
        let source = document.getElementById("audioSource");
        let audio = document.getElementById("audio");
        source.src = reader.result;
        audio.load();
    };
}
