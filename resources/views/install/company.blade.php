<div class="card mt-5" id="showing_card">
    <div class="card-header">
        <h4 class="text-center">Login Details</h4>
    </div>
    <div class="card-body">
        <form action="pre-setup/finish" id="content_form" method="POST">
            @csrf
            <div class="row">
                
                {{-- Company Name --}}
                <div class="col-md-12 form-group">
                    <label for="company_name">Company Name</label>
                    <input autofocus type="text" name="company_name" autocomplete="off" id="company_name" class="form-control" placeholder="Enter Your Company Name">
                </div>

                {{-- site Title --}}
                <div class="col-md-12 form-group">
                    <label for="site_titlee">Site Title</label>
                    <input required type="text" name="site_titlee" autocomplete="off" id="site_titlee" class="form-control" placeholder="Enter This Sofyware Titlee">
                </div>

                {{-- Phone --}}
                <div class="col-md-12 form-group">
                    <label for="phone">Phone</label>
                    <input required type="text" name="phone" autocomplete="off" id="phone" class="form-control" placeholder="Enter Your Company Phone">
                </div>

                {{-- Email --}}
                <div class="col-md-12 form-group">
                    <label for="email">Email</label>
                    <input required type="text" name="email" autocomplete="off" id="email" class="form-control" placeholder="Enter Your Company Email">
                </div>

                {{-- Timezone --}}
                <div class="col-md-12 form-group">
                    <label for="timezone">Timezone</label>						
                    <select data-parsley-errors-container="#timezone_error" required class="form-control select" name="timezone" id="timezone" data-placeholder="Select One">
                        <option value="">Select One</option>
                        @foreach (tz_list() as $key=> $time)
                            <option  value="{{$time['zone']}}">{{ $time['diff_from_GMT'] . ' - ' . $time['zone']}}</option>
                        @endforeach
                    </select>
                    <span id="timezone_error"></span>
                </div>

                {{-- Currency Symbol --}}
                <div class="col-md-12 form-group">
                    <label for="currency">Currency Sysbol</label>						
                    <select data-parsley-errors-container="#currency_error" required class="form-control select" name="currency" id="currency" data-placeholder="Select One">
                        <option value="">Select One</option>
                        @foreach (curency() as $key=> $element)
                            <option value="{{$key}} {!!$element!!}">{!!$element!!} ({{$key}}) </option>
                        @endforeach
                    </select>
                    <span id="currency_error"></span>
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
$(".select").select2();
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