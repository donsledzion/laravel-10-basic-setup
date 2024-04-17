$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

$(".delete-quiz").on("click", function () {
    let quiz_id = $(this).data("id");
    console.log("About to delete quiz with id: " + quiz_id);
    Swal.fire({
        title: "Na pewno usunąć pytanie?",
        text: "Zostaną usunięte również wszystkie powiązane odpowiedzi. Tej operacji nie da się cofnąć!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!",
        cancelButtonText: "Jednak nie!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: route("quiz.destroy", quiz_id),
                type: "DELETE",

                success: function (data) {
                    Swal.fire({
                        icon: "success",
                        title: "Usunięto!",
                        text: "Quiz z wszystkimi odpowiedziami został usunięty.",
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace(data.redirect);
                        }
                    });
                },
            });
        }
    });
});
