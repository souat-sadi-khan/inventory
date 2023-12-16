	<div  id="print_table" class="card-body">
		<span class="text-center">
            <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
            <h5> {{ get_option('description') }} </h5>
            <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
        
        </span>
        <div class="text-center col-md-12">
            <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                class="bg-success text-light">
                <b>@lang('Vehicle') Report</b></h4>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <td>
    
                            <p style="margin:0px ; margin-top: -8px;">
    
                                Report Of Date : <span class="ml-1">{{ formatDate(date('Y-m-d'))}}</span>
    
                            </p>
    
                        </td>
                        <td class="text-center">
    
                        </td>
                        <td class="text-right">
                            <p style="margin:0px ; margin-top: -8px;">Printing Date :
                                <span></span> {{ date('d F, Y') }} </span></p>
                            <p style="margin:0px ; margin-top: -4px;">Time :
                                <span></span>{{date('h:i:s A')}}</span></p>
                        </td>
                    </tr>
    
                </tbody>
            </table>
        </div>
		<div class="table-responsive">
			<table class="table table-bordered table-sm">
				<tr>
					<td class="text-center">@lang('Total Investment')</td>
					<td class="text-center">
						{{ get_option('currency_symbol') }}
						{{$total_investment}}
					</td>
				</tr>
				<tr>
					<td class="text-center">
						<a target="_blank" href="{{ route('admin.report.vehicle-show-income', $vehicle) }}">@lang('Total Income')</a>
					</td>
					<td class="text-center">
						{{ get_option('currency_symbol') }}
						{{$total_income}}
					</td>
				</tr>
				<tr>
					<td class="text-center">
						<a target="_blank" href="{{ route('admin.report.vehicle-show-expence', $vehicle) }}">@lang('Total Expence')</a>
					</td>
					<td class="text-center">
						{{ get_option('currency_symbol') }}
						{{$total_expence}}
					</td>
				</tr>
				<tr>
					<td class="text-center">@lang('Current Balance')</td>
					<td class="text-center">
						 {{ get_option('currency_symbol') }}
						{{$balance}}
					</td>
				</tr>
			</table>
		</div>

		<br>
		{{-- <h5>In Words: {{ucwords($in_words)}} Taka Only.</h5> --}}
		<br><br><br>

		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-4 text-center">
				<hr class="border-dark">
				<p> Chief Cashier </p>
			</div>
			<div class="col-md-2"></div>
			<div class="col-md-4 text-center">
				<hr class="border-dark">
				<p> Manager </p>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>

	<div class="text-center mb-3">


        @php
        $print_table = 'print_table';

        @endphp

        <a class="text-light btn-primary btn" onclick="printContent('{{ $print_table }}')" name="print"
            id="print_receipt">
            <i class="fa fa-print" aria-hidden="true"></i>
            Print Report

        </a>
    </div>

<script>
	function printContent(el) {
	   console.log('print clicked');

	   var a = document.body.innerHTML;
	   var b = document.getElementById(el).innerHTML;
	   document.body.innerHTML = b;
	   window.print();
	   document.body.innerHTML = a;

	   return window.location.reload(true);

   }
</script>