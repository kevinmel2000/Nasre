@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('crm.layouts.breadcrumb')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Currencies')}}</h3>
                  <a type="button" class="btn btn-sm btn-primary float-right"  data-toggle="modal" data-target="#addCurrency">{{__('New Currency')}} </a>
                </div>
                <div class="card-body">
                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <div class="text text-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                  <table id="CurrenciesTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Currency')}}</th>
                      <th>{{__('Symbol')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$currencies as $currency)
                            <tr>
                              <td>{{@$currency->name}} 
                              @if (@$currency->is_base_currency == 'yes')
                                <b>({{__('Base Currency')}})</b>
                              @endif
                              </td>
                              <td>{{@$currency->symbol}}</td>
                              <td>
                                <span>
                                  @can('update-office', User::class)
                                  <form action="{{url('office/currency/base', $currency)}}" method="post">
                                    @csrf
                                    @method('PUT')
                                      <input type="hidden" name="is_base_currency" value="yes">
                                      @if ($currency->is_base_currency == 'yes')
                                        <button type="button" class="btn btn-default float-left mr-1" data-toggle="tooltip" data-placement="top" title="{{__('Base currency')}}"><i class="fas fa-star text-primary"></i>
                                        </button>
                                      @else
                                        <button type="submit" class="btn btn-default float-left mr-1" data-toggle="tooltip" data-placement="top" title="{{__('Set as base currency')}}"><i class="far fa-star"></i>
                                        </button>
                                      @endif
                                  </form>

                                  <a href="#" class="text-primary mr-2" data-toggle="modal" data-target="#editCurrency{{$currency->id}}"> 
                                      <i class="fas fa-edit"></i> 
                                  </a>

                                  {{-- SECTION Edit Modal Starts Here --}}
                                  <div class="modal fade" id="editCurrency{{$currency->id}}" tabindex="-1" role="dialog" aria-labelledby="addCurrencyLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                      <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                          <h5 class="modal-Currency" id="addCurrencyLabel">{{__('Update Tax Rate')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          </div>
                                          <div class="modal-body">
                                          <form action="{{url('office/currency', $currency)}}" method="POST">
                                              @csrf
                                              @method('PUT')
                                              <div class="form-group">
                                                  <label for="">{{__('Enter Currency')}} </label>
                                                  <input type="text" name="name" class="form-control" value="{{@$currency->name}}" required/>
                                              </div>
                                              <div class="form-group">
                                                  <label for="">{{__('Enter Symbol')}} </label>
                                                  <input type="text" name="symbol" class="form-control" value="{{@$currency->symbol}}"  required/>
                                              </div>    
                                              </div>
                                              <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                              <button type="submit" class="btn btn-info">{{__('Update Currency')}}</button>
                                              </div>
                                          </form>
                                      </div>
                                      </div>
                                  </div>
                                  {{-- !SECTION Edit Modal Ends here --}}

                                  @endcan

                                  @can('delete-office', User::class)
                                  <span id="delbtn{{@$currency->id}}"></span>
                                    <form id="delete-Currency-{{$currency->id}}"
                                        action="{{ url('office/currency/destroy', $currency) }}"
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
      </div><!-- /.container-fluid -->
    </section>
  </div>


{{-- SECTION Add Currency modal Starts Here --}}
<div class="modal fade" id="addCurrency" tabindex="-1" role="dialog" aria-labelledby="addCurrencyLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
          <h5 class="modal-title" id="addCurrencyLabel">{{__('Add Currency')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('office/currency/store')}}" method="POST">
              @csrf
              <div class="form-group">
                <label for="">{{__('Enter  Currency Name')}} </label>
                <input type="text" name="name" class="form-control" required/>
              </div>
              <div class="form-group">
                <label for="">{{__('Symbol')}} </label>
                <input type="text" name="symbol" class="form-control" required/>
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
{{-- !SECTION ADD Currency modal ends here --}}

@endsection

@section('scripts')
@include('crm.office.currency_js')
@endsection



