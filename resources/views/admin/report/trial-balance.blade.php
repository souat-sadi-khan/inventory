@extends('layouts.main', ['title' => ('Trial Balance Report'), 'modal' => 'xl',])


@section('header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Trial Balance Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fa fa-home"
                                aria-hidden="true"></i></a></li>
                    <li class="breadcrumb-item active">Trial Balance Report</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Show Report Date Wise</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            
            {{-- <form action="{{ route('admin.report.trial_balance_show') }}" method="post" id="content_form2">
                @csrf --}}
                    <div class="row">
                    {{-- Operation Date --}}
                    <div class="col-md-6 form-group mx-auto">
                        <label for="operation_date">Operation Date
                        </label>
                    <input type="text" name="operation_date" id="operation_date" class="form-control take_date" value="{{date('Y-m-d')}}" required placeholder="Enter Operation Date">


                            <button type="submit" id="submit2" class="btn btn-primary float-right mt-2 px-5"><i
                            class="fa fa-search mr-3" aria-hidden="true"></i>Search Now</button>
                    <button type="button" id="submiting2" class="btn btn-sm mt-2 btn-info float-right" id="submiting"
                        style="display: none;">
                        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                    </div>
                </div>



                <div class="card card-primary" id="data">
        </div>




        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection

@push('admin.scripts')
<script src="{{ asset('js/pages/account.js') }}"></script> 
<script>


          $(document).on('click', '#submit2', function () {
        var operation_date = $('#operation_date').val();
        var url = $('#content_form2').data('url');

        $.ajax({
            url: '/admin/report/trial-balance-show',
            data:{operation_date : operation_date},
            type: 'Get',
            dataType: 'html'
        })
        .done(function(data) {
            $('#data').html(data);
        })
    });
</script>
@endpush
