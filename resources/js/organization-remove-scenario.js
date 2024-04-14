$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(".delete-scenario").on("click", function () {
    let scenario_id = $(this).data("id");
    let baseURL = "{{route('welcome')}}";
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
                url: baseURL + "/scenario/" + scenario_id,
                method: "DELETE",
                success: function (result) {
                    Swal.fire({
                        title: "Usunięto!",
                        text: "Scenariusz z wszystkimi pytaniami został usunięty.",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    console.log(result.active);
                },
            });
        }
    });
});
