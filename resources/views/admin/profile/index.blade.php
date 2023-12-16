@extends('layouts.main', ['title' => 'My Profile'])

@push('admin.css')
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/summernote-bs4.css') }}">
@endpush

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Profile</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i>
                        </a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ (Auth::user()->image != 'user.png' ? asset('storage/images/user'. '/'. Auth::user()->image) : asset('images/user.png')) }}" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $model->name }}</h3>
                    <p class="text-muted text-center">{{$model->info->designation}}</p>
                </div>
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fa fa-book mr-1"></i> Education</strong>

                    <p class="text-muted">
                        {{$model->info->education}}
                    </p>

                    <hr>

                    <strong><i class="fa fa-map-marker mr-1"></i> Location</strong>

                    <p class="text-muted">
                        @if ($model->info->present_address != '')

                        @else
                            Address is not set yet.
                        @endif
                    </p>

                    <hr>

                    <strong><i class="fa fa-pencil-square-o mr-1"></i> Skills</strong>

                    <p class="text-muted">
                        @if ($model->info->skill != '')

                        @else
                            Skill not added yet.
                        @endif
                    </p>

                    <hr>

                    <strong><i class="fa fa-file mr-1"></i> Notes</strong>

                    <div class="text-muted mt-1">
                        {!!$model->info->notes!!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="#personal_info" data-toggle="tab">Personal Information</a></li>
                        <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password Book</a></li>
                        <li class="nav-item"><a class="nav-link" href="#social" data-toggle="tab">Social Links</a></li>
                        <li class="nav-item"><a class="nav-link" href="#photos" data-toggle="tab">Photo & Other</a></li>
                    </ul>
                </div>

                <div class="card-body">

                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <div class="table-responsive" style="font-size: 12px;">
                                <table class="table table-bordered table-striped content_managment_table" data-url="{{ route('admin.my-activity.datatable') }}">
                                    <thead>
                                        <tr class="thead-dark">
                                            <th width="20px">No</th>
                                            <th>Subject</th>
                                            <th>URL</th>
                                            <th>Method</th>
                                            <th>Ip</th>
                                            <th width="300px">User Agent</th>
                                            <th>User</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="personal_info">
                            <div class="personal_info">
                                <div class="col-md-12">
                                    <h4>Personal Information
                                    <span class="float-right mb-1">
                                        <button id="edit-btn" type="button" class="btn btn-sm btn-primary px-5 "><i class="fa fa-outdent mr-2" aria-hidden="true"></i> Edit </button>
                                    </span>
                                </h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tr class="table-secondary">
                                            <td class="text-right">Name</td>
                                            <td>{{$model->name}} </td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td class="text-right">Email</td>
                                            <td>{{$model->email}} </td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td class="text-right">Username</td>
                                            <td>{{$model->username}} </td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td class="text-right">Status</td>
                                            <td>
                                                @if ($model->active == '1')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-warning">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered table-striped">
                                        <tr class="table-secondary">
                                            <td width="25%" class="text-right">Gender</td>
                                            <td width="25%">{{$model->info->gender}}</td>
                                            <td width="25%" class="text-right">Birth Day</td>
                                            <td width="25%">{{formatDate($model->info->birth_date)}}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td width="25%" class="text-right">Present Address</td>
                                            <td width="25%">{{$model->info->present_address}}</td>
                                            <td width="25%" class="text-right">Present Address Optional</td>
                                            <td width="25%">{{($model->info->present_additional_address)}}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td width="25%" class="text-right">Present City</td>
                                            <td width="25%">{{$model->info->present_city}}</td>
                                            <td width="25%" class="text-right">Present PostCode</td>
                                            <td width="25%">{{($model->info->present_postcode)}}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td width="25%" class="text-right">Present State</td>
                                            <td width="25%">{{$model->info->present_state}}</td>
                                            <td width="25%" class="text-right">Present Country</td>
                                            <td width="25%">{{($model->info->present_country)}}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td width="25%" class="text-right">Parmanent Address</td>
                                            <td width="25%">{{$model->info->parmanent_address}}</td>
                                            <td width="25%" class="text-right">Parmanent Address Optional</td>
                                            <td width="25%">{{($model->info->parmanent_additional_address)}}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td width="25%" class="text-right">Parmanent City</td>
                                            <td width="25%">{{$model->info->parmanent_city}}</td>
                                            <td  width="25%" class="text-right">Parmanent Postcode</td>
                                            <td width="25%">{{$model->info->parmanent_postcode}}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td width="25%" class="text-right">Parmanent State</td>
                                            <td width="25%">{{$model->info->parmanent_state}}</td>
                                            <td width="25%" class="text-right">Parmanent Country</td>
                                            <td width="25%">{{$model->info->parmanent_country}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div id="edit-personal-info" style="display: none;">
                                <form action="{{ route('admin.profile.personal-info-change') }}" method="POST" id="perso_change">
                                    @csrf
                                    <div class="row">
                                        {{-- Name --}}
                                        <div class="col-md-6 form-group">
                                            <label for="name">Name</label>
                                            <input required type="text" name="name" id="name" class="form-control" required placeholder="Enter Your Name" value="{{$model->name}}">
                                        </div>

                                        {{-- birth_date --}}
                                        <div class="col-md-6 form-group">
                                            <label for="birth_date">Date of Birth</label>
                                            <input type="text" name="birth_date" id="birth_date" class="form-control take_date" placeholder="Take Your Birth Date" value="{{formatDate($model->info->birth_date)}}">
                                        </div>

                                        {{-- gender --}}
                                        <div class="col-md-6 form-group">
                                            <label for="gender">Gender</label>
                                            <select name="gender" id="gender" class="form-control select" data-placeholder="Select Gender">
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        {{-- Marital Status --}}
                                        <div class="col-md-6 form-group">
                                            <label for="marigal_status">Marital Status</label>
                                            <select name="marital_status" id="marital_status" class="form-control select" data-placeholder="Select Marital Status">
                                                <option value="">Select Marital Status</option>
                                                <option value="Married">Married</option>
                                                <option value="Unmarried">Unmarried</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <fieldset class="w-100" style="
                                                    display: block;
                                                    margin-inline-start: 2px;
                                                    margin-inline-end: 2px;
                                                    padding-block-start: 0.35em;
                                                    padding-inline-start: 0.75em;
                                                    padding-inline-end: 0.75em;
                                                    padding-block-end: 0.625em;
                                                    min-inline-size: min-content;
                                                    border-width: 2px;
                                                    border-style: groove;
                                                    border-color: threedface;
                                                    border-image: initial;
                                                ">
                                                    <legend style="width: auto"> Present Address: &nbsp; </legend>
                                                    <div class="row">
                                                    {{-- present_address --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="present_address">Present Address</label>
                                                        <input type="text" name="present_address" id="present_address" class="form-control" placeholder="Enter Present Address" value="{{$model->info->present_address}}">
                                                    </div>

                                                    {{-- present_additional_address --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="present_additional_address">Present Additional Address</label>
                                                        <input type="text" name="present_additional_address" id="present_additional_address" class="form-control" placeholder="Enter Present Additional Address" value="{{$model->info->present_additional_address}}">
                                                    </div>

                                                    {{-- present_city --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="present_city">Present City</label>
                                                        <input type="text" name="present_city" id="present_city" class="form-control" placeholder="Enter Present City" value="{{$model->info->present_city}}">
                                                    </div>

                                                    {{-- present_postcode --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="present_postcode">Present PostCode</label>
                                                        <input type="text" name="present_postcode" id="present_postcode" class="form-control" placeholder="Eneer Present Postcode" value="{{$model->info->present_postcode}}">
                                                    </div>

                                                    {{-- present_state --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="present_state">Present Status</label>
                                                        <input type="text" name="present_state" id="present_state" class="form-control" placeholder="Enter Present State" value="{{$model->info->present_state}}">
                                                    </div>

                                                    {{-- present_country --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="present_country">Present Country</label>
                                                        <input type="text" name="present_country" id="present_country" class="form-control" placeholder="Enter Present Country" value="{{$model->info->present_country != '' ? $model->info->present_country : 'Bangladesh'}}">
                                                    </div>

                                                    <div class="custom-control custom-checkbox ml-4 mb-2">
                                                        <input type="checkbox" class="custom-control-input" id="present_as_per" name="present_as_per">
                                                        <label class="custom-control-label" for="present_as_per">Permanet Address is Same</label>
                                                    </div>
                                                </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="permanent_address_field">
                                            <div class="row">
                                                <fieldset class="w-100" style="
                                                    display: block;
                                                    margin-inline-start: 2px;
                                                    margin-inline-end: 2px;
                                                    padding-block-start: 0.35em;
                                                    padding-inline-start: 0.75em;
                                                    padding-inline-end: 0.75em;
                                                    padding-block-end: 0.625em;
                                                    min-inline-size: min-content;
                                                    border-width: 2px;
                                                    border-style: groove;
                                                    border-color: threedface;
                                                    border-image: initial;
                                                ">
                                                    <legend style="width: auto"> Permanet Address: &nbsp; </legend>
                                                    <div class="row">
                                                    {{-- present_address --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="parmanent_address">Permanet Address</label>
                                                        <input type="text" name="parmanent_address" id="parmanent_address" class="form-control" placeholder="Enter Permanet Address" value="{{$model->info->parmanent_address}}">
                                                    </div>

                                                    {{-- parmanent_additional_address --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="parmanent_additional_address">Permanet Additional Address</label>
                                                        <input type="text" name="parmanent_additional_address" id="parmanent_additional_address" class="form-control" placeholder="Enter Permanet Additional Address" value="{{$model->info->parmanent_additional_address}}">
                                                    </div>

                                                    {{-- parmanent_city --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="parmanent_city">Permanet City</label>
                                                        <input type="text" name="parmanent_city" id="parmanent_city" class="form-control" placeholder="Enter Permanet City" value="{{$model->info->parmanent_city}}">
                                                    </div>

                                                    {{-- parmanent_postcode --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="parmanent_postcode">Permanet PostCode</label>
                                                        <input type="text" name="parmanent_postcode" id="parmanent_postcode" class="form-control" placeholder="Eneer Permanet Postcode" value="{{$model->info->parmanent_postcode}}">
                                                    </div>

                                                    {{-- parmanent_state --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="parmanent_state">Permanet Status</label>
                                                        <input type="text" name="parmanent_state" id="parmanent_state" class="form-control" placeholder="Enter Permanet State" value="{{$model->info->parmanent_state}}">
                                                    </div>

                                                    {{-- parmanent_country --}}
                                                    <div class="col-md-6 form-group">
                                                        <label for="parmanent_country">Permanet Country</label>
                                                        <input type="text" name="parmanent_country" id="parmanent_country" class="form-control" placeholder="Enter Permanet Country" value="{{$model->info->parmanent_country != '' ? $model->info->parmanent_country : 'Bangladesh'}}">
                                                    </div>
                                                </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0 mt-3">
                                        <div class="col-md-8 offset-md-4">
                                            <button name="submit" id="submit_perso" type="submit" class="btn btn-primary">Update Information</button>
                                            <button id="edit-btn-cancel" type="button" class="btn btn-danger">Back</button>
                                            <button style="display: none;" name="submiting" id="submiting_perso" type="button" disabled class="btn btn-primary">Loading..</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane" id="password">
                            <form method="POST" action="{{ route('admin.change.password') }}" id="password_change">
                                @csrf

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Current Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                                    <div class="col-md-6">
                                        <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="new_confirm_password" required type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button name="submit" id="submit_pwd" type="submit" class="btn btn-primary">Update Password</button>
                                        <button style="display: none;" name="submiting" id="submiting_pwd" type="button" disabled class="btn btn-primary">Loading..</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="social">
                            <form method="POST" action="{{ route('admin.change.social') }}" id="change_social">
                                @csrf

                                <div class="form-group row">
                                    <label for="facebook_link" class="col-md-4 col-form-label text-md-right"><i class="fa fa-facebook-official" aria-hidden="true"></i></label>

                                    <div class="col-md-6">
                                        <input id="facebook_link" type="text" class="form-control" name="facebook_link" autocomplete="current-password" placeholder="Enter your facebook Link" value="{{$model->info->facebook_link}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="twitter_link" class="col-md-4 col-form-label text-md-right"><i class="fa fa-twitter-square" aria-hidden="true"></i></label>

                                    <div class="col-md-6">
                                        <input id="twitter_link" type="text" class="form-control" name="twitter_link" autocomplete="current-password" placeholder="Enter your Twitter Link" value="{{$model->info->twitter_link}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="skype_link" class="col-md-4 col-form-label text-md-right"><i class="fa fa-skype" aria-hidden="true"></i></label>

                                    <div class="col-md-6">
                                        <input id="skype_link" type="text" class="form-control" name="skype_link" autocomplete="current-password" placeholder="Enter your Skype Link" value="{{$model->info->skype_link}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="website_link" class="col-md-4 col-form-label text-md-right"><i class="fa fa-globe" aria-hidden="true"></i></label>

                                    <div class="col-md-6">
                                        <input id="website_link" type="text" class="form-control" name="website_link" autocomplete="current-password" placeholder="Enter your Website Link" value="{{$model->info->website_link}}">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button name="submit" id="submit_social" type="submit" class="btn btn-primary">Update </button>
                                        <button style="display: none;" id="submiting_social" type="button" disabled class="btn btn-primary">Loading..</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="photos">
                            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.change.other') }}" id="other_change">
                                @csrf

                                {{-- Image --}}
                                <input type="hidden" name="old_image" value="{{$model->image}}">
                                <div class="col-md-12 form-group">
                                    <label for="image">Update Your Profile Picture</label>
                                    <input type="file" name="image" id="image" class="form-control dropify" data-default-file="{{ $model->image != 'user.png' ? asset('storage/images/user'. '/'. $model->image) : asset('images/user.png') }}">
                                    @if ($model->image != 'user.png')
                                        <input type="hidden" name="old_image" value="{{ $model->image }}">
                                    @endif
                                </div>

                                {{-- Education --}}
                                <div class="col-md-12 form-group">
                                    <label for="education">Education</label>
                                    <textarea name="education" id="education" class="form-control" cols="30" rows="2" placeholder="Enter Your Education Background">{{$model->info->education}}</textarea>
                                </div>

                                {{-- Skill --}}
                                {{-- <div class="col-md-12 form-group">
                                    <label for="skill">Skill</label>
                                    <input type="text" name="skill" id="skill" class="form-control tags" placeholder="Enter Some Skills of Yours">
                                </div> --}}

                                {{-- Notes --}}
                                <div class="col-md-12 form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control summernote" cols="30" rows="2" placeholder="Enter Some of Your INformation">{{$model->info->education}}</textarea>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button name="submit" id="submit_photo" type="submit" class="btn btn-primary">Update</button>
                                        <button style="display: none;" name="submiting" id="submiting_photo" type="button" disabled class="btn btn-primary">Loading..</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('admin.scripts')
    <script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js//summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{ asset('js/pages/profile.js') }}"></script>
@endpush
