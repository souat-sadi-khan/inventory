<!-- jQuery -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/theme.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<!-- Date Dropper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.9/datepicker.min.js" integrity="sha256-ZfF8n2U/HAoaw9WFo8VCUbLo58Q/goLRQ1TFrf4DA94=" crossorigin="anonymous"></script>
<!-- Select 2 -->
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<!-- Main Js -->
<script src="{{ asset('js/main.js') }}"></script>
<!-- parsley js -->
<script type="text/javascript" src="{{ asset('assets/js/parsley.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('install/js/growl.min.js') }}"></script>
<!-- Drophify -->
<script type="text/javascript" src="{{ asset('assets/js/drophify.min.js') }}"></script>
<!-- Sweet Alert -->
<script type="text/javascript" src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<!-- Toastr -->
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    $(document).ready(function() {
        setInterval(timestamp, 1000);
    });

    function timestamp() {
        var time = '{{ formatDate(date('Y-m-d h:i:s')) }}';
        $('#timestamp').html(time);
    }
</script>
@stack('admin.scripts')