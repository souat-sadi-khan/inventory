@extends('layouts.payment',['title' => ('Print Payment'), 'url' => null,])
@section('main_payment')
        <div class="container">
            <div class="row">
                <div class="col-md-2 my-auto">
                    <img src="Logo2.png" class="w-100" alt="">
                </div>
                <div class="col-md-10 text-center">
                    <p class="mb-"> {{get_option('institute_top_header') }}</p>
                    <p class="h1"> {{get_option('company_name') }} </p>
                    <p class=" mb-0"> {{ get_option('description') }} </p>
                </div>
                <div class="col-md-12 text-center">
                    <div class="border-one">
                       <p class="mb-0  text-light"> ফোনঃ {{ get_option('alternate_phone') }} , মোবাইলঃ {{ get_option('phone') }}</p>
                    </div>
                </div>
            </div>
            @php
			$date =explode('-',$model->payment_date);
		    @endphp
            <div class="row mt-4">
                <div class="col-md-4">
                    <p> ভাউচার নং ঃ {{$model->payment_ref_no}} </p>
                </div>
                <div class="col-md-4 text-center">
                    <span class="h3 border-two rounded-pill py-1 px-2">{{ $payment_type }} </span>
                </div>
                <div class="col-md-4 text-right">
                    <div>
                        <span class="mb-2"> তারিখঃ </span>
                        <table class="table table-bordered d-inline border-0">
                            <tbody>
                                <tr>
                                    <td class="py-1">{{ $date[2] }}</td>
									<td class="py-1">{{ $date[1] }}</td>
									<td class="py-1">{{ $date[0] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-1">
                        <span class=""> বারঃ </span>
                        <table class="table table-bordered d-inline border-0">
                            <tbody>
                                <tr>
                                    <td class="py-1"> {{ date('D') }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered border-0">
                        <tbody>
                            <tr>
                                <th class="py-1" scope="row"> Payment Type <span class="float-right"> : </span> </th>
                                <td class="py-1"> {{ $payment_type }}</td>

                                <th class="py-1" scope="row"> Transaction Ref <span class="float-right"> : </span> </th>
                                <td class="py-1"> {{ $model->transaction->reference_no }}</td>
                            </tr>
                          @if ($model->customer)
                          	 <tr>
                                <th class="py-1" scope="row"> নাম / মেসার্স <span class="float-right"> : </span> </th>
                                <td class="py-1"> {{ $model->customer->customer_name }}</td>
                            </tr>
                            <tr class="my-1">
                                <th class="py-1" scope="row"> ঠিকান <span class="float-right"> : </span> </th>
                                <td class="py-1"> {{ $model->customer->customer_addess }}</td>
                            </tr>
                            @else
                             <tr>
                                <th class="py-1" scope="row"> নাম / মেসার্স <span class="float-right"> : </span> </th>
                                <td class="py-1"> {{ $model->supplier->sup_name }}</td>
                            </tr>
                            <tr class="my-1">
                                <th class="py-1" scope="row"> ঠিকানা <span class="float-right"> : </span> </th>
                                <td class="py-1"> {{ $model->supplier->sup_addess }}</td>
                            </tr>
                          @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="table table-bordered border-0">
                        <thead class="thead-dark">
                            <tr>
                                <th class="w-50" scope="col">Note</th>
                                <th class="w-50" scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="c-table">
                                <td>{{ $model->note }}</td>
                                <td>{{ $model->amount }} {{ get_option('currency_symbol') }}</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    
@endsection