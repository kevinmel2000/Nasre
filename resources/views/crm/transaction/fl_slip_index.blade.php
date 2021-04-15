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
            {{__('Financial Lines INDEX')}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 com-sm-12 mt-3">
                
                  {!! link_to('transaction-data/fl-slip','Add Data',['class'=>'btn btn-primary']) !!}
                  <hr>
                  {{-- {!! Form::open(array('url'=>'transaction-data/fl-slipindex')) !!}
                  {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari Financial Lines Number, ketik lalu tekan enter']) !!}
                  {!! Form::close() !!} --}}
                  <hr>
                  <table id="fllookupTable" class="table table-bordered table-striped">
                    <thead>

                    <tr>
                      <th>{{__('Number')}}</th>
                      <th>{{__('Insured')}}</th>
                      <th>{{__('UY')}}</th>
                      <th>{{__('Our Share')}}</th>
                      <th>{{__('National Reinsurance')}}</th>
                      <th>{{__('Total Sum Insurance')}}</th>
                      <th>{{__('Endorsement Count')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$insured as $insureddata)
                            <tr>
                              <td><a href="{{  url('transaction-data/updateflslip', $insureddata->id) }}">{{@$insureddata->number}}</a></td>
                              <td> @php echo strtoupper($insureddata->insured_prefix); @endphp - 
                                   @php echo strtoupper($insureddata->insured_name);    @endphp- 
                                   @php echo strtoupper($insureddata->insured_suffix);  @endphp
                              </td>
                              <td>{{@$insureddata->uy }}</td>
                              <td>{{ number_format($insureddata->share,0) }}</td>
                              <td> {{ number_format($insureddata->share_from,0) }}</td>
                              <td> {{ number_format($insureddata->share_to,0) }}</td>
                              <td>{{@$insureddata->count_endorsement}}</td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$insureddata->created_at}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$insureddata->updated_at}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>

                                @can('update-felookup', User::class)
                                {{--<a class="text-primary mr-3" href="{{ url('transaction-data/detailflslip', $insureddata->id) }}">
                                  <i class="fas fa-file"></i>
                                </a>--}}
                                {{-- {!! link_to('transaction-data/detailflslip/'.@$insureddata->id,'Detail Data',['class'=>'btn btn-primary']) !!} --}}
                                @endcan  

                              
                                @can('update-felookup', User::class)
                                {{--<a class="text-primary mr-3" href="{{ url('transaction-data/updateflslip', $insureddata->id) }}">
                                  <i class="fas fa-edit"></i>
                                </a>--}}
                                {{-- {!! link_to('transaction-data/updateflslip/'.@$insureddata->id,'Edit Data',['class'=>'btn btn-primary']) !!} --}}
                                @endcan  


                                  @can('delete-felookup', User::class)

                                  {{--<span id="delbtn{{@$insureddata->id}}"></span>
                                
                                    <form id="delete-felookuplocation-{{$insureddata->id}}"
                                        action="{{ url('transaction-data/fl-slip/destroy', $insureddata->id) }}"
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
@include('crm.transaction.fl_slip_index_js')
@endsection