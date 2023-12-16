@extends('layouts.main',['title'=>'Settings'])

@section('header')
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-edit"></i>
            Change Your General Information Here 
        </h3>
    </div>
    <div class="card-body">
        <form action="{{ route ('admin.settings') }}" method="POST" class="ajax_form" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home"
                            role="tab" aria-controls="vert-tabs-home" aria-selected="true">Home</a>
                        <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile"
                            role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Images</a>
                        <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages"
                            role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Basic</a>
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                            
                        <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                            <div class="row">
                                {{-- Institute Name --}}
                                <div class="col-md-6 form-group">
                                    <label for="company_name">Institute Name</label>
                                    <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter Your Company Name" value="{{get_option('company_name') }}">
                                </div>
                                {{-- Institute Running Body --}}
                                <div class="col-md-6 form-group">
                                    <label for="institute_top_header">Institute Top Header</label>
                                    <input type="text" name="institute_top_header" id="institute_top_header" class="form-control" placeholder="Enter Your Top Header" value="{{get_option('institute_top_header') }}">
                                </div>

                                  {{-- Institute Running Body --}}
                                <div class="col-md-6 form-group">
                                    <label for="site_titlee">Site Title</label>
                                    <input type="text" name="site_titlee" id="site_titlee" class="form-control" placeholder="Enter Your Site Title" value="{{get_option('site_titlee') }}">
                                </div>
                                {{-- Institute Recognition Number --}}
                                <div class="col-md-6 form-group">
                                    <label for="institute_recognition_number">Institute Recognition Number</label>
                                    <input type="text" name="institute_recognition_number" id="institute_recognition_number" class="form-control" placeholder="Enter Your Company Recognition Number" value="{{get_option('institute_recognition_number') }}">
                                </div>
                                {{-- Institute Recognition Body --}}
                                <div class="col-md-6 form-group">
                                    <label for="institute_recognition_body">Institute Recognition Body</label>
                                    <input type="text" name="institute_recognition_body" id="institute_recognition_body" class="form-control" placeholder="Enter Your Company Recognition Body" value="{{get_option('institute_recognition_body') }}">
                                </div>
                            
                                {{-- Address --}}
                                <div class="col-md-6 form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter Your Company Address" value="{{get_option('address') }}">
                                </div>
                            
                                {{-- Optional More Address --}}
                                <div class="col-md-6 form-group">
                                    <label for="optional_address">Optional More Address</label>
                                    <input type="text" name="optional_address" id="optional_address" class="form-control" placeholder="Enter Your Company Optional More Address" value="{{get_option('optional_address') }}">
                                </div>
                            
                                {{-- Zip/ Postal Code --}}
                                <div class="col-md-6 form-group">
                                    <label for="postal_code">Zip/ Postal Code</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Enter Zip/ Postal Code" value="{{get_option('postal_code') }}">
                                </div>
                            
                                {{-- City  --}}
                                <div class="col-md-6 form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="Enter Your Company City" value="{{get_option('city') }}">
                                </div>
                            
                                {{-- Statu/County --}}
                                <div class="col-md-6 form-group">
                                    <label for="state">Statu/County</label>
                                    <input type="text" name="state" id="state" class="form-control" placeholder="Enter Your Company Statu/County" value="{{get_option('state') }}">
                                </div>
                            
                                {{-- Country --}}
                                <div class="col-md-6 form-group">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" id="country" class="form-control" placeholder="Enter Your Country" value="{{get_option('country') }}">
                                </div>
                            
                                {{-- title --}}
                                <div class="col-md-6 form-group">
                                    <label for="site_title">Website Title</label>
                                    <input type="text" name="site_title" id="site_title" class="form-control" placeholder="Enter Website Title" value="{{get_option('site_title') }}">
                                </div>
                            
                                {{-- Email --}}
                                <div class="col-md-6 form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Enter Your Company Email" value="{{get_option('email') }}">
                                </div>
                            
                                {{-- Phone --}}
                                <div class="col-md-6 form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Your Company Phone" value="{{get_option('phone') }}">
                                </div>
                            
                                {{-- Alternative Phone --}}
                                <div class="col-md-6 form-group">
                                    <label for="alternate_phone">Alternative Phone</label>
                                    <input type="text" name="alternate_phone" id="alternate_phone" class="form-control" placeholder="Enter Your Company Alternative Phone" value="{{get_option('alternate_phone') }}">
                                </div>
                            
                                {{-- Starting Date --}}
                                <div class="col-md-6 form-group">
                                    <label for="start_date">Starting Date</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control take_date" placeholder="Enter Your Company Starting Date" value="{{get_option('start_date') }}">
                                </div>
                            
                                {{-- Fax --}}
                                <div class="col-md-6 form-group">
                                    <label for="fax">Fax</label>
                                    <input type="text" name="fax" id="fax" class="form-control " placeholder="Enter Your Company Fax" value="{{get_option('fax') }}">
                                </div>
                            
                                {{-- Website URL --}}
                                <div class="col-md-6 form-group">
                                    <label for="website_url">Website URL</label>
                                    <input type="text" name="website_url" id="website_url" class="form-control" placeholder="Enter Your Company Website URL" value="{{get_option('website_url') }}">
                                </div>
                            
                                {{-- Company Description --}}
                                <div class="col-md-12 form-group">
                                    <label for="description">Company Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" placeholder="Enter your Company Company Description" rows="2">{{ get_option('description') }}</textarea><span class="text-danger">Maximum 250 Character Executed</span>
                                </div>
                            </div>  

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button id="submit" type="submit" class="btn btn-primary">Update</button>
                                    <button style="display: none;" id="submiting" type="button" disabled class="btn btn-primary">Loading..</button>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                            <div class="row">
                                {{-- Logo --}}
                                <div class="col-md-12 form-group">
                                    <label for="logo">Upload Software Logo</label>
                                    <input type="file" name="logo" id="logo" class="form-control dropify" >
                                    @if(get_option('logo'))
                                        <input type="hidden" name="oldLogo" value="{{get_option('logo')}}">
                                    @endif
                                    <span class="text-danger">Logo File Size must be under 500 KB, Image Width & height must be 33 X 33 pixel</span>
                                </div>

                                {{-- Favicon --}}
                                <div class="col-md-12 form-group">
                                    <label for="favicon">Upload Software favicon</label>
                                    <input type="file" name="favicon" id="favicon" class="form-control dropify" >
                                    @if(get_option('favicon'))
                                        <input type="hidden" name="oldfavicon" value="{{get_option('favicon')}}">
                                    @endif
                                    <span class="text-danger">Logo File Size must be under 200 KB.</span>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"aria-labelledby="vert-tabs-messages-tab">
                            <div class="row">
                                {{-- Facebook Link --}}
                                <div class="col-md-6 form-group">
                                    <label for="facebook_link">Facebook Link</label>
                                    <input type="text" name="facebook_link" id="facebook_link" class="form-control" value="{{get_option('facebook_link')}}" placeholder="Enter Facebook Link">
                                </div>

                                {{-- Twitter Link --}}
                                <div class="col-md-6 form-group">
                                    <label for="twitter_link">Twitter Link</label>
                                    <input type="text" name="twitter_link" id="twitter_link" class="form-control" value="{{get_option('twitter_link')}}" placeholder="Enter Twitter Link">
                                </div>

                                {{-- Youtube Link --}}
                                <div class="col-md-6 form-group">
                                    <label for="youtube_link">Youtube Link</label>
                                    <input type="text" name="youtube_link" id="youtube_link" class="form-control" value="{{get_option('youtube_link')}}" placeholder="Enter Youtube Link">
                                </div>

                                {{-- LinkedIN Link --}}
                                <div class="col-md-6 form-group">
                                    <label for="linkedin_link">LinkedIN Link</label>
                                    <input type="text" name="v" id="linkedin_link" class="form-control" value="{{get_option('linkedin_link')}}" placeholder="Enter LinkedIN Link">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('admin.scripts')
<script>
    _componentSelect2Normal();
    _componentDatePicker();
    _classformValidation();
    _componentDatePicker();
    _componentDropFile();
</script>
@endpush