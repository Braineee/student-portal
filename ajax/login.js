$('document').ready(function(){
    $.ajaxSetup({
        headers : {
            'CsrfToken': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // check the appnum
    $('#appnum').on('blur', function(){
        var appnum_ = $('#appnum').val();
        if(appnum_ == ""){
          error_alert('Please enter your appnumber');
          $('#login').attr("disabled", true);
        }else{
            $('#login').attr("disabled", false);
        }
    });

    //check the password
    $('#password').on('blur', function(){
        var password_ = $('#password').val();
        if(password_ == ""){
          error_alert('Please enter your password');
          $('#login').attr("disabled", true);
        }else{
            $('#login').attr("disabled", false);
        }
    });

    $( "form" ).submit(function( e ) {
        e.preventDefault();

        if($('#appnum').val() == "" || $('#password').val() == ""){
            if($('#appnum').val() == ""){
              error_alert('Please enter your app number');
              $('#appnum').focus();
              $('#login').attr("disabled", true);
            }else if($('#password').val() == ""){
              error_alert('Please enter your password');
              $('#password').focus();
              $('#login').attr("disabled", true);
            }
        }else{
          confirm_login_details();
        }

        // confirm the login details
        function confirm_login_details(e){
            form = $("form[name=form-signin]").serialize();
            $.ajax({
                method: 'POST',
                url: 'controller/Login.php',
                data: form,
                cache:false,
                beforeSend: function(){
                    $("#error").fadeOut();
                    $("#login").html('Please wait...');
                    $("#login").attr("disabled", true);
                },
                success: function(response){
                    if(response.response == 'true'){
                        $("#login").html('Sign in...');
                        $("#login").attr("disabled", true);
                        window.location.href = '?pg=home';
                    }else{
                        $("#error").fadeIn(1000,function(){
                          error_alert(response.response);
                          $("#login").html('Sign in');
                          $("#login").attr("disabled", false);
                        });
                    }
                }
            });
        }

        function error_alert(value){
          $('#error').html(`<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp;${value}</div>`);
        }
    });//ends login
});
