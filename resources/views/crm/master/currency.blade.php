@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/currency/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Currency Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Code')}} </label>
                          <input type="text" name="crccode" class="form-control form-control-sm" data-validation="length" data-validation-length="2-3" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Symbol/Name')}}</label>
                          <input type="text" name="crcsymbolname" class="form-control form-control-sm " data-validation="length" data-validation-length="2-150" required/>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Country')}}</label>
                          <select name="crccountry" class="form-control form-control-sm ">
                              <option selected disabled>{{__('Select Country')}}</option>
                              @foreach($country as $cty)
                              <option value="{{ $cty->id }}">{{ $cty->id }} - {{ $cty->name }}</option>
                              @endforeach
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
                            {{__('Save Currency')}}
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
                  <table id="crcTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Code')}}</th>
                      <th>{{__('Symbol/Name')}}</th>
                      <th>{{__('Country')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$currency as $crc)
                            <tr>
                              <td>{{@$crc->code}}</td>
                              <td>{{@$crc->symbol_name}}</td>
                              <td>{{@$crc->countryside->id}} - {{@$crc->countryside->name}}</td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$crc->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$crc->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                  {{-- @can('update-country', User::class) --}}
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updatecrc{{$crc->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                  {{-- @endcan --}}

                                  <div class="modal fade" id="updatecrc{{$crc->id}}" tabindex="-1" user="dialog" aria-labelledby="updatecrc{{$crc->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updatecrc{{$crc->id}}Label">{{__('Update Currency')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/currency',$crc)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Code')}}</label>
                                                      <input type="text" name="codecrc"  class="form-control" value="{{$crc->code}}" data-validation="length" data-validation-length="2-3" required />
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Symbol/Name')}}</label>
                                                      <input type="text" name="symbolnamecrc" class="form-control" value="{{$crc->symbol_name}}" data-validation="length" data-validation-length="2-150" required/>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="">{{__('Country')}}</label>
                                                        <select name="countrycrc" class="form-control form-control-sm ">
                                                            <option selected disabled>{{__('Select Country')}}</option>
                                                            @foreach($country as $cty)
                                                            @if($crc->country  == $cty->id)
                                                            <option value="{{ $cty->id }}" selected>{{ $cty->id }} - {{ $cty->name }}</option>
                                                            @else
                                                            <option value="{{  $cty->id }}">{{  $cty->id  }} - {{ $cty->name }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                  </div>
                                              
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                                <input type="submit" class="btn btn-info" value="Update">
                                            </div>
                                        </form>
                                      </div>
                                    </div>
                                </div>
                                {{-- Edit Modal Ends --}}

                                  {{-- @can('delete-country', User::class) --}}

                                  <span id="delbtn{{@$crc->id}}"></span>
                                
                                    <form id="delete-crc-{{$crc->id}}"
                                        action="{{ url('master-data/currency/destroy', $crc->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                  {{-- @endcan   --}}
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
@include('crm.master.currency_js')
@endsection