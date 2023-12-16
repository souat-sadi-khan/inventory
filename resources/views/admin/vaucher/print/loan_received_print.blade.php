@extends('layouts.voucher',['title' => ('Print Vouchers'), 'url' => null,])
@section('main_voucher')
<div class="container">
    <div class="row">
        <div class="col-md-2 my-auto">
            <img src="{{ get_option('logo') && get_option('logo') != '' ? asset('storage/images/logo'). '/'. get_option('logo') : asset('images/logo.png') }}" class="w-100" alt="" width="90">
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
    <div class="row mt-4">
        <div class="col-md-4">
            <p> ভাউচার নং ঃ {{$model->reff_no}} </p>
        </div>
        <div class="col-md-4 text-center">
            <span class="h3 border-two rounded-pill py-1 px-2">ঋণ গৃহীত </span>
        </div>
        <div class="col-md-4 text-right">
            <div>
                <span class="mb-2"> তারিখঃ </span>
                <table class="table table-bordered d-inline border-0">
                    <tbody>
                        <tr>
                            <td class="py-1">{{ date('d') }}</td>
                            <td class="py-1">{{ date('m') }}</td>
                            <td class="py-1">{{ date('Y') }}</td>
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
                        <th class="py-1" scope="row"> Voucher <span class="float-right"> : </span> </th>
                        <td class="py-1">ঋণ গৃহীত </td>
                    </tr>
                    {{-- <tr>
                        <th class="py-1" scope="row"> নাম / মেসার্স <span class="float-right"> : </span> </th>
                        <td class="py-1"> </td>
                    </tr>
                    <tr class="my-1">
                        <th class="py-1" scope="row"> ঠিকান <span class="float-right"> : </span> </th>
                        <td class="py-1"> </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <table class="table table-bordered border-0">
                {{-- <thead class="thead-dark">
                    <tr>
                        <th colspan="3" class="w-50" scope="col">#</th>
                        <th class="w-25" scope="col">First</th>
                        <th class="w-25" scope="col"></th>
                    </tr>
                </thead> --}}
                <tbody>
                    <tr class="c-table">
                        <td colspan="3">Transaction ID</td>
                        <td>{{ $model->id }}</td>
                    </tr>
                    <tr class="c-table">
                        <td colspan="3">Account</td>
                        <td>{{ $model->account ? $model->account->name : ''}}</td>
                    </tr>
                    <tr class="c-table">
                        <td colspan="3">Amount</td>
                        <td>{{ number_format($model->amount, 2)}}</td>
                    </tr>
                </tbody>
                {{-- <tfoot>
                <tr>
                    <td> fn</td>
                    <td> fn</td>
                    <td> fn</td>
                    <td class="border"></td>
                    <td></td>
                </tr>
                <tr>
                    <td> fn</td>
                    <td> fn</td>
                    <td> fn</td>
                    <td class="border"></td>
                    <td></td>
                </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
</div>

@endsection