@extends('layouts.main', ['title' => ('Account Manage'), 'modal' => 'xl',])

@section('header')
   <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
    <a href="{{ route('admin.account.index') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-check-square" aria-hidden="true"></i>@lang('Account')</a>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Account Full View Information :: {{ $model->name }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                {{-- Profile --}}
                <div class="col-md-6 card card-widget widget-user">
                    <div class="widget-user-header bg-info">
                        <p class="widget-user-username">{{ $model->name }}</p>
                        <h6 class="widget-user-desc">Since {{ formatDate($model->opening_date) }}</h6>
                    </div>
                    <div class="widget-user-image">
                        <img style="height: 90px;" class="img-circle elevation-2" src="{{ asset('images/supp.png') }}"
                            alt="Account Image">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-8">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="text-center">
                                            Balance Information
                                        </th>
                                    </tr>
                                    <tr>
                                    <th scope="col">Debit</th>
                                    <th scope="col">Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="text-align: center;font-size: 15px;padding: 3px;color:red">
                                            @php
                                                $amt = $model->account->where('type','Debit')->sum('amount');
                                            @endphp
                                        @if ($amt)
                                           {{ get_option('currency_symbol') }} {{number_format($amt,2)}}
                                         @else 
                                            {{ get_option('currency_symbol') }} 0.00
                                        @endif
                                        </th>
                                        <th style="text-align: center;font-size: 15px;padding: 3px;color:green">
                                             @php
                                                $amt = $model->account->where('type','Credit')->sum('amount');
                                            @endphp
                                             @if ($amt)
                                                {{ get_option('currency_symbol') }} {{number_format($amt,2)}}
                                            @else 
                                            {{ get_option('currency_symbol') }} 0.00
                                             @endif
                                        </th>
                                    </tr>
                                </tbody>
                                </table>


                            </div>


                            <div class="col-sm-4">
                                <div class="description-block">
                                    <div class="description-block">
                                        <a role="button" id="content_managment"
                                            data-url="{{ route('admin.account.edit',$model->id) }}"
                                            class="btn btn-block btn-sm btn-warning" href="" title="Edit Account">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
        </div>

                {{-- Information --}}
                <div class="col-md-6 card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Account Information</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="bg-light p-1">
                            @if ($model->category != '')
                            <h4 class="text-center">Category : {{toWord($model->category)}} </h4>
                            @endif
                            @if ($model->name != '')
                            <h6 class="text-center">Account Name : {{ $model->name }} </h6>
                            @endif
                            @if ($model->display_name != '')
                            <h6 class="text-center">Display Name : {{ $model->display_name }} </h6>
                            @endif
                            @if ($model->alias != '')
                            <h6 class="text-center">Alias : {{ $model->alias }} </h6>
                            @endif
                            @if ($model->phone != '')
                            <h6 class="text-center">Phone : {{ $model->phone }} </h6>
                            @endif
                            @if ($model->salary != '')
                            <h6 class="text-center">Salary : {{ $model->salary }} </h6>
                            @endif
                            @if ($model->address != '')
                            <h6 class="text-center">Address : {{ $model->address }} </h6>
                            @endif
                            @if ($model->account_no != '')
                            <h6 class="text-center">Account No. : {{ $model->account_no }} </h6>
                            @endif
                            @if ($model->check_form != '')
                            <h6 class="text-center">Check Form : {{ $model->check_form }} </h6>
                            @endif
                            @if ($model->check_to != '')
                            <h6 class="text-center">Check To : {{ $model->check_to }} </h6>
                            @endif
                            @if ($model->opening_date != '')
                            <h6 class="text-center">Opening Date : {{ formatDate($model->opening_date) }} </h6>
                            @endif
                            @if ($model->status != '')
                            <h6 class="text-center">Status : {{ $model->status }} </h6>
                            @endif
                        </div>
                    </div>
                </div>
           
        </div>
        <!-- /.card-body -->


    <div class="card">
        <div class="card-header">
            <h3 class="card-title"> {{ $model->name }} Account Transaction</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped " >
                <thead>
                    <tr>
                        <th>@lang('id')</th>
                        <th>@lang('Type')</th>
                        <th>@lang('Sub Type')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Note')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model->account->WhereNull('transaction_id')->WhereNull('parent_id') as $item)
                        <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{$item->sub_type}}</td>
                        <td>{{$item->amount}}</td>
                        <td>{{$item->date}}</td>
                        <td>{{$item->note}}</td>
                        <td>
                            <button title="Update Information" id="content_managment" data-url="{{ route('admin.account-trans.edit',$item->id) }}"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>

                            <button title="Delete" id="delete_item" data-id ="{{ $item->id }}" data-url="{{ route('admin.account-trans.destroy',$item->id) }}"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>


    </div>
    <!-- /.card -->
</div>
</div>
@endsection

@push('admin.scripts')
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/pages/account.js') }}"></script>
@endpush











