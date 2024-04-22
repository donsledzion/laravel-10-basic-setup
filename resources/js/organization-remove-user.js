$(".remove-member").on("click", function () {
    let user_id = $(this).data("id");
    let organization_id = $(this).data("organization-id");
    console.log(
        "About to remove member with id " +
            user_id +
            " from organization with id " +
            organization_id
    );
    Swal.fire({
        title: "Na pewno usunąć użytkownika z organizacji?",
        text: "Wszystkie scenariusze i zadania zostaną przeniesione na administratora organizacji!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tak, usuń!",
        cancelButtonText: "Jednak nie!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: route("organization.remove-member", [
                    organization_id,
                    user_id,
                ]),
                type: "GET",

                success: function (data) {
                    Swal.fire({
                        icon: data.status,
                        title: data.title,
                        text: data.message,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                },
                error: function (response) {
                    console.log(response);
                },
            });
        }
    });
});
