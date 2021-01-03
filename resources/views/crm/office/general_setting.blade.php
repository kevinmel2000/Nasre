@extends('crm.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
      <div class="card card-secondary">
        <div class="card-header bg-gray">
          <div class="card-title card-primary">{{__('General Settings')}}</div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <form @if (@$company_name) action="{{url('office/general_setting', $company_name)}}" @else action="{{url('office/general_setting/store')}}" @endif method="post">
                @csrf
                @if (@$company_name)
                  @method('PUT')
                @endif
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-gray">
                            <h4 class="card-title">{{__('Company Details')}}</h4>
                        </div>
                        <div class="card-body bg-light-gray pb-5">
                          @csrf

                            <div class="form-group">
                              <label><span class="text-danger">* </span>{{__('Company Name')}} </label>
                              <div class="input-group">
                                  <input type="text" name="company_name" class="form-control form-control-sm" value="{{@$company_name->field_value}}" required>
                              </div>
                            </div>

                            <div class="form-group">
                              <label><span class="text-danger"> </span>{{__('Address')}} </label>
                              <div class="input-group">
                                  <input type="text" name="company_address" class="form-control form-control-sm" value="{{@$company_address->field_value}}" >
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><span class="text-danger"> </span>{{__('City')}} </label>
                                  <div class="input-group">
                                      <input type="text" name="company_city" class="form-control form-control-sm" value="{{@$company_city->field_value}}" >
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><span class="text-danger"> </span>{{__('State')}} </label>
                                  <div class="input-group">
                                      <input type="text" name="company_state" class="form-control form-control-sm" value="{{@$company_state->field_value}}" >
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><span class="text-danger"> </span>{{__('Country')}} </label>
                                  <div class="input-group">
                                      <input type="text" name="company_country" class="form-control form-control-sm" value="{{@$company_country->field_value}}" >
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><span class="text-danger"> </span>{{__('Zip')}} </label>
                                  <div class="input-group">
                                      <input type="text" name="company_zip" class="form-control form-control-sm" value="{{@$company_zip->field_value}}">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><span class="text-danger"> </span>{{__('Phone')}} </label>
                                  <div class="input-group">
                                      <input type="text" name="company_phone" class="form-control form-control-sm" value="{{@$company_phone->field_value}}" >
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><span class="text-danger"> </span>{{__('Email')}} </label>
                                  <div class="input-group">
                                      <input type="text" name="company_email" class="form-control form-control-sm" value="{{@$company_email->field_value}}" >
                                  </div>
                                </div>
                              </div>
                            </div>

                        </div>
                        <input type="submit" value="{{__('Save Address')}}" class="btn btn-primary">
                    </div>
                  </div>
                </div>
              </form>

              {{-- SingleRowData - Terms and Conditions --}}

            </div>
  
            <div class="col-md-6">
              <form @if (@$logo) action="{{url('office/general_setting/logo', $logo)}}" @else action="{{url('office/general_setting/logo/store')}}" @endif method="post" enctype="multipart/form-data">
                @csrf
                @if (@$logo)
                  @method('PUT')
                @endif
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                        <div class="card-header  bg-gray">
                            <h4 class="card-title">{{__('Company Logo')}}</h4>
                        </div>
                        <div class="card-body  bg-light-gray">
                          @csrf
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label><span class="text-danger">* </span>{{__('Select Image File to upload')}} </label>
                                <div class="input-group">
                                    <input type="file" name="logo_file" id="featured_image" required>
                                    
                                </div>
                              </div>

                            </form>
                            </div>
                          </div>
                        </div>
                        <input type="submit" value="Upload" class="btn btn-primary">
                    </div>
                        <form 
                        @if (@$terms) action="{{url('office/general_setting/terms', $terms)}}" 
                        @else 
                        action="{{url('office/general_setting/terms')}}" 
                        @endif 
                        method="post">
                        @csrf
                        @if (@$terms)
                          @method('PUT')
                        @endif
                        <div class="row">
                          <div class="col-md-12">
                            <div class="card">
                                <div class="card-header  bg-gray">
                                    <h4 class="card-title"> {{__('Terms & conditions')}}</h4>
                                </div>
                                <div class="card-body bg-light-gray">
                                  @csrf
        
                                    <div class="form-group">
                                      <div class="input-group">
                                          <textarea name="terms" id="" cols="30" rows="9"  class="form-control form-control-sm" required>{{@$terms->field_value}}</textarea>
                                      </div>
                                    </div>
        
                                </div>
                                <input type="submit" value="{{__('Save')}}" class="btn btn-primary">
                            </div>
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
</div>


@endsection