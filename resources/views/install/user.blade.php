<div class="card mt-5" id="showing_card">
    <div class="card-header">
        <h4 class="text-center">Login Details</h4>
    </div>
    <div class="card-body">
        <form action="pre-setup/store_user" id="content_form" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group input-group-danger">
                        <span class="input-group-addon">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                        <input autofocus autocomplete="off" data-parsley-errors-container="#hostname_name" type="text" class="form-control" required placeholder="Enter Your Name" name="name" id="name">
                    </div>
                    <span id="hostname_name"></span>
                </div>
                
                {{-- Email --}}
                <div class="col-md-12">
                    <div class="input-group input-group-danger">
                        <span class="input-group-addon">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                        <input autocomplete="off" data-parsley-errors-container="#database_email" type="email" class="form-control" required placeholder="Enter Your Email" name="email" id="email">
                    </div>
                    <span id="database_email"></span>
                </div>
                
                {{-- Usename --}}
                <div class="col-md-12">
                    <div class="input-group input-group-danger">
                        <span class="input-group-addon">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                        <input autocomplete="off" data-parsley-errors-container="#username_error" type="text" class="form-control" required placeholder="Enter Your Username" name="username" id="username">
                    </div>
                    <span id="username_error"></span>
                </div>
                
                {{-- Password --}}
                <div class="col-md-12">
                    <div class="input-group input-group-primary">
                        <span class="input-group-addon">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                        </span>
                        <input data-parsley-errors-container="#password_error" autocomplete="off" type="password" class="form-control" placeholder="Enter Your Password" required name="password" id="password">
                    </div>
                    <span id="password_error"></span>
                </div>
            </div>

            <div class="text-center">  
                <button type="submit" name="submit" id="submit" class="mt-5 btn btn-out btn-primary btn-square">Next</button>
                <button style="display:none;" type="button" name="submiting" id="submiting" disabled class="mt-5 btn btn-out btn-primary btn-square"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>Loading...</button>
            </div>
        </form>
    </div>
</div>

<script>

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
                    
                    if(data.stepOver) {
                        $('#showing_card').html('');
                        $('#showing_card').html(data.stepOver);
                    }
                }

                $('#submit').show();
                $('#submiting').hide();
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
                    notify(jsonValue.message, 'warning');
                }
            }
        });
    });
};

_formValidation();


</script>