let pin = $("#pin");
let pin_hidden = $("#pin-hidden");

$(".toggle-password").on("click", function () {
    pin.toggle();
    pin_hidden.toggle();
});
