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
            {{__('CLAIM INSURED INDEX')}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 com-sm-12 mt-3">
                
                  {!! link_to('claimtransaction-data/claim','Add Data',['class'=>'btn btn-primary']) !!}
                  <hr>
                  {{ Form::open(array('url'=>'claimtransaction-data/claim-index')) }}
                      <div class="row">
                          <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">{{__('Doc Number')}}</label>
                                        {{ Form::text('search',@$search,['class'=>'form-control form-control-sm','placeholder'=>'Cari Doc Number']) }}
                                    </div>
                                </div>
                              </div>
                              
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="">{{__('Cause Of Loss')}}</label><br>
                                      <select id="searchcauseofloss" name="searchcauseofloss" class="e1 form-control form-control-sm ">
                                          <option selected readonly  value='0'>{{__('Cause Of Loss')}}</option>
                                          @foreach($causeofloss as $pi)
                                            @if($pi->id  == @$searchcauseofloss)
                                                <option value="{{ $pi->id }}" selected>{{ $pi->nama }} - {{ $pi->keterangan }}</option>
								                            @else
                                                <option value="{{ $pi->id }}">{{ $pi->nama }} - {{ $pi->keterangan }}</option>
								                            @endif
                                          @endforeach
                                      </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">{{__('Nature Of Loss')}}</label><br>
                                        <select id="searchnatureofloss" name="searchnatureofloss" class="e1 form-control form-control-sm ">
                                            <option value=""  selected disabled >Nature Of Loss</option>
                                            @foreach($natureofloss as $pi)
                                                @if($pi->id  == @$searchnatureofloss)
                                                <option value="{{ $pi->id }}" selected> {{ $pi->accident }} - {{ $pi->keterangan }}</option>
                                                @else
                                                <option value="{{ $pi->id }}"> {{ $pi->accident }} - {{ $pi->keterangan }}</option>
                                                 @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                              </div>
                              
                             
                          
                          </div>

                          <div class="col-md-6">
                              
                               <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">{{__('Reg Comp')}}</label>
                                        {{ Form::text('regcompsearch',@$regcompsearch,['class'=>'form-control form-control-sm','placeholder'=>'Reg Comp']) }}
                                    </div>
                                </div>
                              </div>
                              
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="">{{__('Date Of Receipt ')}}</label><br>
                                      {{ Form::text('searchdate',@$searchdate,['class'=>'form-control form-control-sm datepicker','placeholder'=>'Date Of Receipt']) }}
                                   </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">{{__('Surveyor')}}</label><br>
                                        <select id="searchsurveyor" name="searchsurveyor" class="e1 form-control form-control-sm ">
                                            <option value=""  selected disabled >Surveyor</option>
                                            @foreach($surveyor as $pi)
                                                @if($pi->id  == @$searchsurveyor)
                                                <option value="{{ $pi->id }}" selected> {{ $pi->number }} - {{ $pi->keterangan }}</option>
                                                @else
                                                <option value="{{ $pi->id }}"> {{ $pi->number }} - {{ $pi->keterangan }}</option>
                                                 @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                              </div>

                              
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">{{__('Search')}}</button>
                          </div>
                        </div>
                      </div>
                  {{ Form::close() }}


                  <hr>
                  <table id="felookupTable2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Number')}}</th>
                      <th>{{__('Reg COmp')}}</th>
                      <th>{{__('Date Receipt')}}</th>
                      <th>{{__('Cause Of Loss')}}</th>
                      <th>{{__('Natural Of Loss')}}</th>
                      <th>{{__('Surveyor')}}</th>
                      <th>{{__('Total Loss AMount')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$claimlist as $claimlistata)
                            <tr>
                              <td ><a href="{{  url('claimtransaction-data/updateclaim', $claimlistata->id) }}">{{@$claimlistata->number}}</a></td>
                              <td> @php echo strtoupper($claimlistata->reg_comp); @endphp - 
                                  
                              </td>
                              <td>{{@$claimlistata->date_receipt }}</td>
                              <td>{{@$claimlistata->desc_causeofloss }}</td>
                              <td>{{@$claimlistata->descnatureofloss }}</td>
                              <td>{{@$claimlistata->desc_surveyor }}</td>
                              <td>{{@$claimlistata->total_loss_amount }}</td>
                              <td>
                                <a href="#" data-toggle="tooltip" data-title="{{$claimlistata->created_at}}" class="mr-3">
                                  <i class="fas fa-clock text-info"></i>
                                </a>
                                <a href="#" data-toggle="tooltip" data-title="{{$claimlistata->updated_at}}" class="mr-3">
                                  <i class="fas fa-history text-primary"></i>
                                </a>
                                <span>
                                
                                {{-- @can('update-felookup', User::class) --}}
                                {{--<a class="text-primary mr-3" href="{{ url('claimtransaction-data/detailclaim', $claimlistata->id) }}">
                                  <i class="fas fa-file"></i>
                                </a>--}}
                                {{-- {!! link_to('transaction-data/detailfeslip/'.@$claimlistata->id,'Detail Data',['class'=>'btn btn-primary']) !!} --}}
                                {{-- @endcan   --}}

                                {{-- @can('update-felookup', User::class) --}}
                                {{--<a class="text-primary mr-3" href="{{ url('claimtransaction-data/updateclaim', $claimlistata->id) }}">
                                  <i class="fas fa-edit"></i>
                                </a>--}}
                                {{-- {!! link_to('transaction-data/updatefeslip/'.@$claimlistata->id,'Edit Data',['class'=>'btn btn-primary']) !!} --}}
                                {{-- @endcan   --}}

                                  

                                   {{-- @can('delete-felookup', User::class) --}}

                                   {{--<span id="delbtn{{@$claimlistata->id}}"></span>
                                
                                    <form id="delete-felookuplocation-{{$claimlistata->id}}"
                                        action="{{ url('claimtransaction-data/claim/destroy', $claimlistata->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>>--}}
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


  </div>
  </div>
@endsection

@section('scripts')
@include('crm.transaction.claim.claim_index_js')
@endsection