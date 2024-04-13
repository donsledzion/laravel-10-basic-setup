let audioContainer = $(".audio-container");
let audioInput = $(".audio-container :input");
let pictureContainer = $(".picture-container");
let pictureInput = $(".picture-container :input");

$(function () {
    updateType($("#type").val());
});

function updateType(type) {
    switch (type) {
        case "text2text":
            questionText();
            break;
        case "text2picture":
            questionText();
            break;
        case "text2audio":
            questionText();
            break;
        case "audio2text":
            questionAudio();
            break;
        case "audio2audio":
            questionAudio();
            break;
        case "picture2text":
            questionPicture();
            break;
        case "put-in-order":
            questionText();
            break;
        default:
            questionText();
    }
}

$("#type").on("change", function () {
    let newType = $(this).val();
    console.log("Type changed to " + newType);
    updateType(newType);
});

function questionPicture() {
    audioContainer.hide();
    audioInput.attr("disabled", "disabled");

    pictureContainer.show();
    pictureInput.removeAttr("disabled");
}

function questionAudio() {
    pictureContainer.hide();
    pictureInput.attr("disabled", "disabled");

    audioContainer.show();
    audioInput.removeAttr("disabled");
}

function questionText() {
    audioContainer.hide();
    audioInput.attr("disabled", "disabled");

    pictureContainer.hide();
    pictureInput.attr("disabled", "disabled");
}
