/* ------------------------------------------------------------------------------
 *
 *  # Select extension for Datatables
 *
 *  Demo JS code for datatable_extension_select.html page
 *
 * ---------------------------------------------------------------------------- */

$('#edit-btn').on('click', function() {
    $('.personal_info').fadeOut();
    $('#edit-personal-info').fadeIn();
});

$('#present_as_per').change(function() {
    if(this.checked) {
        $('#permanent_address_field').fadeOut();
    } else {
        $('#permanent_address_field').fadeIn();
    }
});

$('#edit-btn-cancel').on('click', function() {
    $('.personal_info').fadeIn();
    $('#edit-personal-info').fadeOut();
});


// Setup module
// ------------------------------
var emran = "";
var DatatableSelect = function() {

    // Basic Datatable examples
    var _componentDatatableSelect = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });

        emran = $('.content_managment_table').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'copy',
                className: 'btn btn-info'
            }, {
                extend: 'csv',
                className: 'btn btn-info'
            }, {
                extend: 'excel',
                className: 'btn btn-info'
            }, {
                extend: 'pdf',
                className: 'btn btn-info'
            }, {
                extend: 'print',
                className: 'btn btn-info'
            }],
            columnDefs: [{
                width: "100px",
                targets: [0]
            }, {
                orderable: false,
                targets: [4]
            }],

            order: [0, 'desc'],
            processing: true,
            serverSide: true,

            ajax: $('.content_managment_table').data('url'),
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'subject',
                    name: 'subject'
                }, {
                    data: 'url',
                    name: 'url'
                }, {
                    data: 'method',
                    name: 'method'
                }, {
                    data: 'ip',
                    name: 'ip'
                }, {
                    data: 'agent',
                    name: 'agent'
                }, {
                    data: 'user_id',
                    name: 'user_id'
                }
            ]

        });


    };

    var _componentRemoteModalLoad = function() {
        $(document).on('click', '#content_managment', function(e) {
            
            e.preventDefault();
            //open modal
            $('#modal_remote').modal('toggle');
            // it will get action url
            var url = $(this).data('url');
            // leave it blank before ajax call
            $('.modal-body').html('');
            // load ajax loader
            $('#modal-loader').show();
            $.ajax({
                    url: url,
                    type: 'Get',
                    dataType: 'html'
                })
                .done(function(data) {
                    $('.modal-body').html(data).fadeIn(); // load response
                    $('#modal-loader').hide();
                    $('#ref_no').focus();
                    _modalFormValidation();
                })
                .fail(function(data) {
                    $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                    $('#modal-loader').hide();
                });
        });
    };



    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableSelect();
            _componentRemoteModalLoad();
            _componentSelect2Normal();
            _componentDatePicker();
            _formValidation();
            _classformValidation();
            _componentDropFile();
            _componenteditor();
            _componenttagsinput();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableSelect.init();
});

var _passwordChange = function() {
    if ($('#password_change').length > 0) {
        $('#password_change').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#password_change').on('submit', function(e) {
        e.preventDefault();
        $('#submit_pwd').hide();
        $('#submiting_pwd').show();
        $(".ajax_error").remove();
        var submit_url = $('#password_change').attr('action');
        //Start Ajax
        var formData = new FormData($("#password_change")[0]);
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
                    $('#submit_pwd').show();
                    $('#submiting_pwd').hide();
                    $('#password_change')[0].reset();
                    $( ".color-accordion" ).accordion({
                        active: 1
                    });
                    if (data.goto) {
                        setTimeout(function() {

                            window.location.href = data.goto;
                        }, 500);
                    }

                    if (data.window) {
                        $('#password_change')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function() {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function() {

                            window.location.href = "";
                        }, 2500);
                    }

                    if (typeof(emran) != "undefined" && emran !== null) {
                        emran.ajax.reload(null, false);
                    }
                }
            },
            error: function(data) {
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
                _componentSelect2Normal();
                $('#submit_pwd').show();
                $('#submiting_pwd').hide();
            }
        });
    });
};

_passwordChange();

var _change_social = function() {
    if ($('#change_social').length > 0) {
        $('#change_social').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#change_social').on('submit', function(e) {
        e.preventDefault();
        $('#submit_social').hide();
        $('#submiting_social').show();
        $(".ajax_error").remove();
        var submit_url = $('#change_social').attr('action');
        //Start Ajax
        var formData = new FormData($("#change_social")[0]);
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
                    $('#submit_social').show();
                    $('#submiting_social').hide();
                    $('#change_social')[0].reset();
                    $( ".color-accordion" ).accordion({
                        active: 1
                    });
                    if (data.goto) {
                        setTimeout(function() {

                            window.location.href = data.goto;
                        }, 500);
                    }

                    if (data.window) {
                        $('#change_social')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function() {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function() {

                            window.location.href = "";
                        }, 2500);
                    }

                    if (typeof(emran) != "undefined" && emran !== null) {
                        emran.ajax.reload(null, false);
                    }
                }
            },
            error: function(data) {
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
                _componentSelect2Normal();
                $('#submit_social').show();
                $('#submiting_social').hide();
            }
        });
    });
};

// change_social
_change_social();

var _personalChange = function() {
    if ($('#perso_change').length > 0) {
        $('#perso_change').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#perso_change').on('submit', function(e) {
        e.preventDefault();
        $('#submit_perso').hide();
        $('#submiting_perso').show();
        $(".ajax_error").remove();
        var submit_url = $('#perso_change').attr('action');
        //Start Ajax
        var formData = new FormData($("#perso_change")[0]);
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
                    $('#submit_perso').show();
                    $('#submiting_perso').hide();
                    $('#perso_change')[0].reset();
                    if (data.goto) {
                        setTimeout(function() {

                            window.location.href = data.goto;
                        }, 500);
                    }

                    if (data.window) {
                        $('#other_change')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function() {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function() {

                            window.location.href = "";
                        }, 2500);
                    }

                    if (typeof(emran) != "undefined" && emran !== null) {
                        emran.ajax.reload(null, false);
                    }
                }
            },
            error: function(data) {
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
                _componentSelect2Normal();
                $('#submit_perso').show();
                $('#submiting_perso').hide();
            }
        });
    });
};

// other_change
_personalChange();

var _otherChange = function() {
    if ($('#other_change').length > 0) {
        $('#other_change').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#other_change').on('submit', function(e) {
        e.preventDefault();
        $('#submit_photo').hide();
        $('#submiting_photo').show();
        $(".ajax_error").remove();
        var submit_url = $('#other_change').attr('action');
        //Start Ajax
        var formData = new FormData($("#other_change")[0]);
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
                    $('#submit_photo').show();
                    $('#submiting_photo').hide();
                    $('#other_change')[0].reset();
                    if (data.goto) {
                        setTimeout(function() {

                            window.location.href = data.goto;
                        }, 500);
                    }

                    if (data.window) {
                        $('#other_change')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function() {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function() {

                            window.location.href = "";
                        }, 2500);
                    }

                    if (typeof(emran) != "undefined" && emran !== null) {
                        emran.ajax.reload(null, false);
                    }
                }
            },
            error: function(data) {
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
                _componentSelect2Normal();
                $('#submit_photo').show();
                $('#submiting_photo').hide();
            }
        });
    });
};

// other_change
_otherChange();

