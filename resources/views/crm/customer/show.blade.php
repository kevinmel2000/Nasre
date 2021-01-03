@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container-fluid">
    <div class="row">
      @include('crm.customer.common.contact_inner_sidebar')
      <div class="col-md-9">
        
          <form method="POST" action={{url('/customer', $customer)}}>
            @csrf
            @method('PUT')
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="pt-1 px-2">
                    <p class="card-title bg-default pl-2 pr-2">{{__('Customer Details')}}</p>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" id="contact-details" data-toggle="pill" href="#contact-details-id" role="tab" aria-controls="contact-details-id" aria-selected="true">{{__('Contact Card')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="address-details" data-toggle="pill" href="#address-details-id" role="tab" aria-controls="address-details-id" aria-selected="false">{{__('Address Card')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="social-media-details" data-toggle="pill" href="#social-media-details-id" role="tab" aria-controls="social-media-details-id" aria-selected="false">{{__('Social Media Card')}}</a>
                  </li>
                </ul>
              </div>
              
              <div class="card-body bg-light-blue">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="contact-details-id" role="tabpanel" aria-labelledby="contact-details">
                    
                  <div class="row">
                    {{-- Customer card starts here --}}
                    <div class="card">
                      <div class="card-header bg-gray">
                        <div class="card-title">{{__('Customer Information')}}</div>
                      </div>
                      <div class="card-body bg-light-gray">
                        <div class="row">
                          <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <span ><span class="text-danger">*</span> {{__('Username')}}
                                <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Client can use this username to login in his account. Default password is also the same username."></i>                    
                              </span>
                                <input type="text" name="username" class="form-control form-control-sm " placeholder="Enter a unique username" id="username" value="{{@$customer->username}}" data-validation="required|length|custom" data-validation-regexp="^([a-z0-9]*)$" data-validation-length="2-30" 
                                required />
                                <span class="text text-danger" id="username_error">
                                  {{@$errors->first('username')}}
                                </span>
                            </div>
                          </div>  
                          <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <span ><span class="text-danger"></span> {{__('Company Name')}}</span>
                                <input type="text" name="company_name" class="form-control form-control-sm " placeholder="Enter Contact's Name" value="{{@$customer->company_name}}"
                                />
                            </div>
                            <span class="text text-danger"></span>
                          </div>
                              
                          <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                  <span ><span class="text-danger"></span> {{__('Website')}}</span>
                                  <input type="text" name="website" class="form-control form-control-sm " placeholder="Enter Website" value="{{@$customer->website}}" />
                              </div>
                              <span class="text text-danger"></span>
                          </div>
        
                          <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                  <span ><span class="text-danger"></span> {{__('VAT Number')}}</span>
                                  <input type="text" name="vat_number" class="form-control form-control-sm " placeholder="Enter Contact's VAT Number" value="{{@$customer->vat_number}}"/>
                              </div>
                              <span class="text text-danger"></span>
                          </div>
        
                          <div class="col-md-6 col-sm-12">
                              <span ><span class="text-danger"></span> {{__('Customer Type')}}</span>
                              <div class="form-group">
                                  <select name="customer_type" id="type" class="form-control form-control-sm " >
                                      <option selected disabled>{{__('Select an option')}}</option>
                                      @foreach (config('constants.CONTACT_TYPES') as $item)
                                        @if ($item == $customer->customer_type)
                                          <option value="{{$item}}" selected>{{$item}}</option>
                                        @else
                                          <option value="{{$item}}">{{$item}}</option>
                                        @endif  
                                      @endforeach 
                                  </select>
                              </div>
                              <span class="text text-danger"></span>
                          </div>
        
                          <div class="col-md-6 col-sm-12">
                              <span ><span class="text-danger"></span>{{__(' Prospect Type')}}</span>
                              <div class="form-group">
                                  <select name="prospect_status" id="prospect_status" class="form-control form-control-sm">
                                    <option selected disabled>{{__('Select an option')}}</option>
                                      @foreach (config('constants.PROSPECTS') as $item)
                                        @if ($item == $customer->prospect_status)
                                          <option value="{{$item}}" selected>{{$item}}</option>
                                        @else
                                          <option value="{{$item}}">{{$item}}</option>
                                        @endif
                                      @endforeach 
                                  </select>
                              </div>
                              <span class="text text-danger"></span>
                          </div>

                          <div class="col-md-4 col-sm-12">  
                            <div class="form-group">
                              <span>Industry </span>
                              <select name="industry_id" id="industries" class="form-control form-control-sm">
                                <option selected disabled>{{__('Select an industry')}}</option>
                                @foreach ($industries as $industry)
                                  @if ($industry->id == $customer->industry_id)
                                    <option value="{{$industry->id}}" selected>{{$industry->name}}</option>
                                  @else
                                    <option value="{{$industry->id}}">{{$industry->name}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>    
                      </div>
                    </div>
                    {{-- Customer card ends --}}

                    {{-- SECTION: Primary contact card starts --}}
                    <div class="card">
                      <div class="card-header bg-gray">
                        <div class="card-title">{{__('Primary Contact')}}</div>
                      </div>
                      <div class="card-body bg-light-gray">
                        <div class="row">
                          <div class="col-md-4 col-sm-12">
                            <span><span class="text-danger">*</span> {{__('Title')}}</span>
                            <div class="input-group">
                                <select name="title_id" id="" class="form-control form-control-sm" required>
                                    <option selected disabled>{{__('Select a Title')}}</option>
                                    @foreach ($contact_titles as $title)
                                        @if ($title->id == $customer->first_contact->title_id)
                                          <option value="{{$title->id}}" selected>{{$title->name}}</option>
                                        @else
                                          <option value="{{$title->id}}">{{$title->name}}</option>
                                        @endif  
                                    @endforeach
                                </select>
                                <button type="button" class="btn  plus-button" data-toggle="modal" data-target="#addTitle">
                                    <span data-toggle="tooltip" data-placement="top" title="Add New Title"> + </span>
                                </button>
                            </div>
                            <span class="text text-danger">{{@$errors->first('title_id')}}</span>
                        </div>
      
                        <div class="col-md-4 col-sm-12">
                          <div class="form-group">
                              <span ><span class="text-danger"></span> {{__('First Name')}}</span>
                              <input type="text" name="first_name" class="form-control form-control-sm " placeholder="Enter Contact's First Name" value="{{@$customer->first_contact->first_name}}"
                              />
                          </div>
                          <span class="text text-danger">{{@$errors->first('first_name')}}</span>
                        </div>
    
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <span ><span class="text-danger">*</span> {{__('Last Name')}}</span>
                                <input type="text" name="last_name" class="form-control form-control-sm " placeholder="Enter Contact's Last Name" required value="{{@$customer->first_contact->last_name}}"
                                />
                            </div>
                            <span class="text text-danger">{{@$errors->first('last_name')}}</span>
                        </div>
    
    
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <span ><span class="text-danger"></span> {{__('Email')}}</span>
                                <input type="text" id="email" name="email" class="form-control form-control-sm " placeholder="Enter Contact's Email" value="{{@$customer->first_contact->email}}" />
                            
                            <span class="text text-danger" id="email_error">
                              {{@$errors->first('email')}}
                            </span>
                          </div>
                        </div>
      
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <span ><span class="text-danger"></span> {{__('Phone')}}</span>
                                <input type="text" name="phone" class="form-control form-control-sm " placeholder="Enter Contact's Phone" value="{{@$customer->first_contact->phone}}" />
                            </div>
                            <span class="text text-danger"></span>
                        </div>
                        <div class="col-md-4 col-sm-12">
                          <div class="form-group">
                              <span ><span class="text-danger"></span> {{__('WhatsApp')}} 
                              <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Format: CountryCode PhoneNumber, don't use + symbol (CCXXXXXXXXXX)"></i>
                              </span>
                              <input type="number" name="whatsapp" class="form-control form-control-sm " placeholder="Enter Whatsapp Number" value="{{@$customer->first_contact->whatsapp}}" />
                          </div>
                          <span class="text text-danger"></span>
                        </div>
      
    
      
                        <div class="col-md-4 col-sm-12">
                          <span ><span class="text-danger"></span> {{__('Customer Speaks')}}</span>
                          <div class="input-group">
                              <select name="language_id" id="languages" class="form-control form-control-sm">
                                  <option selected disabled>{{__('Select a language')}}</option>
                                  @foreach ($languages as $language)
                                      @if ($language->id == $customer->first_contact->language_id)
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
                              <span>{{__('Personal ID')}}</span>   
                              <input type="text" name="personal_id" class="form-control form-control-sm " placeholder="Enter any Personal Identity Number" value="{{@$customer->first_contact->personal_id}}" />
                          </div>
                        </div>
      
    
      
      

                        <div class="col-md-4 col-sm-12">
                          <span>{{__('Birth Date')}}</span>   
                          <div class="input-group">
                            <input type="date" name="birth_date" class="form-control form-control-sm" 
                            value="{{@$customer->first_contact->birth_date}}"
                            />
                          </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-12">  
                          
                          <div class="form-group">
                            <label class="mr-3"><span class="text-danger"></span> {{__('Decision Maker')}}</label>
                            <input type="radio" name="decision_maker" id="yes" class="mr-1" value="yes" 
                            @if (@$customer->first_contact->decision_maker == 'yes')
                                checked
                            @endif
                            />
                            <label for="yes" class="mr-3">{{__('Yes')}}</label>
                            <input type="radio" name="decision_maker" id="no" class="mr-1" value="no"
                            @if (@$customer->first_contact->decision_maker == 'no')
                                checked
                            @endif
                            />
                            <label for="no">{{__('No')}}</label>
                          </div>
                        </div> 
      
                        <div class="col-md-4 col-sm-12">  
                          <div class="form-group">
                            <label class="mr-3">{{__('Gender')}}</label>   
                            <input type="radio" name="gender" id="male" class="mr-1" value="male"  
                            @if (@$customer->first_contact->gender == 'male')
                                checked
                            @endif 
                            />
                            <label for="male" class="mr-3">{{__('Male')}}</label>
                            <input type="radio" name="gender" id="female" class="mr-1" value="female" 
                            @if (@$customer->first_contact->gender == 'female')
                                checked
                            @endif 
                            />
                            <label for="female" class="mr-3">{{__('Female')}}</label>
                            <input type="radio" name="gender" id="other" class="mr-1" value="other"
                            @if (@$customer->first_contact->gender == 'other')
                                checked
                            @endif 
                            />
                            <label for="other" class="mr-3">{{__('Other')}}</label>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-md-12">  
                      <div class="card">
                        <div class="card-body bg-light-gray">
                          <span>{{__('Notes')}}</span>
                          <div class="form-group">
                            <textarea class="form-control form-control-sm" rows="4" name="note">{{@$note->note}}</textarea>
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
                              <input type="text" name="address_line_1" class="form-control form-control-sm " placeholder="Address Line 1" value="{{@$address->address_line_1}}" />
                          </div>
                          <div class="form-group">
                              <span>{{__('Address Line 2')}}</span>   
                              <input type="text" name="address_line_2" class="form-control form-control-sm " placeholder="Address Line 2"  value="{{@$address->address_line_2}}"  />
                          </div>
              
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <span> {{__('Country Name')}}</span>   
                                      <select name="country_id" class="form-control form-control-sm" 
                                          id="countries"
                                      >
                                          <option selected disabled>{{__('Select an option')}}</option>
                                          @foreach ($countries as $country)
                                            @if ($country->id == @$address->country_id)
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
                              <span> {{__('Email 1 ')}}</span> 
                              <div class="input-group">
                                  <input type="email" name="email_1" class="form-control form-control-sm " placeholder="Enter Email 1" value="{{@$address->email_1}}" />
                              </div>
                          </div>
                          <div class="form-group">
                              <span> {{__('Email 2 ')}}</span> 
                              <div class="form-group">
                                  <input type="email" name="email_2" class="form-control form-control-sm " placeholder="Enter Email 2" value="{{@$address->email_2}}" />
                              </div>
                          </div>
                          <div class="form-group">
                              <input type="checkbox" name="is_shipping_address" class="mr-2" id="is_shipping_address" value="yes"
                              @if (@$address->is_shipping_address == 'yes')
                                  checked
                              @endif
                              />
                              <label for="is_shipping_address"> {{__('Shipping Address')}} </label> 
                              &nbsp; &nbsp; &nbsp; &nbsp;    
                              <input type="checkbox" name="is_billing_address" class="mr-2" id="is_billing_address" value="yes"
                              @if (@$address->is_billing_address == 'yes')
                                  checked
                              @endif
                              />
                              <label for="is_billing_address" > {{__('Billing Address')}} </label> 
                          </div>
                      </div>
                  </div>
                </div>
             
                  <div class="tab-pane fade" id="social-media-details-id" role="tabpanel" aria-labelledby="social-media-details">
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Linkedin')}}</span>   
                          <input type="text" name="linkedin" class="form-control form-control-sm " placeholder="Linkedin"
                          value="{{@$SocialMediaField->linkedin}}"
                          />
                        </div>
                      </div>
  
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Facebook')}}</span>   
                          <input type="text" name="facebook" class="form-control form-control-sm " placeholder="facebook"
                          value="{{@$SocialMediaField->facebook}}"
                          />
                        </div>
                      </div>
  
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Twitter')}}</span>   
                          <input type="text" name="twitter" class="form-control form-control-sm " placeholder="twitter" 
                          value="{{@$SocialMediaField->twitter}}"
                          />
                        </div>
                      </div>
  
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Skype')}}</span>   
                          <input type="text" name="skype" class="form-control form-control-sm " placeholder="skype"
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
                          <input type="text" name="youtube" class="form-control form-control-sm " placeholder="youtube"
                          value="{{@$SocialMediaField->youtube}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Tumblr')}}</span>   
                          <input type="text" name="tumblr" class="form-control form-control-sm " placeholder="tumblr" 
                          value="{{@$SocialMediaField->tumblr}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Snapchat')}}</span>   
                          <input type="text" name="snapchat" class="form-control form-control-sm " placeholder="snapchat" 
                          value="{{@$SocialMediaField->snapchat}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Reddit')}}</span>   
                          <input type="text" name="reddit" class="form-control form-control-sm " placeholder="reddit" 
                          value="{{@$SocialMediaField->reddit}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Pinterest')}}</span>   
                          <input type="text" name="pinterest" class="form-control form-control-sm " placeholder="pinterest" 
                          value="{{@$SocialMediaField->pinterest}}"
                          />
                        </div>
                      </div>
  
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Telegram')}}</span>   
                          <input type="text" name="telegram" class="form-control form-control-sm " placeholder="telegram" 
                          value="{{@$SocialMediaField->telegram}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Vimeo')}}</span>   
                          <input type="text" name="vimeo" class="form-control form-control-sm " placeholder="vimeo" 
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
                          <input type="text" name="flickr" class="form-control form-control-sm " placeholder="flickr" 
                          value="{{@$SocialMediaField->flickr}}"
                          />
                        </div>
                      </div>
  
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Discord')}}</span>   
                          <input type="text" name="discord" class="form-control form-control-sm " placeholder="discord" 
                          value="{{@$SocialMediaField->discord}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Tiktok')}}</span>   
                          <input type="text" name="tiktok" class="form-control form-control-sm " placeholder="tiktok" 
                          value="{{@$SocialMediaField->tiktok}}"
                          />
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <span>{{__('Vine')}}</span>   
                          <input type="text" name="vine" class="form-control form-control-sm " placeholder="vine"
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
                                {{__('Update Contact')}}
                            </button>
                        </div>
                        
                    </div>
                </div>
            </div>   
          </form>

          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">{{__('Manage Contacts')}}</h3>
              <button type="button" class="btn btn-sm btn-primary float-right" href="#" data-toggle="modal" data-target="#addNewContact">{{__('New Contact')}} </button>
            </div>
            <div class="card-body">
              <div class="table-resposive">
              <table  class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>{{__('Primary')}}</th>
                  <th>{{__('Name')}}</th>
                  <th>{{__('Contact')}}</th>
                  <th>{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $contact_ids = response()->json(@$customer->contacts->modelKeys());
                    @endphp
                    @foreach (@$customer->contacts as $contact)
                        <tr>
                          <td>
                            <form action="{{url('customer/contact/makeContactPrimary', $contact)}}" method="post">
                              @csrf
                              @method('PUT')
                            <label class="cl-switch cl-switch-green">
                              <input type="checkbox" name="is_primary" id="is_primary" value="yes" 
                              class="submit"
                              @if ($contact->is_primary == 'yes')
                                checked
                              @endif
                              >
                              <span class="switcher"></span>
                              </label>
                            </form>
                          </td>
{{-- Edit Contact Modal Starts Here --}}
<div class="modal fade" id="editContactModal{{$contact->id}}" tabindex="-1" role="dialog" aria-labelledby="editContactModal{{$contact->id}}Label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content  bg-light-gray">
          <div class="modal-header bg-gray">
              <h5 class="modal-title" id="editContactModal{{$contact->id}}Label">{{__('Update Contact')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="{{url('/customer/contact', $contact)}}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="customer_id" value="{{@$customer->id}}">
          <div class="modal-body">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4 col-sm-12">
                  <span><span class="text-danger">*</span> {{__('Title')}}</span>
                  <div class="input-group">
                      <select name="title_id" id="" class="form-control form-control-sm" required>
                          <option selected disabled>{{__('Select a Title')}}</option>
                          @foreach ($contact_titles as $title)
                              @if ($title->id == $contact->title_id)
                                <option value="{{$title->id}}" selected>{{$title->name}}</option>
                              @else
                                <option value="{{$title->id}}">{{$title->name}}</option>
                              @endif  
                          @endforeach
                      </select>
                      <span class="input-group-append">
                        <button type="button" class="btn  plus-button" data-toggle="modal" data-target="#addTitle">
                            <span data-toggle="tooltip" data-placement="top" title="Add New Title"> + </span>
                        </button>
                      </span>
                  </div>
                  <span class="text text-danger">{{@$errors->first('title_id')}}</span>
              </div>

              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <span ><span class="text-danger"></span> {{__('First Name')}}</span>
                    <input type="text" name="first_name" class="form-control form-control-sm " placeholder="Enter Contact's First Name" value="{{@$contact->first_name}}"/>
                </div>
                <span class="text text-danger">{{@$errors->first('first_name')}}</span>
              </div>

              <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <span ><span class="text-danger">*</span> {{__('Last Name')}}</span>
                      <input type="text" name="last_name" class="form-control form-control-sm " placeholder="Enter Contact's Last Name" required value="{{@$contact->last_name}}"/>
                  </div>
                  <span class="text text-danger">{{@$errors->first('last_name')}}</span>
              </div>

              <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <span ><span class="text-danger"></span> {{__('Email')}}</span>
                      <input type="text" 
                        name="email" 
                        onchange="check_email({{@$contact->id}})" 
                        id="email{{@$contact->id}}" 
                        class="form-control form-control-sm " 
                        placeholder="Enter Contact's Email" 
                        value="{{@$contact->email}}" />
                 
                  <span class="text text-danger" id="email_error{{@$contact->id}}">
                    {{@$errors->first('email')}}
                  </span>
                </div>
              </div>

              <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <span ><span class="text-danger"></span> {{__('Phone')}}</span>
                      <input type="text" name="phone" class="form-control form-control-sm " placeholder="Enter Contact's Phone" value="{{@$contact->phone}}" />
                  </div>
                  <span class="text text-danger"></span>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <span ><span class="text-danger"></span> {{__('WhatsApp')}} 
                    <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Format: CountryCode PhoneNumber, don't use + symbol (CCXXXXXXXXXX)"></i>
                    </span>
                    <input type="number" name="whatsapp" class="form-control form-control-sm " placeholder="Enter Whatsapp Number" value="{{@$contact->whatsapp}}" />
                </div>
                <span class="text text-danger"></span>
              </div>

              <div class="col-md-4 col-sm-12">
                <span ><span class="text-danger"></span> {{__('Customer Speaks')}}</span>
                <div class="input-group">
                    <select name="language_id" id="languages2" class="form-control form-control-sm">
                        <option selected disabled>{{__('Select a language')}}</option>
                        @foreach ($languages as $language)
                          @if ($contact->language_id == $language->id)
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
                    <span>{{__('Personal ID')}}</span>   
                    <input type="text" name="personal_id" class="form-control form-control-sm " placeholder="Enter any Personal Identity Number" value="{{@$contact->personal_id}}"/>
                </div>
              </div>

              <div class="col-md-4 col-sm-12">
                <span>{{__('Birth Date')}}</span>   
                <div class="input-group">
                  <input type="date" name="birth_date" class="form-control form-control-sm" value="{{@$contact->birth_date}}"
                  />
                </div>
              </div>
              
              <div class="col-md-4 col-sm-12">  
                <div class="form-group">
                  <label class="mr-3"><span class="text-danger"></span> {{__('Decision Maker')}}</label>
                  <input type="radio" name="decision_maker" id="yes" class="mr-1" value="yes" 
                  @if (@$contact->decision_maker == 'yes')
                      checked
                  @endif
                  />
                  <label for="yes" class="mr-3">{{__('Yes')}}</label>
                  <input type="radio" name="decision_maker" id="no" class="mr-1" value="no" 
                  @if (@$contact->decision_maker == 'no')
                    checked
                  @endif
                  />
                  <label for="no">{{__('No')}}</label>
                </div>
              </div> 

              <div class="col-md-6 col-sm-12">  
                <div class="form-group">
                  <label class="mr-3">{{__('Gender')}}</label>   
                  <input type="radio" name="gender" id="male" class="mr-1" value="male" 
                  @if (@$contact->gender == 'male')
                    checked
                  @endif
                   />
                  <label for="male" class="mr-3">{{__('Male')}}</label>
                  <input type="radio" name="gender" id="female" class="mr-1" value="female" 
                  @if (@$contact->gender == 'female')
                    checked
                  @endif
                  />
                  <label for="female" class="mr-3">{{__('Female')}}</label>
                  <input type="radio" name="gender" id="other" class="mr-1" value="other"  
                  @if (@$contact->gender == 'other')
                    checked
                  @endif
                  />
                  <label for="other" class="mr-3">{{__('Other')}}</label>
                </div>
              </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
              <button type="submit" class="btn btn-info">{{__('Update Contact')}}</button>
          </div>
          </form>
      </div>
  </div>
</div>
{{-- Edit Contact Modal Ends Here --}}

                            <td>
                              @can('update-contact', User::class)
                              <a href="#" data-toggle="modal" data-target="#editContactModal{{$contact->id}}">
                                {{@$contact->first_name}} {{@$contact->last_name}}
                              </a>
                              @endcan
                            </td>
                            <td>
                              <a href="tel:{{@$contact->phone}}">{{@$contact->phone}}
                                <span class="font20">
                                  <i class="fas fa-phone-square-alt"></i>
                                </span>
                              </a>
                            
                              <a href="https://wa.me/{{@$contact->whatsapp}}" target="_blank" class="mr-1">
                                <span class="font20">
                                  <i class="fab fa-whatsapp-square text-success"></i>
                                </span>
                              </a>
                              <a href="mailto:{{@$contact->email}}">
                                <span class="font20">
                                  <i class="fas fa-envelope-square text-secondary"></i>
                                </span>
                              </a>
                            </td>

                            <td>
                              <a href="#" data-toggle="tooltip" data-title="{{$contact->created_at->toDayDateTimeString()}}" class="mr-1">
                                <i class="fas fa-clock text-info"></i>
                              </a>
                              <a href="#" data-toggle="tooltip" data-title="{{$contact->updated_at->toDayDateTimeString()}}" class="mr-2">
                                <i class="fas fa-history text-primary"></i>
                              </a>
                              <span>
                                @can('update-contact', User::class)
                                  <a class="text-primary mr-2" href="#" data-toggle="modal" data-target="#editContactModal{{$contact->id}}">
                                    <i class="fas fa-edit"></i>
                                  </a>
                                @endcan

                                @can('delete-contact', User::class)
                                  <span id="delbtn{{@$contact->id}}"></span>
                                  <form id="delete-contact-{{$contact->id}}"
                                      action="{{ url('customer/contact/destroy', $contact->id) }}"
                                      method="POST">
                                      @method('DELETE')
                                      @csrf
                                  </form>
                                @endcan  
                              </span>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                  <th>{{__('Primary')}}</th>
                  <th>{{__('Name')}}</th>
                  <th>{{__('Contact')}}</th>
                  <th>{{__('Actions')}}</th>
                </tfoot>
              </table>
            </div>
          </div>
            <!-- /.card-body -->
          </div>

        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>

{{-- All Modal Starts Here --}}
<div class="modal fade" id="addNewContact" tabindex="-1" role="dialog" aria-labelledby="addNewContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addNewContactLabel">{{__('Add Contact')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="{{url('/customer/contact')}}" method="POST">
          @csrf
          <input type="hidden" name="customer_id" value="{{@$customer->id}}">
          <div class="modal-body">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4 col-sm-12">
                  <span><span class="text-danger">*</span> {{__('Title')}}</span>
                  <div class="input-group">
                      <select name="title_id" id="" class="form-control form-control-sm" required>
                          <option selected disabled>{{__('Select a Title')}}</option>
                          @foreach ($contact_titles as $title)
                              @if ($title->id == $customer->first_contact->title_id)
                                <option value="{{$title->id}}" selected>{{$title->name}}</option>
                              @else
                                <option value="{{$title->id}}">{{$title->name}}</option>
                              @endif  
                          @endforeach
                      </select>
                      <button type="button" class="btn  plus-button" data-toggle="modal" data-target="#addTitle">
                          <span data-toggle="tooltip" data-placement="top" title="Add New Title"> + </span>
                      </button>
                  </div>
                  <span class="text text-danger">{{@$errors->first('title_id')}}</span>
              </div>

              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <span ><span class="text-danger"></span> {{__('First Name')}}</span>
                    <input type="text" name="first_name" class="form-control form-control-sm " placeholder="Enter Contact's First Name"/>
                </div>
                <span class="text text-danger">{{@$errors->first('first_name')}}</span>
              </div>

              <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <span ><span class="text-danger">*</span> {{__('Last Name')}}</span>
                      <input type="text" name="last_name" class="form-control form-control-sm " placeholder="Enter Contact's Last Name" required />
                  </div>
                  <span class="text text-danger">{{@$errors->first('last_name')}}</span>
              </div>

              <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <span ><span class="text-danger"></span> {{__('Email')}}</span>
                      <input type="text" name="email" class="form-control form-control-sm " placeholder="Enter Contact's Email" />
                  </div>
                  <span class="text text-danger"></span>
              </div>

              <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <span ><span class="text-danger"></span> {{__('Phone')}}</span>
                      <input type="text" name="phone" class="form-control form-control-sm " placeholder="Enter Contact's Phone" />
                  </div>
                  <span class="text text-danger"></span>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <span ><span class="text-danger"></span> {{__('WhatsApp')}} 
                    <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Format: CountryCode PhoneNumber, don't use + symbol (CCXXXXXXXXXX)"></i>
                    </span>
                    <input type="number" name="whatsapp" class="form-control form-control-sm " placeholder="Enter Whatsapp Number" />
                </div>
                <span class="text text-danger"></span>
              </div>

              <div class="col-md-4 col-sm-12">
                <span ><span class="text-danger"></span> {{__('Customer Speaks')}}</span>
                <div class="input-group">
                    <select name="language_id" id="languages2" class="form-control form-control-sm">
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
                    <span>{{__('Personal ID')}}</span>   
                    <input type="text" name="personal_id" class="form-control form-control-sm " placeholder="Enter any Personal Identity Number" />
                </div>
              </div>

              <div class="col-md-4 col-sm-12">
                <span>{{__('Birth Date')}}</span>   
                <div class="input-group">
                  <input type="date" name="birth_date" class="form-control form-control-sm" 
                  />
                </div>
              </div>
              
              <div class="col-md-4 col-sm-12">  
                <div class="form-group">
                  <label class="mr-3"><span class="text-danger"></span> {{__('Decision Maker')}}</label>
                  <input type="radio" name="decision_maker" id="yes" class="mr-1" value="yes" />
                  <label for="yes" class="mr-3">{{__('Yes')}}</label>
                  <input type="radio" name="decision_maker" id="no" class="mr-1" value="no" checked/>
                  <label for="no">{{__('No')}}</label>
                </div>
              </div> 

              <div class="col-md-6 col-sm-12">  
                <div class="form-group">
                  <label class="mr-3">{{__('Gender')}}</label>   
                  <input type="radio" name="gender" id="male" class="mr-1" value="male" checked />
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
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
              <button type="submit" class="btn btn-info">{{__('Add Contact')}}</button>
          </div>
          </form>
      </div>
  </div>
</div>
{{-- Add Modal Ends Here --}}



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
                    <input type="text" name="name" class="form-control form-control-sm" />
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
@endsection


@section('scripts')
@include('crm.customer.show_js')
@endsection