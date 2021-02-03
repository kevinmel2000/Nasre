@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('master-data/exchange/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Currency Exchange Data')}}
          </div>
          
          <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Currency')}}</label>
                          <select name="exccurrency" class="e1 form-control form-control-sm ">
                              <option selected disabled>{{__('Select Currency')}}</option>
                              @foreach($currency as $crc)
                              <option value="{{ $crc->id }}">{{ $crc->code }} - {{ $crc->symbol_name }}</option>
                              @endforeach
                          </select>
                      </div>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Month')}}</label>
                          <select name="excmonth" class="e1 form-control form-control-sm ">
                              <option selected disabled>{{__('Select Month')}}</option>
                              <option value="1">1 - January</option>
                              <option value="2">2 - February</option>
                              <option value="3">3 - March</option>
                              <option value="4">4 - April</option>
                              <option value="5">5 - May </option>
                              <option value="6">6 - June</option>
                              <option value="7">7 - July</option>
                              <option value="8">8 - August</option>
                              <option value="9">9 - September</option>
                              <option value="10">10 - October</option>
                              <option value="11">11 - November</option>
                              <option value="12">12 - December</option>
                          </select>
                      </div>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Year')}} </label>
                          <input type="number" name="excyear" class="form-control form-control-sm" data-validation="length" data-validation-length="2-20" required/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Kurs')}}</label>
                          <input type="text" name="exckurs" class="form-control form-control-sm " data-validation="length" data-validation-length="2-150" required/>
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
                  <table id="excTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Currency')}}</th>
                      <th>{{__('Month')}}</th>
                      <th>{{__('Year')}}</th>
                      <th>{{__('Kurs')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$currency_exchange as $exc)
                            <tr>
                              <td>{{@$exc->curr->code}} - {{@$exc->curr->symbol_name}}</td>
                              <td>@if(@$exc->month == "1")1 - January 
                                @elseif(@$exc->month == "2")2 - February
                                @elseif(@$exc->month == "3")3 - March
                                @elseif(@$exc->month == "4")4 - April
                                @elseif(@$exc->month == "5")5 - May
                                @elseif(@$exc->month == "6")6 - June
                                @elseif(@$exc->month == "7")7 - July
                                @elseif(@$exc->month == "8")8 - August
                                @elseif(@$exc->month == "9")9 - September
                                @elseif(@$exc->month == "10")10 - October
                                @elseif(@$exc->month == "11")11 - November
                                @elseif(@$exc->month == "12")12 - December
                                @endif
                              </td>
                              <td>{{@$exc->year}}</td>
                              <td>{{@$exc->kurs}}</td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$exc->created_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$exc->updated_at->toDayDateTimeString()}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                  {{-- @can('update-country', User::class) --}}
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updateexc{{$exc->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                  {{-- @endcan --}}

                                  <div class="modal fade" id="updateexc{{$exc->id}}" tabindex="-1" user="dialog" aria-labelledby="updateexc{{$exc->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updateexc{{$exc->id}}Label">{{__('Update Currency Exchange')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/exchange',$exc)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                        <div class="form-group">
                                                            <label for="">{{__('Currency')}}</label><br>
                                                            <select name="currencyexc" class="e1 form-control form-control-sm ">
                                                                <option selected disabled>{{__('Select Currency')}}</option>
                                                                @foreach($currency as $crc)
                                                                  @if($exc->currency  == $crc->id)
                                                                    <option value="{{ $crc->id }}" selected>{{ $crc->code }} - {{ $crc->symbol_name }}</option>
                                                                  @else
                                                                    <option value="{{  $crc->id }}">{{  $crc->code  }} - {{ $crc->symbol_name }}</option>
                                                                  @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                      </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                        <div class="form-group">
                                                          <label for="">{{__('Month')}}</label><br>
                                                          <select name="monthexc" class="e1 form-control form-control-sm">
                                                            @if(@$exc->month == "1")
                                                            <option value="1" selected>1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "2")
                                                            <option value="1">1 - January</option>
                                                            <option value="2" selected>2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "3")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3" selected>3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "4")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4" selected>4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "5")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5" selected>5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "6")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6" selected>6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "7")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7" selected>7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "8")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8" selected>8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "9")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9" selected>9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "10")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10" selected>10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "11")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11" selected>11 - November</option>
                                                            <option value="12">12 - December</option>
                                                            @elseif(@$exc->month == "12")
                                                            <option value="1">1 - January</option>
                                                            <option value="2">2 - February</option>
                                                            <option value="3">3 - March</option>
                                                            <option value="4">4 - April</option>
                                                            <option value="5">5 - May </option>
                                                            <option value="6">6 - June</option>
                                                            <option value="7">7 - July</option>
                                                            <option value="8">8 - August</option>
                                                            <option value="9">9 - September</option>
                                                            <option value="10">10 - October</option>
                                                            <option value="11">11 - November</option>
                                                            <option value="12" selected>12 - December</option>
                                                            @endif
                                                          </select>
                                                        </div>
                                                      </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6 col-md-12">
                                                      <div class="form-group">
                                                        <label for="">{{__('Year')}}</label>
                                                        <input type="text" name="yearexc"  class="form-control" value="{{$exc->year}}" data-validation="length" data-validation-length="2-15" required />
                                                      </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Kurs')}}</label>
                                                      <input type="text" name="kursexc" class="form-control" value="{{$exc->kurs}}" data-validation="length" data-validation-length="2-150" required/>
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

                                  <span id="delbtn{{@$exc->id}}"></span>
                                
                                    <form id="delete-exc-{{$exc->id}}"
                                        action="{{ url('master-data/exchange/destroy', $exc->id) }}"
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
@include('crm.master.exchange_js')
@endsection