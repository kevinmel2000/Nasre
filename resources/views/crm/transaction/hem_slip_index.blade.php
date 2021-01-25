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
            {{__('HE & MOTOR INDEX')}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 com-sm-12 mt-3">
                
                  {!! link_to('transaction-data/hem-slip','Tambah HE & MOTOR Insured Slip',['class'=>'btn btn-primary']) !!}
                  <hr>
                  {!! Form::open(array('url'=>'transaction-data/hem-slipindex')) !!}
                  {!! Form::text('search',null,['class'=>'form-control','placeholder'=>'Cari HE & MOTOR Number, ketik lalu tekan enter']) !!}
                  {!! Form::close() !!}
                  <hr>
                  <table id="felookupTable2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Number')}}</th>
                      <th>{{__('Insured')}}</th>
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
                              <td>{{@$insureddata->number}}</td>
                              <td>{{@$insureddata->insured_prefix}} - {{@$insureddata->insured_name}} - {{@$insureddata->insured_suffix}}</td>
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

                                
                                  @can('update-felookup', User::class)
                                    <a class="text-primary mr-3" data-toggle="modal" data-target="#updatefelookuplocation{{$insureddata->id}}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan  

                                    <div class="modal fade" id="updatefelookuplocation{{$insureddata->id}}" tabindex="-1" user="dialog" aria-labelledby="updatefelookuplocation{{$insureddata->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" user="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updatefelookuplocation{{$insureddata->id}}Label">{{__('Update Fe Lookup Location')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('master-data/felookuplocation/update',$insureddata)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                  <div class="col-md-6 col-md-12">
                                                    <div class="form-group">
                                                      <label for="">{{__('Number')}}</label>
                                                      <input type="text" name="number" class="form-control" value="{{$insureddata->number}}" readonly required/>
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

                                @can('delete-felookup', User::class)

                                  <span id="delbtn{{@$insureddata->id}}"></span>
                                
                                    <form id="delete-felookuplocation-{{$insureddata->id}}"
                                        action="{{ url('master-data/felookuplocation/destroy', $insureddata->id) }}"
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

                  {!! $insured->render() !!}

                </div>
               
            </div>
        </div>
    </div> 

  </div>
  </div>
@endsection

@section('scripts')
@include('crm.transaction.hem_slip_index_js')
@endsection