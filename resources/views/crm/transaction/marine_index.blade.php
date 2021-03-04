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
                        {{__('Marine - Slip and Insured Data')}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 com-sm-12 mt-3">
                            
                            {!! link_to('transaction-data/marine-slip','Add Data',['class'=>'btn btn-primary']) !!}
                            <hr>
                            {{-- {!! Form::open(array('url'=>'transaction-data/marine-index')) !!}
                            {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari Marine Slip Number, ketik lalu tekan enter']) !!}
                            {!! Form::close() !!} --}}
                            <hr>
                            <table id="marineslip" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                <th>{{__('Number')}}</th>
                                <th>{{__('Insured')}}</th>
                                <th>{{__('Our Share')}}</th>
                                <th>{{__('National Reinsurance')}}</th>
                                <th>{{__('Total Sum Insurance')}}</th>
                                <th>{{__('Coinsurance')}}</th>
                                <th width="10%">{{__('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach (@$insured as $insdata)
                                        <tr>
                                        <td><a href="{{  url('transaction-data/marine-slip', $insdata->id) }}">{{@$insdata->number}}</a></td>
                                        <td>{{@$insdata->insured_prefix}} - {{@$insdata->insured_name}} - {{@$insdata->insured_suffix}}</td>
                                        <td>{{@$insdata->share }}</td>
                                        <td>@currency($insdata->share_from)</td>
                                        <td>@currency($insdata->share_to)</td>
                                        <td>{{@$insdata->coincurance}}</td>
                                        <td width="10%">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-title="{{$insdata->created_at}}" class="mr-3">
                                            <i class="fas fa-clock text-info"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-title="{{$insdata->updated_at}}" class="mr-3">
                                            <i class="fas fa-history text-primary"></i>
                                            </a>
                                            <span>

                                            
                                            {{-- @can('update-felookup', User::class) --}}
                                                {{-- <a class="text-primary mr-3" href="{{ url('transaction-data/marine-slip/edit', $insdata->id) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a> --}}
                                                {{-- @endcan   --}}

                                                

                                            {{-- @can('delete-marineinsured', User::class) --}}

                                            {{-- <span id="delbtn2{{@$insdata->id}}"></span>
                                            
                                                <form id="delete-marineslip-{{$insdata->id}}"
                                                    action="{{ url('transaction-data/marine-slip/destroyslip', $insdata->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                               
                                            </span> --}}
                                            {{-- @endcan   --}}
                                        
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