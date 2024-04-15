$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(".role-toggle").click(function () {
    let role_id = $(this).data("role-id");
    let permission_id = $(this).closest("tr").data("permission-id");
    Swal.fire(
        "trying to toggle role with id " +
            role_id +
            " and permission with id " +
            permission_id
    );

    let baseURL = route("welcome");

    Swal.fire({
        title: "Zaczekaj",
        html: "zmiana uprawnień",
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: baseURL + "/permission/toggle/" + permission_id + "/" + role_id,
        success: function (result) {
            Swal.fire({
                icon: "success",
                title: "Zaktualizowano",
                showConfirmButton: false,
                timer: 1500,
            });
            console.log(result.active);
        },
    });
});
