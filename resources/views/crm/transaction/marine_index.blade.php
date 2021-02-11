@extends('crm.layouts.app')

<style type="text/css">    
      #map {
        margin: 10px;
        width: 600px;
        height: 300px;  
        padding: 10px;
      }
</style>

@section('content')
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <div class="container-fluid">
            
            {{-- NOTE Show All Errors Here --}}
            @include('crm.layouts.error')
            
        
                <div class="card card-primary">
                    <div class="card-header bg-gray">
                        {{__('Marine - Insured Data')}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 com-sm-12 mt-3">
                            
                            {!! link_to('transaction-data/marine-slip','Add Data',['class'=>'btn btn-primary']) !!}
                            <hr>
                            {!! Form::open(array('url'=>'transaction-data/marine-index')) !!}
                            {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari Marine Slip Insured Number, ketik lalu tekan enter']) !!}
                            {!! Form::close() !!}
                            <hr>
                            <table id="marineinsured" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                <th>{{__('Number')}}</th>
                                <th>{{__('Insured')}}</th>
                                <th>{{__('Route')}}</th>
                                <th>{{__('Route From')}}</th>
                                <th>{{__('Route To')}}</th>
                                <th>{{__('Share')}}</th>
                                <th>{{__('Share From')}}</th>
                                <th>{{__('Share To')}}</th>
                                <th>{{__('Coincurance')}}</th>
                                <th width="20%">{{__('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach (@$insured as $insureddata)
                                        <tr>
                                        <td><a href="{{  url('transaction-data/marine-insured', $insureddata->id) }}">{{@$insureddata->number}}</a></td>
                                        <td>{{@$insureddata->insured_prefix}} - {{@$insureddata->insured_name}} - {{@$insureddata->insured_suffix}}</td>
                                        <td>{{@$insureddata->route }}</td>
                                        <td>{{@$insureddata->route_from}}</td>
                                        <td>{{@$insureddata->route_to}}</td>
                                        <td>{{@$insureddata->share }}</td>
                                        <td>{{@$insureddata->share_from}}</td>
                                        <td>{{@$insureddata->share_to}}</td>
                                        <td>{{@$insureddata->coincurance}}</td>
                                        <td>
                                            <a href="#" data-toggle="tooltip" data-title="{{$insureddata->created_at}}" class="mr-3">
                                            <i class="fas fa-clock text-info"></i>
                                            </a>
                                            <a href="#" data-toggle="tooltip" data-title="{{$insureddata->updated_at}}" class="mr-3">
                                            <i class="fas fa-history text-primary"></i>
                                            </a>
                                            <span>

                                            
                                            {{-- @can('update-felookup', User::class) --}}
                                                <a class="text-primary mr-3" href="{{ url('transaction-data/marine-insured/edit', $insureddata->id) }}">
                                                <i class="fas fa-edit"></i>
                                                </a>
                                                {{-- @endcan   --}}


                                            {{-- @can('delete-marineinsured', User::class) --}}

                                            <span id="delbtn{{@$insureddata->id}}"></span>
                                            
                                                <form id="delete-marineinsured-{{$insureddata->id}}"
                                                    action="{{ url('transaction-data/marine-insured/destroyinsured', $insureddata->id) }}"
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

                            {!! $insured->render() !!}

                            </div>
                        
                        </div>
                    </div>
                </div>
                
                <div class="card card-primary">
                    <div class="card-header bg-gray">
                        {{__('Marine - Slip Data')}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 com-sm-12 mt-3">
                            
                            {!! link_to('transaction-data/marine-slip','Add Data',['class'=>'btn btn-primary']) !!}
                            <hr>
                            {!! Form::open(array('url'=>'transaction-data/marine-index')) !!}
                            {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari Marine Slip Number, ketik lalu tekan enter']) !!}
                            {!! Form::close() !!}
                            <hr>
                            <table id="marineslip" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                <th>{{__('Number')}}</th>
                                <th>{{__('Insured')}}</th>
                                <th>{{__('production year')}}</th>
                                <th>{{__('UY')}}</th>
                                <th>{{__('status')}}</th>
                                <th>{{__('username')}}</th>
                                <th width="20%">{{__('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach (@$slip as $slipdata)
                                        <tr>
                                        <td><a href="{{  url('transaction-data/marine-slip', $slipdata->id) }}">{{@$slipdata->number}}</a></td>
                                        <td>{{@$slipdata->insureddata->insured_prefix}} - {{@$slipdata->insureddata->insured_name}} - {{@$slipdata->insureddata->insured_suffix}}</td>
                                        <td>{{@$slipdata->prod_year }}</td>
                                        <td>{{@$slipdata->uy}}</td>
                                        <td>{{@$slipdata->status}}</td>
                                        <td>{{@$slipdata->username}}</td>
                                        <td>
                                            <a href="#" data-toggle="tooltip" data-title="{{$slipdata->created_at}}" class="mr-3">
                                            <i class="fas fa-clock text-info"></i>
                                            </a>
                                            <a href="#" data-toggle="tooltip" data-title="{{$slipdata->updated_at}}" class="mr-3">
                                            <i class="fas fa-history text-primary"></i>
                                            </a>
                                            <span>

                                            
                                            {{-- @can('update-felookup', User::class) --}}
                                                <a class="text-primary mr-3" data-toggle="modal" data-target="#updateslipmarine{{$slipdata->id}}">
                                                <i class="fas fa-edit"></i>
                                                </a>
                                                {{-- @endcan   --}}

                                                <div class="modal fade" id="updateslipmarine{{$slipdata->id}}" tabindex="-1" user="dialog" aria-labelledby="updateslipmarine{{$slipdata->id}}Label" aria-hidden="true">
                                                <div class="modal-dialog" user="document">
                                                <div class="modal-content bg-light-gray">
                                                    <div class="modal-header bg-gray">
                                                    <h5 class="modal-title" id="updateslipmarine{{$slipdata->id}}Label">{{__('Update Marine Insured')}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <form action="{{url('master-data/marineslip/update',$slipdata)}}" method="POST">
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="row">
                                                            <div class="col-md-6 col-md-12">
                                                                <div class="form-group">
                                                                <label for="">{{__('Number')}}</label>
                                                                <input type="text" name="number" class="form-control" value="{{$slipdata->number}}" readonly required/>
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

                                            {{-- @can('delete-marineinsured', User::class) --}}

                                            <span id="delbtn2{{@$slipdata->id}}"></span>
                                            
                                                <form id="delete-marineslip-{{$slipdata->id}}"
                                                    action="{{ url('transaction-data/marine-slip/destroyslip', $slipdata->id) }}"
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

                            {!! $slip->render() !!}

                            </div>
                        
                        </div>
                    </div>
                </div>

        </div>
    </div>
@endsection

@section('scripts')
@include('crm.transaction.marine_index_js')
@endsection