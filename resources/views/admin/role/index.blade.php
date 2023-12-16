@extends('layouts.main', ['title' => ('User Role Manage'), 'modal' => 'xl',])

@push('admin.css')
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('header')
 <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Or Manage User Role</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                @can('role.create')
                    <div class="card card-info">
                        <a class="bg-info" data-toggle="collapse" data-parent="#accordion" href="#create">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Create New Role
                                </h4>
                            </div>
                        </a>
                        <div id="create" class="panel-collapse collapse in">
                            <div class="card-body">
                                <form action="{{ route('admin.user.role.store') }}" method="post" id="content_form">
                                    @csrf
                                    <div class="row">
                                        {{-- Date --}}
                                        <div class="col-md-12 form-group">
                                            <label for="date">{{ __('Role Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control" required placeholder="Enter Role Name">
                                        </div>

                                        {{-- Permission --}}
                                        <div class="col-md-12 table-responsive">
                                            <label for="permission">Permission</label>
                                            <table class="table table-bordered">
                                                @foreach (split_name($permissions) as $key => $element)
                                                    <tr>
                                                        <td rowspan ="{{count($element)+1}}">{!! $key !!}</td>
                                                        <td rowspan="{{count($element)+1}}">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input select_all" id="select_all_{{$key}}" data-id="{{$key}}">
                                                                <label class="custom-control-label" for="select_all_{{$key}}">Select All</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @foreach ($element as $per)
                                                        <tr>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input {{$key}}" id="{{$per}}" multiple="multiple" name="permissions[]" value="{{$per}}">
                                                                    <label class="custom-control-label" for="{{$per}}">{{tospane($per)}}</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </table>
                                        </div>

                                    </div>
                                    <button type="submit" id="submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Submit</button>
                                    <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5" id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                                
                                    <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan
                <div class="card card-primary">
                    <a class="bg-primary" data-toggle="collapse" data-parent="#accordion" href="#list">
                        <div class="card-header">
                            <h4 class="card-title">
                                Role List 
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.user.role.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Role Name</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Role Name</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="url" value="create">
@endsection

@push('admin.scripts')
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/pages/role.js') }}"></script>
@endpush
