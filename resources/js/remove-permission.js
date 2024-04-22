$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

$(".delete-permission").on("click", function () {
    let permission_id = $(this).data("id");
    console.log("About to delete permissions with id: " + permission_id);
    Swal.fire({
        title: "Na pewno usunąć?",
        text: "Jeśli wpis reguluje jakieś prawa dostępu, usunięcie może spowodować błędne działanie aplikacji!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!",
        cancelButtonText: "Jednak nie!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: route("permission.destroy", permission_id),
                type: "DELETE",

                success: function (data) {
                    Swal.fire({
                        icon: "success",
                        title: "Usunięto!",
                        text: "Módl się żeby nic się nie popsuło!",
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
