@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('crm.layouts.breadcrumb')

    <!-- Main content -->
      <div class="container-fluid">
        <form method="POST" action={{url('/customer')}} autocomplete="off">
          @csrf
        <div class="card card-default card-tabs">
          <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
              <div class="card-header">Customer</div>
              <li class="nav-item">
                <a class="nav-link active" id="contact-details" data-toggle="pill" href="#contact-details-id" role="tab" aria-controls="contact-details-id" aria-selected="true">{{__('Contact Card')}}</a>
              </li>
              {{-- <li class="nav-item">
                <a class="nav-link" id="address-details" data-toggle="pill" href="#address-details-id" role="tab" aria-controls="address-details-id" aria-selected="false">{{__('Address Card')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="social-media-details" data-toggle="pill" href="#social-media-details-id" role="tab" aria-controls="social-media-details-id" aria-selected="false">{{__('Social Media Card')}}</a>
              </li> --}}
     
            </ul>
          </div>
          
          <div class="card-body bg-light-blue">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="contact-details-id" role="tabpanel" aria-labelledby="contact-details">
                
              <div class="row">
                <div class="card">
                  <div class="card-header bg-gray">
                    <div class="card-title">{{__('Customer Card')}}</div>
                  </div>
                  <div class="card-body bg-light-gray">
                    <div class="row">
                      <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                          <span ><span class="text-danger">*</span> {{__('Username')}} 
                          <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Client can use this username to login in his account.')}}"></i> 
                          <i class="fas fa-info-circle text-primary" data-toggle="tooltip" data-placement="top" title="{{__('Username must be in (lowercase a-z 0-9 allowed). No Spaces allowed')}}"></i>                    
                        </span>
                          <input type="text" name="username" class="form-control form-control-sm"  id="username" value="{{ old('username') }}"  
                          data-validation="required|length|custom" data-validation-regexp="^([a-z0-9]*)$" data-validation-length="2-30"
                          autocomplete="Mandala"
                          required/>
                            <span class="text text-danger" id="username_error">
                              {{@$errors->first('username')}}
                            </span>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-12">
                        <span ><span class="text-danger"></span> {{__('Password')}}</span>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control form-control-sm " data-validation="required" autocomplete="off" required/>
                            <span class="input-group-append">
                              <i id="show_password" class="btn btn-info btn-sm pt-1 fas fa-eye"></i>
                              <i id="hide_password" class="d-hide btn btn-secondary btn-sm pt-1 fas fa-eye-slash"></i>
                            </span>
                        </div>
                        <span class="text text-danger"></span>
                      </div>
                      <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                          <span ><span class="text-danger"></span> {{__('Website')}}</span>
                          <input type="text" name="website" class="form-control form-control-sm "  value="{{ old('website') }}" />
                      </div>
                      <span class="text text-danger"></span>
                      </div>
                          
                      <div class="col-md-4 col-sm-12">
                          <div class="form-group">
                              <span ><span class="text-danger"></span> {{__('Company Prefix')}}</span>
                              <input type="text" name="company_prefix" class="form-control form-control-sm "  value="{{ old('company_prefix') }}" />
                          </div>
                          <span class="text text-danger"></span>
                      </div>
      
                      <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                          <span ><span class="text-danger"></span> {{__('Company Name')}}</span>
                          <input type="text" autocomplete="off" name="company_name" class="form-control form-control-sm "  value="{{ old('company_name') }}"
                          />
                        </div>
                        <span class="text text-danger"></span>
                      </div>
      
                      <div class="col-md-4 col-sm-12">
                          <span ><span class="text-danger"></span> {{__('Company Suffix')}}</span>
                          <div class="form-group">
                            <input type="text" autocomplete="off" name="company_suffix" class="form-control form-control-sm "  value="{{ old('company_suffix') }}"
                            />
                          </div>
                          <span class="text text-danger"></span>
                        </div>
                          </div>
                          <span class="text text-danger"></span>
                      </div>
      
                      <div class="col-md-4 col-sm-12">
                          <span ><span class="text-danger"></span> {{__('Prospect Type')}}</span>
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
                      <div class="col-md-4 col-sm-12">
                        <span ><span class="text-danger"></span> {{__('Customer Type')}}</span>
                        <div class="form-group">
                            <select name="customer_type" id="type" class="form-control form-control-sm " >
                                <option selected disabled>{{__('Select an option')}}</option>
                                @foreach (config('constants.CONTACT_TYPES') as $item)
                                    <option defaultValue="{{$item}}">{{$item}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <span class="text text-danger"></span>
                    </div>
      
      
                      <div class="col-md-8 col-sm-12">  
                        <span>{{__('Notes')}}</span>
                        <div class="input-group">
                          <textarea class="form-control form-control-sm" rows="4" name="note"></textarea>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-12">  
                        <div class="form-group">
                          <span ><span class="text-danger"></span> {{__('VAT Number')}}</span>
                          <input type="text" name="vat_number" class="form-control form-control-sm "  value="{{ old('vat_number') }}" />
                      </div>
                      <span class="text text-danger"></span>
                      </div>



                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header bg-gray">
                    <div class="card-title">{{__('Primary Contact')}}</div>
                  </div>
                  <div class="card-body bg-light-gray">
                    <div class="row">
                      <div class="col-md-3 col-sm-12">
                        <span><span class="text-danger">*</span> {{__('Title/Position')}}</span>
                        <div class="input-group">
                            <select name="title_id" id="title_id" class="form-control form-control-sm" required>
                                <option selected disabled>{{__('Select a Title')}}</option>
                            </select>
                            <div class="input-group-append">
                              <button type="button" class=" btn  plus-button" data-toggle="modal" data-target="#addTitleModal">
                                <span data-toggle="tooltip" data-placement="top" title="Add New Title"> + </span>
                            </button>
                        </div>
                        </div>
                        <span class="text text-danger">{{@$errors->first('title_id')}}</span>
                      </div>
      
                      <div class="col-md-3 col-sm-12">
                          <div class="form-group">
                              <span ><span class="text-danger"></span> {{__('First Name')}}</span>
                              <input type="text" name="first_name" class="form-control form-control-sm " value="{{ old('first_name') }}"  
                              />
                          </div>
                          <span class="text text-danger">{{@$errors->first('first_name')}}</span>
                      </div>
                      <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <span ><span class="text-danger">*</span> {{__('Last Name')}}</span>
                            <input type="text" name="last_name" class="form-control form-control-sm " value="{{ old('last_name') }}" required 
                            />
                        </div>
                        <span class="text text-danger">{{@$errors->first('last_name')}}</span>
                      </div>
      
      
      
                      <div class="col-md-3 col-sm-12">
                          <div class="form-group">
                              <span ><span class="text-danger">*</span> {{__('Email')}}</span>
                              <input type="text" name="email" class="form-control form-control-sm "  id="email" value="{{ old('email') }}" data-validation="required|email" required/>
                              <span class="text text-danger" id="email_error">
                                {{@$errors->first('email')}}
                              </span>
                          </div>
                      </div>
      
                      <div class="col-md-3 col-sm-12">
                          <div class="form-group">
                              <span ><span class="text-danger"></span> {{__('Phone')}}</span>
                              <input type="text" name="phone" class="form-control form-control-sm "  value="{{ old('phone') }}" />
                          </div>
                          <span class="text text-danger"></span>
                      </div>
                      <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <span ><span class="text-danger"></span> {{__('WhatsApp')}}
                            <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Format: CountryCode PhoneNumber, don\'t use + symbol (CCXXXXXXXXXX)')}}"></i>
                            </span>
                            <input type="text" name="whatsapp" class="form-control form-control-sm " value="{{ old('whatsapp') }}"  />
                        </div>
                        <span class="text text-danger"></span>
                      </div>
      
      
      
                      <div class="col-md-3 col-sm-12">
                        <span ><span class="text-danger"></span> {{__('Customer Speaks')}}</span>
                        <div class="input-group">
                            <select name="language_id" id="languages" class="form-control form-control-sm">
                                <option selected disabled>{{__('Select a language')}}</option>
                                @foreach ($languages as $language)
                                    <option value="{{$language->id}}">{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text text-danger"></span>
                      </div>
      
                      <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <span>{{__('Personal ID')}}</span>   
                            <input type="text" name="personal_id" class="form-control form-control-sm "  value="{{ old('personal_id') }}" />
                        </div>
                      </div>
      
      
                      <div class="col-md-3 col-sm-12">
                        <span>{{__('Birth Date')}}</span>   
                        <div class="input-group">
                          <input type="date" name="birth_date" class="form-control form-control-sm" 
                           />
                        </div>
                      </div>
                      
                      <div class="col-md-3 col-sm-12">  
                        <div class="form-group">
                          <label class="mr-3"><span class="text-danger"></span> {{__('Decision Maker')}}</label>
                          <input type="radio" name="decision_maker" id="yes" class="mr-1" value="yes" checked />
                          <label for="{{__('Yes')}}" class="mr-3">{{__('Yes')}}</label>
                          <input type="radio" name="decision_maker" id="no" class="mr-1" value="no" />
                          <label for="{{__('No')}}">{{__('No')}}</label>
                        </div>
                      </div> 
      
                      <div class="col-md-4 col-sm-12">  
                        <div class="form-group">
                          <label class="mr-3">{{__('Gender')}}</label>   
                          <input type="radio" name="gender" id="male" class="mr-1" value="male"  checked />
                          <label for="male" class="mr-3">{{__('Male')}}</label>
                          <input type="radio" name="gender" id="female" class="mr-1" value="female"  />
                          <label for="female" class="mr-3">{{__('Female')}}</label>
                          <input type="radio" name="gender" id="other" class="mr-1" value="other"  />
                          <label for="other" class="mr-3">{{__('Other')}}</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <div class="tab-pane fade" id="address-details-id" role="tabpanel" aria-labelledby="address-details">
                <div class="row">
                  <div class="col-md-7 col-sm-12">
                      <div class="form-group">
                          <span>{{__('Address Line 1')}}</span>   
                          <input type="text" name="address_line_1" class="form-control form-control-sm "  value="{{ old('address_line_1') }}" />
                      </div>
                      <div class="form-group">
                          <span>{{__('Address Line 2')}}</span>   
                          <input type="text" name="address_line_2" class="form-control form-control-sm " value="{{ old('address_line_2') }}" />
                      </div>
          
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <span> {{__('Country Name')}}</span>   
                                  <select name="country_id" class="form-control form-control-sm"  id="countries" >
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
                                      <option selected disabled>{{__('Select an option')}}</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <span> {{__('Zip')}}</span> 
                                  <input type="text" name="zip" class="form-control form-control-sm  "  value="{{ old('zip') }}" />
                              </div>
                          </div>
                      </div>
          
                  </div>
                  <div class="col-md-5 col-sm-12">
                      <div class="form-group">
                          <span> {{__('Phone 1 ')}}</span> 
                          <div class="input-group">
                              <input type="tel" name="phone_1" class="form-control form-control-sm "  value="{{ old('phone_1') }}" />
                          </div>
                      </div>
                      <div class="form-group">
                          <span> {{__('Phone 2')}} </span> 
                          <div class="input-group">
                              <input type="tel" name="phone_2" class="form-control form-control-sm "  value="{{ old('phone_2') }}" />
                          </div>
                      </div>
                      <div class="form-group">
                          <span> {{__('Email 1')}} </span> 
                          <div class="input-group">
                              <input type="email" name="email_1" class="form-control form-control-sm "  value="{{ old('email_1') }}" />
                          </div>
                      </div>
                      <div class="form-group">
                          <span> Email 2 </span> 
                          <div class="form-group">
                              <input type="email" name="email_2" class="form-control form-control-sm "  value="{{ old('email_2') }}" />
                          </div>
                      </div>
                      <div class="form-group">
                          <input type="checkbox" name="is_shipping_address" class="mr-2" id="is_shipping_address" value="yes" />
                          <label for="is_shipping_address"> {{__('Shipping Address')}} </label> 
                           &nbsp; &nbsp; &nbsp; &nbsp;    
                          <input type="checkbox" name="is_billing_address" class="mr-2" id="is_billing_address" value="yes"/>
                          <label for="is_billing_address" > {{__('Billing Address ')}}</label> 
                      </div>
                  </div>
              </div>
            </div>
        
              <div class="tab-pane fade" id="social-media-details-id" role="tabpanel" aria-labelledby="social-media-details">
                <div class="row">
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Linkedin')}}</span>   
                      <input type="text" name="linkedin" class="form-control form-control-sm "  value="{{ old('linkedin') }}" />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Facebook')}}</span>   
                      <input type="text" value="{{ old('facebook') }}" name="facebook" class="form-control form-control-sm " />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Twitter')}}</span>   
                      <input type="text" value="{{ old('twitter') }}" name="twitter" class="form-control form-control-sm " />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Skype')}}</span>   
                      <input type="text" value="{{ old('skype') }}" name="skype" class="form-control form-control-sm "  />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Instagram')}}</span>   
                      <input type="text" value="{{ old('instagram') }}" name="instagram" class="form-control form-control-sm "  />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('YouTube')}}</span>   
                      <input type="text" value="{{ old('youtube') }}" name="youtube" class="form-control form-control-sm "  />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Tumblr')}}</span>   
                      <input type="text" value="{{ old('tumblr') }}" name="tumblr" class="form-control form-control-sm "  />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Snapchat')}}</span>   
                      <input type="text" value="{{ old('snapchat') }}" name="snapchat" class="form-control form-control-sm "  />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Reddit')}}</span>   
                      <input type="text" value="{{ old('reddit') }}" name="reddit" class="form-control form-control-sm "  />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Pinterest')}}</span>   
                      <input type="text" value="{{ old('pinterest') }}" name="pinterest" class="form-control form-control-sm " />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Telegram')}}</span>   
                      <input type="text" value="{{ old('telegram') }}" name="telegram" class="form-control form-control-sm " />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Vimeo')}}</span>   
                      <input type="text" value="{{ old('vimeo') }}" name="vimeo" class="form-control form-control-sm "  />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Patreon')}}</span>   
                      <input type="text" value="{{ old('patreon') }}" name="patreon" class="form-control form-control-sm " />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Flickr')}}</span>   
                      <input type="text" value="{{ old('flickr') }}" name="flickr" class="form-control form-control-sm " />
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Discord')}}</span>   
                      <input type="text" value="{{ old('discord') }}" name="discord" class="form-control form-control-sm " />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Tiktok')}}</span>   
                      <input type="text" value="{{ old('tiktok') }}" name="tiktok" class="form-control form-control-sm " />
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <span>{{__('Vine')}}</span>   
                      <input type="text" value="{{ old('vine') }}" name="vine" class="form-control form-control-sm " />
                    </div>
                  </div>
                </div>
              </div>
              </div>

            </div>
          </div>
        </div>
        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 com-sm-12 mt-3">
                        <button class="btn btn-primary btn-block ">
                            {{__('Save Contact')}}
                        </button>
                    </div>

                    <div class="col-md-6 com-sm-12 mt-3">
                      <input type="submit" value="{{__('Save and Send Email')}}" name="send_email" class="btn btn-primary btn-block ">
                  </div>
                </div>
            </div>
        </div>   
    </form>
  </div>
  </div>


{{-- All Modal Starts Here --}}
<div class="modal fade" id="addTitle" tabindex="-1" role="dialog" aria-labelledby="addTitleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTitleLabel">{{__('Add Title')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('/contact/title')}}" method="POST">
              @csrf
              <label for="">{{__('Enter a Unique Title')}} </label>
              <input type="hidden" name="return_to" value="contact">
              <input type="text" name="name" class="form-control form-control-sm"/>
              @if($errors)
                @foreach ($errors->all() as $error)
                    <div class="text text-danger">{{ $error }}</div>
                @endforeach
            @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
              <button type="submit" class="btn btn-info">{{__('Add')}}</button>
            </div>
          </form>
      </div>
    </div>
  </div>

{{-- Add Modal Ends Here --}}

{{-- ANCHOR TITLE MODAL starts Here --}}
<div class="modal fade" id="addTitleModal" tabindex="-1" role="dialog" aria-labelledby="addTitleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTitleLabel">{{__('Add Title')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="POST">
            <label for="">{{__('Enter a Unique Title')}} </label>
            <input type="hidden" name="return_to" value="lead">
            <input type="text" name="name" id="new_contact_title" class="form-control form-control-sm"/>
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
@include('crm.customer.create_js')
@endsection