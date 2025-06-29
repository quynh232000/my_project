function confirmDeletion(id, url, r = 'this') {

    Swal.fire({
        text: "Are you sure you want to delete " + r + "?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Yes, delete!",
        cancelButtonText: "No, cancel",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    }).then(function (t) {
        if (t.value) {
            handleConfirmDelete(id, url)
        } else if (t.dismiss === "cancel") {
            Swal.fire({
                text: r + " was not deleted.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary"
                }
            })
        }
    });

}

function handleConfirmDelete(id, url, r) {

    ids = []
    if (id == 0) {
        $('input[name="id[]"]:checked').map(function () {
            ids.push($(this).val());
        });
    }else{
        ids = [id]
    }
    $.ajax({
        type: "POST",
        url: url,
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: ids,
        },
        datatype: "html",
        success: (res) => {
            if (res.status) {
                Swal.fire({
                    text: res.message ?? ("You have deleted " + r + "!"),
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary"
                    }
                }).then(function () {
                    window.location.reload();
                })
            } else {
                Swal.fire({
                    text: res.message ?? (r + " was not deleted."),
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary"
                    }
                })
            }
        },
        error: function (error) {

            console.log('Somthing wrong: ', error);
            Swal.fire({
                text: error.statusText ?? (r + " was not deleted."),
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary"
                }
            })
        },
    });
    //return false;
}
