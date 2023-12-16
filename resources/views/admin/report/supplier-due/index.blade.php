@extends('layouts.main', ['title' => ('Supplier Report'), 'modal' => 'xl',])
@push('admin.css')
@endpush
@section('header')
<a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i
class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
<a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club"
aria-hidden="true"></i>@lang('Today')</a>
<a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank"
    class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play"
aria-hidden="true"></i>@lang('Tutorial')</a>
<a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle"
aria-hidden="true"></i>@lang('Help')</a>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Supplier Report</h4>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="card border border-primary">
                <div class="card-body text-center">
                     <div class="row">
                        {{-- Type --}}
                        <div class="col-md-6 form-group mx-auto">
                            <label for="vehicle">Select Supplier</label>
                            <select data-url="{{ route('admin.report.show-supplier-due-report') }}" name="supplier_id" id="supplier_id" class="form-control select" data-placeholder="Select Supplier">
                                <option value="">Select Supplier</option>
                                <option value="all">All Supplier</option>
                                @foreach ($suppliers as $item)
                            <option value="{{$item->id}}">{{$item->sup_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="report_data"></div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection
@push('admin.scripts')
<script>

    $(".select").select2({ width: '100%' });  

    
    $('.select').change(function() {
        var val = $(this).val();
        var url = $(this).data('url');

        $.ajax({
            url: url,
            data: {
                val: val
            },
            type: 'Get',
            dataType: 'html'
        })
        .done(function(data) {
          $('#report_data').html(data);
           toastr.success('Report Genarate');
        })
    });

    $('.select').val('all').trigger('change');  


</script>
@endpush