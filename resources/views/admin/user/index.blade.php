@extends('layouts.main', ['title' => ('User Manage'), 'modal' => 'xl',])

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
            <h3 class="card-title">Create Or Manage User</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                @can('brand.create')
                    <div class="card card-info">
                        <a class="bg-info" data-toggle="collapse" data-parent="#accordion" href="#create">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Create New user
                                </h4>
                            </div>
                        </a>
                        <div id="create" class="panel-collapse collapse in">
                            <div class="card-body">
                                <form action="{{ route('admin.user.store') }}" method="post" id="content_form">
                                    @csrf
                                    <div class="row">

                                        {{-- Product Brand Image --}}
                                        <div class="col-md-12 form-group">
                                            <label for="image">User Image</label>
                                            <input type="file" name="image" id="image" class="form-control dropify"> <span class="text-danger">User Image must be under 500 KB and width & hieght can not be greater then 110 pixel </span>
                                        </div>

                                        {{-- Product Brand Name --}}
                                        <div class="col-md-4 form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter  Name" required>
                                        </div>

                                        {{-- Product Brand Code Name --}}
                                        <div class="col-md-4 form-group">
                                            <label for="username">User Name  </label>
                                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter User Name" required>
                                        </div>

                                         <div class="col-md-4 form-group">
                                            <label for="email">Email  </label>
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter User email" required>
                                        </div>

                                         {{-- Status --}}
                                        <div class="col-md-4 form-group">
                                            <label for="role">User Role <span class="text-danger">*</span></label>
                                            <select data-parsley-errors-container="#role_error" required name="role" id="role" class="form-control select" required>
                                                <option value="">Select  User Role</option>
                                            @foreach ($roles as $element)
                                                <option value="{{ $element->id }}">{{ $element->name }}</option>
                                            @endforeach
                                            </select>
                                            <span id="role_error"></span>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="password">Password  </label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter User password" required>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="password_confirmation">Password  </label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re type password" required>
                                        </div>
                                    </div>

                                    <button type="submit" id="submit" class="px-5 btn btn-primary float-right">Submit</button>
                                    <button type="button" id="submiting" class="px-5 btn btn-sm btn-info float-right" id="submiting" style="display: none;">
                                        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                                
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
                                User List 
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.user.index') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
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
<script src="{{ asset('js/user.js') }}"></script>
@endpush
