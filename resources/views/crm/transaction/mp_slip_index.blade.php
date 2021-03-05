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
            {{__('MOVEABLE PROPERTY INDEX')}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 com-sm-12 mt-3">
                
                  {!! link_to('transaction-data/mp-slip','Add Data',['class'=>'btn btn-primary']) !!}
                  <hr>
                  {{-- {!! Form::open(array('url'=>'transaction-data/mp-slipindex')) !!}
                  {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari MOVEABLE PROPERTY Number, ketik lalu tekan enter']) !!}
                  {!! Form::close() !!} --}}
                  <hr>
                  <table id="mplookupTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Number')}}</th>
                      <th>{{__('Insured')}}</th>
                      <th>{{__('Our Share')}}</th>
                      <th>{{__('National Reinsurance')}}</th>
                      <th>{{__('Total Sum Insurance')}}</th>
                      <th>{{__('Coincurance')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$insured as $insureddata)
                            <tr>
                              <td><a href="{{  url('transaction-data/detailmpslip/', $insureddata->id) }}">{{@$insureddata->number}}</a></td>
                              <td>{{@$insureddata->insured_prefix}} - {{@$insureddata->insured_name}} - {{@$insureddata->insured_suffix}}</td>
                              <td>{{@$insureddata->share }}</td>
                              <td >@currency(@$insureddata->share_from)</td>
                              <td >@currency(@$insureddata->share_to)</td>
                              <td>{{@$insureddata->coincurance}}</td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$insureddata->created_at}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$insureddata->updated_at}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>

                                @can('update-felookup', User::class)
                                {{--<a class="text-primary mr-3" href="{{ url('transaction-data/detailmpslip', $insureddata->id) }}">
                                  <i class="fas fa-file"></i>
                                </a>--}}
                                {{-- {!! link_to('transaction-data/detailmpslip/'.@$insureddata->id,'Detail Data',['class'=>'btn btn-primary']) !!} --}}
                                @endcan 
                              
                                @can('update-felookup', User::class)
                                {{--<a class="text-primary mr-3" href="{{ url('transaction-data/updatempslip', $insureddata->id) }}">
                                  <i class="fas fa-edit"></i>
                                </a>--}}
                                {{-- {!! link_to('transaction-data/updatempslip/'.@$insureddata->id,'Edit Data',['class'=>'btn btn-primary']) !!} --}}
                                @endcan  


                                @can('delete-felookup', User::class)

                                {{--<span id="delbtn{{@$insureddata->id}}"></span>
                                
                                    <form id="delete-felookuplocation-{{$insureddata->id}}"
                                        action="{{ url('transaction-data/mp-slip/destroy', $insureddata->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>--}}
                                    @endcan  
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

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.transaction.mp_slip_index_js')
@endsection