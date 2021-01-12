@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('transaction-data/marine-lookup/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Ship Detail Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{__('Ship Code')}} </label>
                                    <input type="text" name="shipcode" class="form-control form-control-sm" data-validation="length" data-validation-length="1-7" disabled required/>
                                </div>
                            </div>
                            <div class="col-md-8">
                            <div class="form-group">
                                <label for="">{{__('Ship Name')}} </label>
                                <input type="text" name="shipname" placeholder="enter ship name" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="">{{__('Owner')}}</label>
                                <input type="text" name="owner" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header bg-gray">
                                        {{__('The Tornanger of the ship')}}
                                    </div>
                                    <div class="card-body bg-light-gray ">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('GRT')}}</label>
                                                    <input type="text" name="grt" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('NRT')}}</label>
                                                    <input type="text" name="nrt" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('DWT')}}</label>
                                                    <input type="text" name="dwt" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('Power')}}</label>
                                                    <input type="text" name="power" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">{{__('Ship Year')}}</label>
                                            <input type="text" name="shipyear" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">{{__('Repair Year')}}</label>
                                            <input type="text" name="repairyear" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">{{__('Golongan')}}</label>
                                            <input type="text" name="golongan" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Country')}}</label>
                                  <select name="continent" class="form-control form-control-sm ">
                                      <option selected disabled>{{__('Select Country')}}</option>
                                      <option value="AF">Africa</option>
                                      <option value="AN">Antartica</option>
                                      <option value="AS">Asia</option>
                                      <option value="EU">Europa</option>
                                      <option value="NA">North America </option>
                                      <option value="OC">Oceania</option>
                                      <option value="SA">South America</option>
                                  </select>
                              </div>    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Ship Type')}}</label>
                                  <select name="continent" class="form-control form-control-sm ">
                                      <option selected disabled>{{__('Select Ship Type')}}</option>
                                      <option value="AF">Africa</option>
                                      <option value="AN">Antartica</option>
                                      <option value="AS">Asia</option>
                                      <option value="EU">Europa</option>
                                      <option value="NA">North America </option>
                                      <option value="OC">Oceania</option>
                                      <option value="SA">South America</option>
                                  </select>
                              </div>    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Classification')}}</label>
                                  <select name="continent" class="form-control form-control-sm ">
                                      <option selected disabled>{{__('Select Classification')}}</option>
                                      <option value="AF">Africa</option>
                                      <option value="AN">Antartica</option>
                                      <option value="AS">Asia</option>
                                      <option value="EU">Europa</option>
                                      <option value="NA">North America </option>
                                      <option value="OC">Oceania</option>
                                      <option value="SA">South America</option>
                                  </select>
                              </div>    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">{{__('Construction')}}</label>
                                  <select name="continent" class="form-control form-control-sm ">
                                      <option selected disabled>{{__('Select Construction')}}</option>
                                      <option value="AF">Africa</option>
                                      <option value="AN">Antartica</option>
                                      <option value="AS">Asia</option>
                                      <option value="EU">Europa</option>
                                      <option value="NA">North America </option>
                                      <option value="OC">Oceania</option>
                                      <option value="SA">South America</option>
                                  </select>
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
                    <div class="col-md-12 com-sm-12 mt-3">
                        <button class="btn btn-primary btn-block ">
                            {{__('Create New')}}
                        </button>
                    </div>
                   
                </div>
            </div>
        </div> 
        
        
    </form>

    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 com-sm-12 mt-3">
                  <table id="countryTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Code')}}</th>
                      <th>{{__('Ship Name')}}</th>
                      <th>{{__('Owner')}}</th>
                      <th>{{__('Continent')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        <td>{{__('Code')}}</td>
                        <td>{{__('Ship Name')}}</td>
                        <td>{{__('Owner')}}</td>
                        <td>{{__('Continent')}}</td>
                        <td width="20%">{{__('Actions')}}</td>
                    </tbody>
                    
                  </table>
                </div>
               
            </div>
        </div>
    </div> 

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.transaction.marine_lookup_js')
@endsection