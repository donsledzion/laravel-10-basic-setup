$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$('.move-up').on('click',function(){
    let answer_id = $(this).data('id');
    changeAnswerOrder("up", answer_id);
    //console.log("About to move up answer with id " + answer_id);
});

$('.move-down').on('click',function(){
    let answer_id = $(this).data('id');
    changeAnswerOrder("down", answer_id);
    //console.log("About to move down answer with id " + answer_id);
});

function changeAnswerOrder(direction, answer_id)
{
    if(direction == "up"){
        route = route('answer.move-up',answer_id);

    } else if(direction == "down"){
        route = route('answer.move-down',answer_id);
    }
    else return;
    Swal.fire({
        title: "Zaczekaj",
        html: "przestawianie odpowiedzi",
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: route,
        method: "POST",
        success: function(data){
                console.log(data.message);
                window.location.reload();
            }
    });
}
