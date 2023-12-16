@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{ route('login') }}" method="post" id="content_form">
                <div class="input-group mb-3">
                    <input data-parsley-errors-container="#emailError" name="email_or_username" id="email_or_username" type="text" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <span id="emailError"></span>

                <div class="input-group mb-3">
                    <input data-parsley-errors-container="#pwderror" name="password" id="password" type="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-lock"></span>
                        </div>
                    </div>
                </div>
                <span id="pwderror"></span>
                <div class="row">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <button name="submit" id="submit" type="submit" class="btn btn-primary btn-block">{{ __('Sign In') }}</button>
                        <button style="display: none;" name="submiting" id="submiting" type="button" class="btn btn-primary" disabled> <i class="fa fa-spinner fa-spin fa-1x"></i><span>Loading..</span></button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            {{-- <div class="social-auth-links text-center mb-3">
                <p>- {{ __('OR') }}-</p>
                <a href="#" class="btn btn-block btn-primary">
                    <i class="fa fa-facebook mr-2"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="fa fa-google-plus mr-2"></i> Sign in using Google+
                </a>
            </div> --}}
            <!-- /.social-auth-links -->
            {{-- @if (Route::has('password.request'))
                <p class="mb-1">
                    <a href="{{ route('password.request') }}">I forgot my password</a>
                </p>
            @endif --}}
            @if (Route::has('register') && get_option('registration') && get_option('registration') == 0)
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                </p>
            @endif

        </div>
        <!-- /.login-card-body -->
    </div>
@endsection

@section('scripts')
<script>
    function notify(message, type){
        $.growl({
            message: message
        },{
            type: type,
            allow_dismiss: true,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: "top",
                align: "right"
            },
            delay: 5000,
            animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
            },
            offset: {
                x: 30,
                y: 30
            }
        });
    };

    /*
    * Form Validation
    */

var _formValidation = function() {
    if ($('#content_form').length > 0) {
        $('#content_form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#content_form').on('submit', function(e) {
        e.preventDefault();
        $('#submit').hide();
        $('#submiting').show();
        $(".ajax_error").remove();
        var submit_url = $('#content_form').attr('action');
        //Start Ajax
        var formData = new FormData($("#content_form")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
                if (data.status == 'danger') {
                    notify(data.message, 'danger');
                } else {
                    notify(data.message, 'success');
                    $('#submit').show();
                    $('#submiting').hide();
                    $('#content_form')[0].reset();
                    if (data.goto) {
                        setTimeout(function() {

                            window.location.href = data.goto;
                        }, 500);
                    }
                }
            },
            error: function(data) {
                $('#submit').show();
                $('#submiting').hide();
                var jsonValue = $.parseJSON(data.responseText);
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function(key, value) {
                        const first_item = Object.keys(errors)[i]
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }
                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        notify(value, 'danger');
                        i++;
                    });
                } else {
                    notify(jsonValue.message, 'danger');
                }

            }
        });
    });
};
_formValidation();

    $('#loginwithgoogle').click(function() {
        var url = $(this).data('url');
        openPopUpWindow(targetField = 2, url)
    });

    $('#loginwithlinkedin').click(function() {
        var url = $(this).data('url');
        openPopUpWindow(targetField = 2, url)
    });

    // open a pop up window
    function openPopUpWindow(targetField,url){
        var w = window.open(url,'_blank','width=400,height=400,scrollbars=1');
        // pass the targetField to the pop up window
        w.targetField = targetField;
        w.focus();
    }

    // this function is called by the pop up window
    function setSearchResult(x){
        if(x == 'no') {
            notify('Sorry. These Crediantials are Wrong', 'danger');
        } else {
            notify('Login Attempt Successfull!!!', 'success');

            setTimeout(function() {
                window.location = '{{ route("admin.home")}} ';
            }, 500);
        }
    }
</script>
@endsection
