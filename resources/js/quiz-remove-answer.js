$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

$(".delete-answer").on("click", function () {
    let answer_id = $(this).data("id");
    console.log("About to delete answer with id: " + answer_id);
    Swal.fire({
        title: "Na pewno usunąć odpowiedź?",
        text: "Tej operacji nie da się cofnąć!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!",
        cancelButtonText: "Jednak nie!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: route("answer.destroy", answer_id),
                type: "DELETE",

                success: function (data) {
                    Swal.fire({
                        icon: "success",
                        title: "Usunięto!",
                        text: "Odpowiedź została usunięta.",
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                },
            });
        }
    });
});
