@extends('layouts.main', ['title' => ('Vehicle Report'), 'modal' => 'xl',])
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
            <h4>Vehicle Report</h4>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="card border border-primary">
                <div class="card-body text-center">
                     <div class="row">
                        {{-- Type --}}
                        <div class="col-md-6 form-group mx-auto">
                            <label for="vehicle">Select Vehicle</label>
                            <select name="vehicle" id="vehicle" class="form-control select">
                                <option value="all">All Vehicle</option>
                                @foreach ($vehicles as $item)
                            <option value="{{$item->id}}">{{$item->name}}  ({{$item->type->name}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="date">@lang('Start Date')</label>
                            <input type="text" name="sdate" id="sdate" class="form-control take_date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="date">@lang('End Date')</label>
                            <input type="text" name="edate" id="edate" class="form-control take_date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6 mx-auto mt-2 text-center">
                            <button type="button" id="check_it" class="btn btn-primary btn-sm w-100">@lang('Search')</button>
                            <button type="button"  class="btn btn-primary btn-sm w-100" id="checking" style="display: none;">
                            <i class="fa fa-spinner fa-spin fa-fw"></i>Searching...</button>
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

    vehicle_data(null,null,null);
_componentDatePicker();
$(document).on('click', '#check_it', function() {
    var vehicle = $('#vehicle').val();
    var sdate = $('#sdate').val();
    var edate = $('#edate').val();
      $('#check_it').hide();
      $('#checking').show();
      vehicle_data(sdate,edate,vehicle)

});

function vehicle_data(sdate,edate,vehicle)
{
     $.ajax({
            url: '/admin/report/vehicle_income_show',
            data: {
                sdate: sdate,
                edate: edate,
                vehicle: vehicle
            },
            type: 'Get',
            dataType: 'html'
        })   
        .done(function(data) {
          $("#report_data").html(data);
          $('#check_it').show();
          $('#checking').hide();
           toastr.success('Report Genarate');
        })
}
</script>
@endpush