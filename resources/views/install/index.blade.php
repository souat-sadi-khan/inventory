@extends('install.layout')
@section('content')

<div class="row">
    <div class="col-md-12" id="showing_card">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="text-center">Pre Requirment</h4>
            </div>
            <div class="card-body">
                @if(empty($requirements))
                    <div class="text-center">  
                        <h4>Your Server is ready for installation.</h4>
                        <button id="step" data-url="{{ url('pre-setup/database')}}" class="mt-5 btn btn-out btn-primary btn-square">Next</button>
                    </div>
                @else
                    @foreach($requirements as $r)
                        <div class="alert alert-danger border-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled"></i>
                            </button>
                            <strong>Danger!</strong> {{ $r }}
                        </div>
                    @endforeach	
                @endif
            </div>
        </div>
    </div>    
</div>      

@endsection

@section('js-script')
<script>
    $(function() {
        $('#step').click(function() {
            var url = $(this).data('url');
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function() {
                    $('#step').attr('disabled', '1');
                    $('#step').html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>Loading...')
                },
                success: function (data) {
                    $('#showing_card').html(data);
                    notify('Your Server is Ready for Install. Enter Your Database Information', 'success');
                }
            });
        });
    });
</script>

@if ($requirements)
    <script>
        notify('Your Server is Not Ready For Use', 'danger', '');
    </script>
@endif
@endsection