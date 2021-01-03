@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  
  <div class="content-wrapper">
    <!-- Main content -->
      <div class="container-fluid">
        <div class="row">

          @include('crm.lead.common.lead_inner_sidebar')
          
          <div class="col-md-9">
            <form method="POST" action={{url('/lead', $lead)}}>
              @csrf
              @method('PUT')
            <div class="card card-default card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="pt-1 px-2">
                    <p class="card-title bg-primary pl-2 pr-2">{{__('Lead')}}</p>
                  </li>

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
                          <select name="lead_source_id" id="lead_source_id" class="form-control form-control-sm" required>
                              <option selected disabled>{{__('Select Lead Source')}}</option>
                          </select>
                          <div class="input-group-append">
                            <button type="button" class="btn plus-button" data-toggle="modal" data-target="#addSourceModal">
                              <span data-toggle="tooltip" data-placement="top" title="Add New Source"> + </span>
                          </button>
                      </div>
                      </div>
                      <span class="text text-danger">{{@$errors->first('lead_source_id')}}</span>
                    </div>
    
                    <div class="col-md-4 col-sm-12">
                      <span><span class="text-danger">*</span> {{__('Status')}}</span>
                      <div class="input-group">
                          <select name="lead_status_id" id="lead_status_id" class="form-control form-control-sm" required>
                              <option selected disabled>{{__('Select Lead Status')}}</option>
                          </select>
                          <div class="input-group-append">
                            <button type="button" class="btn plus-button" data-toggle="modal" data-target="#addStatusModal">
                              <span data-toggle="tooltip" data-placement="top" title="Add New Status"> + </span>
                          </button>
                      </div>
                      </div>
                      <span class="text text-danger">{{@$errors->first('lead_status_id')}}</span>
                    </div>
    
                    <div class="col-md-4 col-sm-12">
                      <span ><span class="text-danger"></span> {{__('Assigned')}}</span>
                      
                      <div class="input-group">
                          <select name="owner_id" id="owner_id" class="form-control form-control-sm" data-validation="required">
                              @foreach ($users as $user)
                                @if ($user->id  == @$lead->leadOwner->id)
                                  <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                @else
                                  <option value="{{$user->id}}">{{$user->name}}</option>
                                @endif
                              @endforeach
                          </select>
                      </div>
                      <span class="text text-danger"></span>
                    </div>
    
                  </div>
                  
    
                  
                  <div class="row mt-3">
                    <div class="col-md-4 col-sm-12">
                      @php
                          $tempratures = [
                            __('Hot'),
                            __('Warm'),
                            __('Cold')
                          ];
                      @endphp  
                      <div class="form-group">
                        <span>{{__('Lead Temprature')}}</span>  
                        <select name="lead_temprature" class="form-control form-control-sm">
                          @foreach ($tempratures as $temp)
                              @if (@$lead->lead_temprature == $temp)
                                <option value="{{$temp}}" selected>{{$temp}}</option>
                              @else
                                <option value="{{$temp}}">{{$temp}}</option>
                              @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
    
                    <div class="col-md-4 col-sm-12">  
                      @php
                          $score = ['1','2','3','4','5','6','7','8','9','10'];
                      @endphp 
                      <div class="form-group">
                        <span>{{__('Lead Score/Rating')}}</span>  
                        <select name="score" class="form-control form-control-sm">
                          @foreach ($score as $item)
                              @if ($item == @$lead->score)
                                <option value="{{$item}}" selected>{{$item}}</option>
                              @else
                                <option value="{{$item}}">{{$item}}</option>
                              @endif
                          @endforeach
                        </select>
                      </div>
                    </div>  
    
                    <div class="col-md-4 col-sm-12">
                      <span ><span class="text-danger"></span> {{__('Prospect Status')}}</span>
                      <div class="form-group">
                          <select name="prospect_status" id="prospect_status" class="form-control form-control-sm">
                              @foreach (config('constants.PROSPECTS') as $item)
                                  @if (@$lead->prospect_status == $item)
                                    <option value="{{$item}}" selected>{{$item}}</option>
                                  @else
                                    <option value="{{$item}}">{{$item}}</option>
                                  @endif
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
                          <select name="title_id" id="page_title_id{{@$lead->id}}" class="form-control form-control-sm" required>
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
    
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <span ><span class="text-danger"></span> {{__('First Name')}}</span>
                            <input type="text" name="first_name" class="form-control form-control-sm" value="{{@$lead->first_name}}"   
                            />
                        </div>
                        <span class="text text-danger"></span>
                    </div>
    
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                          <span ><span class="text-danger">*</span> {{__('Last Name')}}</span>
                          <input type="text" name="last_name" class="form-control form-control-sm " value="{{@$lead->last_name}}" data-validation="length" data-validation-length="2-20" required 
                          />
                      </div>
                      <span class="text text-danger">{{@$errors->first('last_name')}}</span>
                    </div>
  

                    <div class="col-md-12 col-sm-12">
                      <div class="form-group">
                          <span ><span class="text-danger"></span> {{__('Company Name')}}</span>
                          <input type="text" name="company_name" class="form-control form-control-sm "  value="{{@$lead->company_name}}"
                          />
                      </div>
                      <span class="text text-danger"></span>
                    </div>
                  </div>
    
                  <div class="row mt-2">
    
                    <div class="col-md-4 col-sm-12">
                      <span ><span class="text-danger"></span>  {{__('Email')}}
                        <span class="float-right">
                          <input type="checkbox" name="email_opt_out" value="yes"
                          @if (@$lead->email_opt_out == 'yes')
                              checked
                          @endif
                          />
                          <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Click checkbox to email Opt-out for notifications')}}"></i>
                        </span>
                      </span>
                
                        <div class="input-group">
                            <input type="text" name="email" class="form-control form-control-sm "  value="{{@$lead->email}}" />
                            <span class="text text-danger"></span>
                        </div>
                    </div>
    
                    <div class="col-md-4 col-sm-12">
                      <span ><span class="text-danger"></span>  {{__('Phone')}}
                      
                        <span class="float-right">
                          <input type="checkbox" name="phone_opt_out" value="yes"
                          @if (@$lead->phone_opt_out == 'yes')
                              checked
                          @endif
                          >
                          <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Click checkbox to phone Opt-out for notifications')}}"></i>
                        </span>
                      </span>
                
                        <div class="input-group">
                            <input type="text" name="phone" class="form-control form-control-sm "  value="{{@$lead->phone}}" />
                            <span class="text text-danger"></span>
                        </div>
                    </div>
    
    
                    <div class="col-md-4 col-sm-12">
                      <span ><span class="text-danger"></span> {{__('Fax')}}
                        <span class="float-right">
                          <input type="checkbox" name="fax_opt_out" value="yes"
                          @if (@$lead->fax_opt_out == 'yes')
                              checked
                          @endif
                          >
                          <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Click checkbox to fax Opt-out for notifications')}}"></i>
                        </span>
                      </span>
                
                        <div class="input-group">
                            <input type="text" name="fax" class="form-control form-control-sm"
                            value="{{@$lead->fax}}"
                            />
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
                          <input type="number" name="whatsapp" class="form-control form-control-sm" value="{{@$lead->whatsapp}}"/>
                      </div>
                      <span class="text text-danger"></span>
                    </div>
    
    
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <span ><span class="text-danger"></span> {{__('Website')}}</span>
                            <input type="text" name="website" class="form-control form-control-sm " 
                            value="{{@$lead->website}}"  
                            />
                        </div>
                        <span class="text text-danger"></span>
                    </div>
    
                    <div class="col-md-4 col-sm-12">
                      <span ><span class="text-danger"></span> {{__('Speaks')}}</span>
                      <div class="input-group">
                          <select name="language_id" id="languages_id" class="form-control form-control-sm">
                              <option selected disabled>{{__('Select a language')}}</option>
                              @foreach ($languages as $language)
                                @if ($lead->language_id == $language->id)
                                  <option value="{{$language->id}}" selected>{{$language->name}}</option>
                                @else
                                  <option value="{{$language->id}}">{{$language->name}}</option>
                                @endif  
                              @endforeach
                          </select>
                      </div>
                      <span class="text text-danger"></span>
                    </div>
    
                    <div class="col-md-4 col-sm-12">  
                      <div class="form-group">
                        <span>{{__('Industry')}}</span>  
                        <select name="industry_id" id="industries" class="form-control form-control-sm">
                          <option selected disabled>{{__('Select an Industry')}}</option>
                          @foreach ($industries as $industry)
                            @if ($lead->industry_id == $industry->id)
                              <option value="{{$industry->id}}" selected>{{$industry->name}}</option>
                            @else
                              <option value="{{$industry->id}}">{{$industry->name}}</option>
                            @endif
                              
                          @endforeach
                        </select>
                      </div>
                    </div>
    
                 
    
                    <div class="col-md-8 col-sm-12">  
                      <span>{{__('Notes')}}</span>
                      <div class="input-group">
                        <textarea class="form-control form-control-sm" name="note">{{@$lead->note->first()->note}}</textarea>
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
                              <input type="text" name="address_line_1" class="form-control form-control-sm "  value="{{@$address->address_line_1}}" />
                          </div>
                          <div class="form-group">
                              <span>{{__('Address Line 2')}}</span>   
                              <input type="text" name="address_line_2" class="form-control form-control-sm "   value="{{@$address->address_line_2}}"  />
                          </div>
              
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <span> {{__('Country Name')}}</span>   
                                      <select name="country_id" class="form-control form-control-sm" 
                                          id="countries" >
                                          <option selected disabled>Select an option</option>
                                          @foreach ($countries as $country)
                                            @if ($country->id == $address->country_id)
                                              <option value="{{$country->id}}" selected>{{$country->name}}</option>
                                            @else
                                              <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endif
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <span> {{__('State Name')}}</span>   
                                      <select name="state_id" class="form-control form-control-sm" id="states">
                                        @foreach ($states as $state)
                                            @if ($state->id == $address->state_id)
                                              <option value="{{$state->id}}" selected>{{$state->name}}</option>
                                            @else
                                              <option value="{{$state->id}}">{{$state->name}}</option>
                                            @endif
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <span> {{__('City Name')}}</span> 
                                      <select name="city_id" class="form-control form-control-sm" id="cities">
                                          @foreach ($cities as $city)
                                            @if ($city->id == $address->city_id)
                                              <option value="{{$city->id}}" selected>{{$city->name}}</option>
                                            @else
                                              <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endif
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <span> {{__('Zip')}}</span> 
                                      <input type="text" name="zip" class="form-control form-control-sm  " placeholder="Enter Zip" value="{{@$address->zip}}" />
                                  </div>
                              </div>
                          </div>
              
                      </div>
                      <div class="col-md-5 col-sm-12">
                          <div class="form-group">
                              <span> {{__('Phone 1')}} </span> 
                              <div class="input-group">
                                  <input type="tel" name="phone_1" class="form-control form-control-sm " placeholder="Enter Phone 1" value="{{@$address->phone_1}}"/>
                              </div>
                          </div>
                          <div class="form-group">
                              <span> {{__('Phone 2')}} </span> 
                              <div class="input-group">
                                  <input type="tel" name="phone_2" class="form-control form-control-sm " placeholder="Enter Phone 2" value="{{@$address->phone_2}}"/>
                              </div>
                          </div>
                          <div class="form-group">
                              <span> {{__('Email 1')}} </span> 
                              <div class="input-group">
                                  <input type="email" name="email_1" class="form-control form-control-sm " placeholder="Enter Email 1" value="{{@$address->email_1}}" />
                              </div>
                          </div>
                          <div class="form-group">
                              <span> {{__('Email 2')}} </span> 
                              <div class="form-group">
                                  <input type="email" name="email_2" class="form-control form-control-sm " placeholder="Enter Email 2" value="{{@$address->email_2}}" />
                              </div>
                          </div>
                          <div class="form-group">
                              <input type="checkbox" name="is_shipping_address" class="mr-2" id="is_shipping_address" value="yes"
                              @if ($address->is_shipping_address == 'yes')
                                  checked
                              @endif
                              />
                              <label for="is_shipping_address"> {{__('Shipping Address')}} </label> 
                               &nbsp; &nbsp; &nbsp; &nbsp;    
                              <input type="checkbox" name="is_billing_address" class="mr-2" id="is_billing_address" value="yes"
                              @if ($address->is_billing_address == 'yes')
                                  checked
                              @endif
                              />
                              <label for="is_billing_address"> {{__('Billing Address')}} </label> 
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
                          <span>{{__('Linkedin')}}</span>   
                          <input type="text" name="linkedin" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->linkedin}}"
                          />
                        </div>
                      </div>
    
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Facebook')}}</span>   
                          <input type="text" name="facebook" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->facebook}}"
                          />
                        </div>
                      </div>
    
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Twitter')}}</span>   
                          <input type="text" name="twitter" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->twitter}}"
                          />
                        </div>
                      </div>
    
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Skype')}}</span>   
                          <input type="text" name="skype" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->skype}}"
                          />
                        </div>
                      </div>
    
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Instagram')}}</span>   
                          <input type="text" name="instagram" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->instagram}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('YouTube')}}</span>   
                          <input type="text" name="youtube" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->youtube}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Tumblr')}}</span>   
                          <input type="text" name="tumblr" class="form-control form-control-sm "
                          value="{{@$SocialMediaField->tumblr}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Snapchat')}}</span>   
                          <input type="text" name="snapchat" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->snapchat}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Reddit')}}</span>   
                          <input type="text" name="reddit" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->reddit}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Pinterest')}}</span>   
                          <input type="text" name="pinterest" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->pinterest}}"
                          />
                        </div>
                      </div>
    
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Telegram')}}</span>   
                          <input type="text" name="telegram" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->telegram}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Vimeo')}}</span>   
                          <input type="text" name="vimeo" class="form-control form-control-sm "
                          value="{{@$SocialMediaField->vimeo}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Patreon')}}</span>   
                          <input type="text" name="patreon" class="form-control form-control-sm " placeholder="patreon" 
                          value="{{@$SocialMediaField->patreon}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Flickr')}}</span>   
                          <input type="text" name="flickr" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->flickr}}"
                          />
                        </div>
                      </div>
    
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Discord')}}</span>   
                          <input type="text" name="discord" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->discord}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Tiktok')}}</span>   
                          <input type="text" name="tiktok" class="form-control form-control-sm " 
                          value="{{@$SocialMediaField->tiktok}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Vine')}}</span>   
                          <input type="text" name="vine" class="form-control form-control-sm "
                          value="{{@$SocialMediaField->vine}}"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- SOCIAL MEDIA CARD ENDS --}}
                  </div>
    
                </div>
              </div>
              <div class="card card-primary">
                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-12 com-sm-12 mt-3">
                              <button class="btn btn-primary btn-block ">
                                  {{__('Update Lead')}}
                              </button>
                          </div>
                           
                      </div>
                  </div>
              </div>   
            </div>
        </form>
          </div>
        </div>
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
            {{-- @csrf --}}
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
              {{-- @csrf --}}
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
  @include('crm.lead.show_js')
  @yield('inner_script')
@endsection