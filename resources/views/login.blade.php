<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Email OTP Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error {
            color: red;
            margin-left: 5px;
        }
        #loader-wrapper {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5);
        z-index: 9999;
    }
    #loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    /* Spinner animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Loader HTML -->
        <div id="loader-wrapper">
            <div id="loader"></div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h2 class="mt-5">Email OTP Login</h2>
                <form id="loginForm" method="post" class="mt-4">
                    @csrf
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="Email" class="form-control" required>
                        <span class="text-success email-success"></span>
                        <span class="text-danger email-error"></span>
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="sendOTP()" class="btn btn-primary btn-send-otp">Send OTP</button>
                        <a href="{{url('/')}}" class="btn btn-primary">Reset</a>
                    </div>
                    <div class="otp-section" style="display: none">
                        <div class="form-group">
                            <label for="otp">OTP:</label>
                            <input type="text" id="otp" placeholder="OTP" name="otp" maxlength="4" class="form-control numeric-input">
                            <span class="otp-error text-danger"></span>
                        </div>
                        <div class="form-group">
                            <button type="button" onclick="checkOtp(this)" class="btn btn-success">Login</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for certain Bootstrap features like modals) -->
    <script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>

        $(document).ajaxStart(function () {
            $('#loader-wrapper').fadeIn();
        });

        // Hide loader when ajax stops (complete)
        $(document).ajaxStop(function () {
            $('#loader-wrapper').fadeOut();
        });

        $('#loginForm').validate({
        rules: {
            'email': {
                required: true,
                email: true
            }
        },
        messages: {
            'email': {
                required: 'Please enetr email.',
                email: 'Please enter a valid email.'
            }
        }
    });
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function() {
        $('.numeric-input').keypress(function(event) {
            if (event.which < 48 || event.which > 57) {
                event.preventDefault();
            }
        });
    });

    function sendOTP() {
        if (!$("#loginForm").valid()) {
            return false;
        }
        var email = $('#email').val();
        if(email != '' && email != null){
            $.ajax({
                url : "{{route('sendotp')}}",
                type : 'POST',
                data : {
                    'email' : email
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success : function(response){
                    if(response.status == 1){
                        $('#email').attr('readonly',true);
                        $('.btn-send-otp').attr('disabled',true)
                        $('.email-success').html(response.message);
                        $('.otp-section').css('display','block');
                        setTimeout(function() {
                            $('.email-success').html('');
                        }, 3000);
                    }else{
                        $('#email').val('');
                        $('.email-error').html(response.message);
                        $('.otp-section').css('display','none');
                        setTimeout(function() {
                            $('.email-error').html('');
                        }, 3000);
                    }
                }
            })
        }
    }

    function checkOtp(thisitem) {
        var email = $('#email').val();
        var otp = $('#otp').val();
        if(otp.length == 0){
            $('.otp-error').html('Please enter OTP.');
            setTimeout(function() {
                $('.otp-error').html('');
            }, 3000);
            return false;
        }
        if(email != '' && email != null && otp != '' && otp != null){
            $('.otp-error').html('');
            $.ajax({
                url : "{{route('loginCheck')}}",
                type : 'POST',
                data : {
                    'email' : email,
                    'otp' : otp,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success : function(response){
                    if(response.status == 1){
                        location.href = "{{route('home')}}"
                    }else{
                        $('#otp').val('');
                        $('.otp-error').html('Invalid Otp please try another!');
                        setTimeout(function() {
                            $('.otp-error').html('');
                        }, 3000);
                    }
                }
            })
        }
    }
    </script>
</body>

</html>