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
            answerText();
            break;
        case "text2picture":
            answerPicture();
            break;
        case "text2audio":
            answerAudio();
            break;
        case "audio2text":
            answerText();
            break;
        case "audio2audio":
            answerAudio();
            break;
        case "picture2text":
            answerText();
            break;
        case "put-in-order":
            answerText();
            break;
        default:
            answerText();
    }
}

function answerPicture() {
    console.log("Type changed to answer picture");
    audioContainer.hide();
    audioInput.attr("disabled", "disabled");

    pictureContainer.show();
    pictureInput.removeAttr("disabled");
}

function answerAudio() {
    console.log("Type changed to answer audio");
    pictureContainer.hide();
    pictureInput.attr("disabled", "disabled");

    audioContainer.show();
    audioInput.removeAttr("disabled");
}

function answerText() {
    console.log("Type changed to answer text");
    audioContainer.hide();
    audioInput.attr("disabled", "disabled");

    pictureContainer.hide();
    pictureInput.attr("disabled", "disabled");
}
