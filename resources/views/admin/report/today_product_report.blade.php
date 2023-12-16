@extends('layouts.main', ['title' => ('Product Report'), 'modal' => 'xl',])
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
            <h4>Product Report</h4>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="card border border-primary">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-sm-10 mx-auto">
                            <label for="date">@lang('Select Date')</label>
                            <input type="text" name="date" id="date" class="form-control take_date" value="{{ date('Y-m-d') }}">
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
_componentDatePicker()
$(document).on('click', '#check_it', function() {
      var date = $('#date').val();
      $('#check_it').hide();
      $('#checking').show();
     $.ajax({
            url: '/admin/report/today-product-report',
            data: {
                date: date
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

});

$(function() {
    var date = $('#date').val();
      $('#check_it').hide();
      $('#checking').show();
     $.ajax({
            url: '/admin/report/today-product-report',
            data: {
                date: date
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

});

</script>
@endpush