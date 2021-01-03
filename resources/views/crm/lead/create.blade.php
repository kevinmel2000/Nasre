@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('crm.layouts.breadcrumb')
    <!-- /.content-header -->

    <!-- Main content -->
      <div class="container-fluid">
        <form method="POST" action={{url('/lead')}}>
          @csrf
        <div class="card card-tabs">
          <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
              <li class="pt-1 px-3"><h3 class="card-title">{{__('Lead')}}</h3></li>
              <li class="nav-item">
                <a class="nav-link active" id="lead-details" data-toggle="pill" href="#lead-details-id" role="tab" aria-controls="lead-details-id" aria-selected="true">{{__('Lead Card')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="address-details" data-toggle="pill" href="#address-details-id" role="tab" aria-controls="address-details-id" aria-selected="false">{{__('Address Card')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="social-media-details" data-toggle="pill" href="#social-media-details-id" role="tab" aria-controls="social-media-details-id" aria-selected="false">{{__('Social Media Card')}}</a>
              </li>
              
            </ul>
          </div>
          
          <div class="card-body bg-light-gray">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                {{--  lead Card Starts Here  --}}
                
              <div class="row">
                {{-- ANCHOR SOURCE FIELD --}}
                <div class="col-md-4 col-sm-12">
                  <span><span class="text-danger">*</span> {{__('Source')}}</span>
                  <div class="input-group">
                      <select name="lead_source_id" id="lead_source_id" class="form-control form-control-sm" data-validation="required"  required>
                          <option selected disabled>{{__('Select Lead Source')}}</option>
                      </select>
                      <div class="input-group-append">
                        <button type="button" class="btn plus-button" data-toggle="modal" data-target="#addSourceModal">
                          <span data-toggle="tooltip" data-placement="top" title="{{__('Add New Title')}}"> + </span>
                      </button>
                  </div>
                  </div>
                  <span class="text text-danger">{{@$errors->first('lead_source_id')}}</span>
                </div>

                <div class="col-md-4 col-sm-12">
                  <span><span class="text-danger">*</span> {{__('Status')}}</span>
                  <div class="input-group">
                      <select name="lead_status_id" id="lead_status_id" class="form-control form-control-sm" data-validation="required" required>
                          <option selected disabled>{{__('Select Lead Status')}}</option>
                      </select>
                      <div class="input-group-append">
                        <button type="button" class="btn plus-button" data-toggle="modal" data-target="#addStatusModal">
                          <span data-toggle="tooltip" data-placement="top" title="{{__('Add New Status')}}"> + </span>
                      </button>
                  </div>
                  </div>
                  <span class="text text-danger">{{@$errors->first('lead_status_id')}}</span>
                </div>

                <div class="col-md-4 col-sm-12">
                  <span ><span class="text-danger"></span> {{__('Assigned')}}</span>
                  <div class="input-group">
                      <select name="owner_id" id="owner_id" class="form-control form-control-sm" data-validation="required" required >
                          <option selected disabled>{{__('Select Lead Owner')}}</option>
                          @foreach ($users as $user)
                              <option value="{{$user->id}}">{{$user->name}}</option>
                          @endforeach
                      </select>
                  </div>
                  <span class="text text-danger"></span>
                </div>

              </div>
              

              
              <div class="row mt-3">
                <div class="col-md-4 col-sm-12">
                  @php
                      $tempratures = ['Hot','Warm','Cold'];
                  @endphp  
                  <div class="form-group">
                    <span>{{__('Lead Temprature')}}</span>  
                    <select name="lead_temprature" class="form-control form-control-sm">
                      <option selected disabled>{{__('Select an option')}}</option>
                      @foreach ($tempratures as $temp)
                          <option value="{{$temp}}">{{$temp}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-4 col-sm-12">  
                  @php
                      $score = ['1','2','3','4','5','6','7','8','9','10'];
                  @endphp 
                  <div class="form-group">
                    <span>Lead Score/Rating</span>  
                    <select name="score" class="form-control form-control-sm">
                      <option selected disabled>{{__('Select an option')}}</option>
                      @foreach ($score as $item)
                          <option value="{{$item}}">{{$item}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>  

                <div class="col-md-4 col-sm-12">
                  <span ><span class="text-danger"></span> {{__('Prospect Status')}}</span>
                  <div class="form-group">
                      <select name="prospect_status" id="prospect_status" class="form-control form-control-sm">
                          <option selected disabled>{{__('Select an option')}}</option>
                          
                          @foreach (config('constants.PROSPECTS') as $item)
                              <option defaultValue="{{$item}}">{{$item}}</option>
                          @endforeach
                      </select>
                  </div>
                  <span class="text text-danger"></span>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4 col-sm-12">
                  {{-- ANCHOR TITLE FIELD --}}
                  <span><span class="text-danger">*</span> {{__('Title/Position')}}</span>
                  <div class="input-group">
                      <select name="title_id" id="title_id" class="form-control form-control-sm" required>
                          <option selected disabled>{{__('Select a Title')}}</option>
                      </select>
                      <div class="input-group-append">
                        <button type="button" class=" btn  plus-button" data-toggle="modal" data-target="#addTitleModal">
                          <span data-toggle="tooltip" data-placement="top" title="{{__('Add New Title')}}"> + </span>
                      </button>
                  </div>
                  </div>
                  <span class="text text-danger">{{@$errors->first('title_id')}}</span>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <span ><span class="text-danger"></span> {{__('First Name')}}</span>
                        <input type="text" name="first_name" class="form-control form-control-sm " placeholder="{{__('Enter lead\'s First Name')}}" 
                        />
                    </div>
                    <span class="text text-danger"></span>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <span ><span class="text-danger">*</span> {{__('Last Name')}}</span>
                      <input type="text" name="last_name" class="form-control form-control-sm " placeholder="{{__('Enter lead\'s Last Name')}}" data-validation="length" data-validation-length="2-20" required 
                      />
                  </div>
                  <span class="text text-danger">{{@$errors->first('last_name')}}</span>
              </div>

                <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                      <span ><span class="text-danger"></span> {{__('Company Name')}}</span>
                      <input type="text" name="company_name" class="form-control form-control-sm " placeholder="{{__('Enter Lead\'s Company Name')}}" 
                      />
                  </div>
                  <span class="text text-danger"></span>
                </div>
              </div>

              <div class="row mt-2">

                <div class="col-md-4 col-sm-12">
                  <span ><span class="text-danger"></span>  {{__('Email')}}
                    <span class="float-right">
                      <input type="checkbox" name="email_opt_out" value="yes" >
                      <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Click checkbox to email Opt-out for notifications')}}" ></i>
                    </span>
                  </span>
            
                    <div class="input-group">
                        <input type="text" name="email" class="form-control form-control-sm " placeholder="Enter lead's Email" id="email" >
                    </div>
                    <span class="text text-danger" id="email_error"></span>
                </div>

                <div class="col-md-4 col-sm-12">
                  <span ><span class="text-danger"></span>  {{__('Phone')}}
                    <span class="float-right">
                      <input type="checkbox" name="phone_opt_out" value="yes">
                      <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Click checkbox to phone Opt-out for notifications')}}"></i>
                    </span>
                  </span>
            
                    <div class="input-group">
                        <input type="text" name="phone" class="form-control form-control-sm " placeholder="{{__('Enter lead\'s Phone')}}" />
                        <span class="text text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4 col-sm-12">
                  <span ><span class="text-danger"></span> {{__('Fax')}}
                    <span class="float-right">
                      <input type="checkbox" name="fax_opt_out" value="yes">
                      <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Click checkbox to fax Opt-out for notifications')}}"></i>
                    </span>
                  </span>
            
                    <div class="input-group">
                        <input type="text" name="fax" class="form-control form-control-sm " placeholder="{{__('Enter lead\'s Fax')}}" />
                        <span class="text text-danger"></span>
                    </div>
                </div>                

              </div>   
              <div class="row mt-3">  
                
                <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <span ><span class="text-danger"></span> {{__('WhatsApp Number')}}
                      <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Format: CountryCode PhoneNumber, don\'t use + symbol (CCXXXXXXXXXX)')}}"></i>
                    </span>
                      <input type="number" name="whatsapp" class="form-control form-control-sm " placeholder="{{__('Enter Whatsapp Number')}}" data-validation="length" data-validation-length="max12"/>
                  </div>
                  <span class="text text-danger"></span>
                </div>


                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <span ><span class="text-danger"></span> {{__('Website')}}</span>
                        <input type="text" name="website" class="form-control form-control-sm " placeholder="{{__('Enter Website')}}" />
                    </div>
                    <span class="text text-danger"></span>
                </div>

                <div class="col-md-4 col-sm-12">
                  <span ><span class="text-danger"></span> {{__('Speaks')}}</span>
                  <div class="input-group">
                      <select name="language_id" id="languages_id" class="form-control form-control-sm">
                          <option selected disabled>{{__('Select a language')}}</option>
                          @foreach ($languages as $language)
                              <option value="{{$language->id}}">{{$language->name}}</option>
                          @endforeach
                      </select>
                  </div>
                  <span class="text text-danger"></span>
                </div>

                <div class="col-md-4 col-sm-12">  
                  <div class="form-group">
                    <span>{{__('Industry')}}</span>  
                    <select name="industry_id" id="industries" class="form-control form-control-sm">
                      <option selected disabled>{{__('Select an industry')}}</option>
                      @foreach ($industries as $industry)
                          <option value="{{$industry->id}}">{{$industry->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

             

                <div class="col-md-8 col-sm-12">  
                  <span>{{__('Notes')}}</span>
                  <div class="input-group">
                    <textarea class="form-control form-control-sm" name="note" placeholder="{{__('Notes Here')}}"></textarea>
                  </div>
                </div>

                {{-- {/* lead Card Ends Here */} --}}
              </div>
            </div>
              <div class="tab-pane fade" id="address-details-id" role="tabpanel" aria-labelledby="address-details">
                {{-- ADDRESS Card STARTS HERE --}}
                <div class="row">
                  <div class="col-md-7 col-sm-12">
                      <div class="form-group">
                          <span>{{__('Address Line 1')}}</span>   
                          <input type="text" name="address_line_1" class="form-control form-control-sm " placeholder="{{__('Address Line 1')}}" />
                      </div>
                      <div class="form-group">
                          <span>{{__('Address Line 2')}}</span>   
                          <input type="text" name="address_line_2" class="form-control form-control-sm " placeholder="{{__('Address Line 2')}}" />
                      </div>
          
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <span> {{__('Country Name')}}</span>   
                                  <select name="country_id" class="form-control form-control-sm" 
                                      id="countries" >
                                      <option selected disabled>{{__('Select an option')}}</option>
                                      @foreach ($countries as $country)
                                          <option value="{{$country->id}}">{{$country->name}}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <span> {{__('State Name')}}</span>   
                                  <select name="state_id" class="form-control form-control-sm" id="states">
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <span> {{__('City Name')}}</span> 
                                  <select name="city_id" class="form-control form-control-sm" id="cities">
                                      <option selected disabled>Select an option</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <span> {{__('Zip')}}</span> 
                                  <input type="text" name="zip" class="form-control form-control-sm  " placeholder="{{__('Enter Zip')}}" />
                              </div>
                          </div>
                      </div>
          
                  </div>
                  <div class="col-md-5 col-sm-12">
                      <div class="form-group">
                          <span> {{__('Phone 1')}} </span> 
                          <div class="input-group">
                              <input type="tel" name="phone_1" class="form-control form-control-sm " placeholder="{{__('Enter Phone 1')}}" />
                          </div>
                      </div>
                      <div class="form-group">
                          <span> {{__('Phone 2')}} </span> 
                          <div class="input-group">
                              <input type="tel" name="phone_2" class="form-control form-control-sm " placeholder="{{__('Enter Phone 2')}}" />
                          </div>
                      </div>
                      <div class="form-group">
                          <span> Email 1 </span> 
                          <div class="input-group">
                              <input type="email" name="email_1" class="form-control form-control-sm " placeholder="{{__('Enter Email 1')}}"  />
                          </div>
                      </div>
                      <div class="form-group">
                          <span> {{__('Email 2')}} </span> 
                          <div class="form-group">
                              <input type="email" name="email_2" class="form-control form-control-sm " placeholder="{{__('Enter Email 2')}}" />
                          </div>
                      </div>
                      <div class="form-group">
                          <input type="checkbox" name="is_shipping_address" class="mr-2" id="is_shipping_address" value="yes" />
                          <label for="is_shipping_address"> {{__('Shipping Address')}} </label> 
                           &nbsp; &nbsp; &nbsp; &nbsp;    
                          <input type="checkbox" name="is_billing_address" class="mr-2" id="is_billing_address" value="yes"/>
                          <label for="is_billing_address" > {{__('Billing Address')}} </label> 
                      </div>
                  </div>
              </div>
            </div>
            {{-- ADDRESS CARD ENDS HERE --}}
            {{-- SOCIAL MEDIA CARD STARTS --}}
              <div class="tab-pane fade" id="social-media-details-id" role="tabpanel" aria-labelledby="social-media-details">
                <div class="row">
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Linkedin')}}
                      </span>   
                      <input type="text" name="linkedin" class="form-control form-control-sm " placeholder="{{__('Linkedin')}}" />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Facebook')}}</span>   
                      <input type="text" name="facebook" class="form-control form-control-sm " placeholder="{{__('facebook')}}" />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Twitter')}}</span>   
                      <input type="text" name="twitter" class="form-control form-control-sm " placeholder="{{__('Twitter')}}" />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Skype')}}</span>   
                      <input type="text" name="skype" class="form-control form-control-sm " placeholder="{{__('Skype')}}" />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Instagram')}}</span>   
                      <input type="text" name="instagram" class="form-control form-control-sm " placeholder="{{__('Instagram')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('YouTube')}}</span>   
                      <input type="text" name="youtube" class="form-control form-control-sm " placeholder="{{__('youtube')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Tumblr')}}</span>   
                      <input type="text" name="tumblr" class="form-control form-control-sm " placeholder="{{__('tumblr')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Snapchat')}}</span>   
                      <input type="text" name="snapchat" class="form-control form-control-sm " placeholder="{{__('SnapChat')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Reddit')}}</span>   
                      <input type="text" name="reddit" class="form-control form-control-sm " placeholder="{{__('Reddit')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Pinterest')}}</span>   
                      <input type="text" name="pinterest" class="form-control form-control-sm " placeholder="{{__('pinterest')}}" />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Telegram')}}</span>   
                      <input type="text" name="telegram" class="form-control form-control-sm " placeholder="{{__('Telegram')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Vimeo')}}</span>   
                      <input type="text" name="vimeo" class="form-control form-control-sm " placeholder="{{__('vimeo')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Patreon')}}</span>   
                      <input type="text" name="patreon" class="form-control form-control-sm " placeholder="{{__('patreon')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Flickr')}}</span>   
                      <input type="text" name="flickr" class="form-control form-control-sm " placeholder="{{__('flickr')}}" />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Discord')}}</span>   
                      <input type="text" name="discord" class="form-control form-control-sm " placeholder="{{__('discord')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Tiktok')}}</span>   
                      <input type="text" name="tiktok" class="form-control form-control-sm " placeholder="{{__('tiktok')}}" />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Vine')}}</span>   
                      <input type="text" name="vine" class="form-control form-control-sm " placeholder="{{__('vine')}}" />
                    </div>
                  </div>
                </div>
              </div>
              {{-- SOCIAL MEDIA CARD ENDS --}}
              </div>

            </div>
          </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 com-sm-12">
                        <button class="btn btn-primary btn-block ">
                            {{__('Save Lead')}}
                        </button>
                    </div>
                  
                </div>
            </div>
        </div>   
    </form>
  </div>
    <!-- /.content -->
  </div>

{{-- ANCHOR STATUS MODAL starts here --}}
<div class="modal fade" id="addStatusModal" tabindex="-1" role="dialog" aria-labelledby="addStatusLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-light-gray">
      <div class="modal-header bg-gray">
        <h5 class="modal-title" id="addStatusLabel">{{__('Add Status')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="POST" action="{{url('lead')}}">
            @csrf
            <label for="">{{__('Enter a Unique Status')}}</label>
           
            <input type="hidden" name="return_to" value="lead">
            <input type="text" name="name" id="new_lead_status" class="form-control form-control-sm"/>
            @if($errors)
              @foreach ($errors->all() as $error)
                  <div class="text text-danger">{{ $error }}</div>
              @endforeach
          @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            <button type="submit" class="btn btn-info" id="addStatusBtn" data-dismiss="modal">{{__('Add Status')}}</button>
          </div>
        </form>
    </div>
  </div>
</div>
{{-- STATUS MODAL starts here --}}

{{-- ANCHOR SOURCE MODAL starts here --}}
<div class="modal fade" id="addSourceModal" tabindex="-1" role="dialog" aria-labelledby="addSourceLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-light-gray">
      <div class="modal-header bg-gray">
        <h5 class="modal-title" id="addSourceLabel">{{__('Add Source')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="POST">
            <label for="">{{__('Enter a Unique Source')}}</label>
            <input type="hidden" name="return_to" value="lead">
            <input type="text" name="name" id="new_lead_source" class="form-control form-control-sm"/>
            @if($errors)
              @foreach ($errors->all() as $error)
                  <div class="text text-danger">{{ $error }}</div>
              @endforeach
          @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            <button type="submit" class="btn btn-info" id="addSourceBtn" data-dismiss="modal">{{__('Add Source')}}</button>
          </div>
        </form>
    </div>
  </div>
</div>
{{-- SOURCE MODAL starts here --}}


{{-- ANCHOR TITLE MODAL starts Here --}}
<div class="modal fade" id="addTitleModal" tabindex="-1" role="dialog" aria-labelledby="addTitleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
          <h5 class="modal-title" id="addTitleLabel">{{__('Add Title')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form method="POST">
              <label for="">{{__('Enter a Unique Title ')}}</label>
              <input type="hidden" name="return_to" value="lead">
              <input type="text" name="name" id="new_lead_title" class="form-control form-control-sm"/>
              @if($errors)
                @foreach ($errors->all() as $error)
                    <div class="text text-danger">{{ $error }}</div>
                @endforeach
            @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
              <button type="submit" class="btn btn-info" id="addTitleBtn" data-dismiss="modal">{{__('Add Title')}}</button>
            </div>
          </form>
      </div>
    </div>
  </div>
{{-- Title Modal Ends Here --}}
@endsection


@section('scripts')
@include('crm.lead.create_js')
@endsection