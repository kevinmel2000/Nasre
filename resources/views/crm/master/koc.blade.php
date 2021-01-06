@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/country/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Country Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" name="countrycode" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Country Name')}}</label>
                          <input type="text" name="countryname" class="form-control form-control-sm " data-validation="length" data-validation-length="2-50" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Continent')}}</label>
                          <select name="continent" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select Continent')}}</option>
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
                            {{__('Save Country')}}
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
                      <th>{{__('ID')}}</th>
                      <th>{{__('Code')}}</th>
                      <th>{{__('Description')}}</th>
                      <th>{{__('Abbreviation')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$koc as $kocdata)
                            <tr>
                              <td>{{@$kocdata->id}}</td>
                              <td>{{@$kocdata->code}}</td>
                              <td>{{@$kocdata->description}}</td>
                              <td>{{@$kocdata->abbreviation}}</td>
                          
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$kocdata->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$kocdata->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                  @can('update-country', User::class)
                                    <a class="text-primary mr-3" href="{{url('master-data/country/edit',$cty->id)}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                  @endcan

                                  @can('delete-country', User::class)

                                  <span id="delbtn{{@$cty->id}}"></span>
                                
                                    <form id="delete-product-{{$cty->id}}"
                                        action="{{ url('master-data/country/destroy', $cty->id) }}"
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
                    
                  </table>
                </div>
               
            </div>
        </div>
    </div> 

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.master.koc_js')
@endsection