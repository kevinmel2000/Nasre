@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <div class="content-wrapper">
    @include('crm.layouts.breadcrumb')
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-gray">
                  <h3 class="card-title">{{__('Tax Rates')}}</h3>
                  <a type="button" class="btn btn-sm btn-primary float-right"  data-toggle="modal" data-target="#addTaxRate">{{__('New Tax Rate')}} </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <div class="text text-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                  <table id="taxRatesTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Tax Rate Name')}}</th>
                      <th>{{__('Rate(in %)')}}</th>
                      <th>{{__('Created At')}}</th>
                      <th>{{__('Last Updated At')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$taxRates as $taxRate)
                            <tr>
                              <td>{{@$taxRate->id}}</td>
                              <td>{{@$taxRate->name}}</td>
                              <td>{{@$taxRate->rate}} {{__('%')}}</td>
                              <td>{{@$taxRate->created_at->toDayDateTimeString()}}</td>
                              <td>{{@$taxRate->updated_at->toDayDateTimeString()}}</td>
                                <td>
                                  <span>
                                    @can('update-office', User::class)
                                    
                                    <a href="#" class="text-primary mr-3" data-toggle="modal" data-target="#editTaxRate{{$taxRate->id}}"> 
                                        <i class="fas fa-edit"></i> 
                                    </a>

                                    {{-- SECTION Edit Modal Starts Here --}}
                                    <div class="modal fade" id="editTaxRate{{$taxRate->id}}" tabindex="-1" role="dialog" aria-labelledby="addtaxRateLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content bg-light-gray">
                                            <div class="modal-header bg-gray">
                                            <h5 class="modal-taxRate" id="addtaxRateLabel">{{__('Update Tax Rate')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="{{url('office/taxrate', $taxRate)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="">{{__('Enter a Tax Rate Name')}} </label>
                                                    <input type="text" name="name" class="form-control" value="{{@$taxRate->name}}" required/>
                                                </div>
                                                <label for="">{{__('Enter a Rate')}}</label>
                                                <div class="input-group">
                                                    <input type="number" name="rate" class="form-control" value="{{@$taxRate->rate}}" step=".01" required/>
                                                    <span class="input-group-append">
                                                      <button class="btn btn-default" type="button" disabled><i class="fas fa-percent"></i></button>
                                                    </span>
                                                </div>    
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                                <button type="submit" class="btn btn-info">{{__('Update Tax Rate')}}</button>
                                                </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                    {{-- !SECTION Edit Modal Ends here --}}

                                    @endcan
  
                                    @can('delete-office', User::class)
                                    <span id="delbtn{{@$taxRate->id}}"></span>
                                      <form id="delete-taxRate-{{$taxRate->id}}"
                                          action="{{ url('office/taxrate/destroy', $taxRate) }}"
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
                <!-- /.card-body -->
              </div>


          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


{{-- SECTION Add taxrate modal Starts Here --}}
<div class="modal fade" id="addTaxRate" tabindex="-1" role="dialog" aria-labelledby="addTaxRateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
          <h5 class="modal-title" id="addTaxRateLabel">{{__('Add TaxRate')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('office/taxrate/store')}}" method="POST">
              @csrf
              <div class="form-group">
                <label for="">{{__('Enter a TaxRate Name')}} </label>
                <input type="text" name="name" class="form-control" required/>
              </div>
              <label for="">{{__('Enter a Rate')}} </label>
              <div class="input-group">
                <input type="number" name="rate" class="form-control" step=".01" required/>
                <span class="input-group-append">
                  <button class="btn btn-default" type="button" disabled><i class="fas fa-percent"></i></button>
                </span>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
              <button type="submit" class="btn btn-info">{{__('Add')}}</button>
            </div>
          </form>
      </div>
    </div>
</div>
{{-- !SECTION ADD taxrate modal ends here --}}

@endsection

@section('scripts')
@include('crm.office.taxrate_js')
@endsection



