$(".toggle-password").on("click", function () {
    var x = document.getElementById("pin");
    if (x == null) x = document.getElementById("headset_pin");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
});
