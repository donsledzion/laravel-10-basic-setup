$('.move-up').on('click',function(){
    let answer_id = $(this).data('id');
    console.log("About to move up answer with id " + answer_id);
});

$('.move-down').on('click',function(){
    let answer_id = $(this).data('id');
    console.log("About to move down answer with id " + answer_id);
});
