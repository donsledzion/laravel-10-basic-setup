$(function () {
    console.log("Page loaded!");
});

$("#is_correct").on("change", function () {
    let is_checked = $(this).prop("checked");
    console.log("is_correct status change. Is checked: " + is_checked);
    $(this).attr("checked", is_checked);
});
