$('document').ready(function(){
    $.ajaxSetup({
        headers : {
            'CsrfToken': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( "form" ).submit(function( e ) {
      e.preventDefault();
      form = $("form").serialize();
        $.ajax({
            type: 'POST',
            url: 'controller/GenerateMatricNumber.php',
            data: form,
            datatype:'script',
            cache:false,
            beforeSend: function(){
                $('#get_matric').attr('disabled', true);
                $('#get_matric').html('<b>Generating...</b>');
                $('#display-matric-status').html('<b>Please wait while your matric number is been generated...</b>');
            },
            success: function(response){
                if (response.success){
                  $('#get_matric').attr('disabled', true);
                  $('#get_matric').html('<b>Generate matriculation number</b>');
                  $('#display-matric-status').html(`<h3 class='text-green-light'>Your matric number is: <b>${response.matricnumber}</b></h3>`);
                }else if(response.error){
                  $('#display-matric-status').html(`<b>${response.error}</b>`);
                }else{
                  //$('#display-matric-status').html(`<b>${response}</b>`);
                }
            }
        });
    });
});
