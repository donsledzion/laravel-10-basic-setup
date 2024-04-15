$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

$(".delete-scenario").on("click", function () {
    let scenario_id = $(this).data("id");
    console.log("About to delete scenario with id: " + scenario_id);
    Swal.fire({
        title: "Na pewno usunąć scenariusz?",
        text: "Zostaną usunięte również wszystkie powiązane pytania. Tej operacji nie da się cofnąć!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: route("scenario.destroy", scenario_id),
                type: "DELETE",

                success: function (result) {
                    Swal.fire({
                        title: "Usunięto!",
                        text: "Scenariusz z wszystkimi pytaniami został usunięty.",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                },
            });
        }
    });
});
