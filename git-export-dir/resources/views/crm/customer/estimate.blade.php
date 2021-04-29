@extends('crm.layouts.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            @include('crm.customer.common.contact_inner_sidebar')
            <div class="col-md-9">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Manage Estimates')}}</h3>
                        @php
                          $relation = 'Customer';
                        @endphp
                        <a type="button" class="btn btn-sm btn-primary float-right"
                            href="{{url('estimate/create/'.$relation.'/'.$customer->id)}}">{{__('New Estimate')}} </a>    
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="estimatesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><label for="">{{__('ID')}}</label></th>
                                    <th><label for="">{{__('Title')}}</label></th>
                                    <th><label for="">{{__('Due Date')}}</label></th>
                                    <th><label for="">{{__('To')}}</label></th>
                                    <th><label for="">{{__('Estimate Date')}}</label></th>
                                    <th><label for="">{{__('Status')}}</label></th>
                                  
                                    <th><label for="">{{__('Total Amount')}}</label></th>
                                    <th><label for="">{{__('Agent')}}</label></th>
                                    <th><label for="">{{__('Actions')}}</label></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$estimates as $estimate)
                                    <tr>
                                      <td
                                      @if ($estimate->is_invoiced == 'yes')
                                        class="bg-success"
                                        data-toggle="tooltip"
                                        data-target="top"
                                        title="Invoiced"
                                      @endif
                                      >{{@$estimate->id}}</td>
                                      <td>
                                        <a href="#" data-toggle="modal" data-target="#viewestimate{{@$estimate->id}}">
                                          {{@$estimate->estimate_title}}
                                        </a>
                                      {{-- View estimate Modal Starts --}}
                                      <div class="modal fade" id="viewestimate{{@$estimate->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title text-success">#{{@$estimate->id}} |  {{__('Estimate')}} - {{$estimate->estimate_title}} </h5>
                                              
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="row">
                                                <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label for=""><span class="text-danger">*</span> {{__('Estimate Number')}} </label>
                                                      <input type="text"  value="{{@$estimate->estimate_number}}"  name="estimate_number" class="form-control form-control-sm" readonly/>
                                                  </div>
                                                </div>
                                                <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label for=""><span class="text-danger">*</span> {{__('Estimate Title')}} </label>
                                                      <input type="text"  value="{{@$estimate->estimate_title}}"  name="estimate_title" class="form-control form-control-sm" readonly/>
                                                  </div>
                                                </div>
                                                <div class="col-md-3">
                                                  <div class="form-group">
                                                    <label for=""><span class="text-danger">*</span>{{__('Customer Username')}} </label>
                                                    <input type="text" value="{{@$estimate->contact->username}}" class="form-control form-control-sm" readonly>
                                                  </div>
                                                </div>
                              
                                                <div class="col-md-3">
                                                  <div class="form-group">
                                                    <label for=""><span class="text-danger">*</span> {{__('Sales Agent')}}</label>
                                                    <input type="text" value="{{@$estimate->user->name}}" class="form-control form-control-sm" readonly>
                                                  </div>
                                                </div>
                              
                                            </div>
                              
                                            <div class="row">
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Estimate Date ')}}</label>
                                                  <input type="date" value="{{@$estimate->estimate_date}}" name="estimate_date" class="form-control form-control-sm" readonly/>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Due Date')}} </label>
                                                  <input type="date" value="{{@$estimate->due_date}}" name="due_date" class="form-control form-control-sm" readonly/>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Status')}} </label>
                                                  <select name="status" class="form-control form-control-sm" readonly>
                                                    @php
                                                      $statusess = [
                                                        __('draft'), 
                                                        __('sent'), 
                                                        __('open'), 
                                                        __('revised'), 
                                                        __('declined')
                                                      ];
                                                    @endphp
                                                    @foreach ($statusess as $status)
                                                        @if (@$estimate->status == $status)
                                                          <option value="{{$status}}" selected>{{$status}}</option>
                                                        @endif
                                                    @endforeach
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Currency')}} </label>
                                                  <input type="text" value="{{@$estimate->currency->name}}"  class="form-control form-control-sm" readonly>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row">
                                             
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Shipping Charges(if any)')}} </label>
                                                  <input type="number" name="shipping_charges" value="{{@$estimate->shipping_charges}}" step="0.01" class="form-control form-control-sm" readonly/>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Mail To')}}</label>
                                                  <input type="text" name="mail_to" value="{{@$estimate->mail_to}}" class="form-control form-control-sm" readonly>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="">{{__('Terms and Conditions')}} </label>
                                                  <textarea name="termsandconditions" class="form-control form-control-sm" rows="5" readonly>{{@$estimate->termsandconditions}}</textarea>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="">{{__('Customer Notes ')}}</label>
                                                  <textarea name="customer_notes" class="form-control form-control-sm" rows="5" readonly>{{@$estimate->customer_notes}}</textarea>
                                                </div>
                                              </div>
                                            </div>
                                              <div class="row">
                                                <div class="col-md-12">
                                                  <table class="table">
                                                    <thead>
                                                      <th><label for="">#</label></th>
                                                      <th><label for="">{{__('Product')}}</label></th>
                                                      <th><label for="">{{__('Price')}}</label></th>
                                                      <th><label for="">{{__('Qty')}}</label></th>
                                                      <th><label for="">{{__('Tax')}}</label></th>
                                                      <th><label for="">{{__('Amount')}}</label></th>
                                                      <th><label for="">{{__('Created At')}}</label></th>
                                                    </thead>
                                                    <tbody>
                                                      @foreach(@$estimate->estimateProducts as $product)
                                                      <tr>
                                                        <td>{{@$product->id}}</td>
                                                        <td>{{@$product->product_name}}</td>
                                                        <td>{{@$estimate->currency->symbol}} {{@$product->product_price}}</td>
                                                        <td>{{@$product->product_qty}}</td>
                                                        <td>{{@$product->product_tax}} %</td>
                                                        <td>{{@$estimate->currency->symbol}} {{@$product->product_amount}}</td>
                                                        <td>{{@$product->created_at}}</td>
                                                      </tr>
                                                      @endforeach
                                                    </tbody>
                                                    <tbody>
                                                      <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><label for="">{{__('Sub Total')}}</label></td>
                                                        <td>{{@$estimate->currency->symbol}} {{@$estimate->sub_total}}</td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><label for="">{{__('Discount')}}</label></td>
                                                        <td>{{@$estimate->total_discount_percentage}}%</td>
                                                        <td>{{@$estimate->currency->symbol}} {{@$estimate->discount_total}}</td>
                                                        <td>{{@$estimate->discount_type}}</td>
                                                      </tr>
                                                      <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><label for="">{{__('Adjustments')}}</label></td>
                                                        <td>{{@$estimate->currency->symbol}} {{@$estimate->adjustments}}</td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td colspan="4" class="font-bold"><label for="">{{__('Total Amount = Sub Total - Discount + Adjustments')}} </label></td>
                                                        <td><label for="">{{__('Total Amount')}}</label></td>
                                                        <td>{{@$estimate->currency->symbol}} {{@$estimate->total_amount}}</td>
                                                        <td></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
        
                                      {{-- View estimate Modal Ends --}}
        
                                      </td>
                                      
                                      <td>{{@$estimate->due_date}}</td>
                                      <td>
                                          <span class="badge badge-success">{{@$estimate->relation}}</span>
                                            {{@$estimate->contact->username}} | {{@$estimate->contact->email}}
                                      </td>
                                      <td>{{@$estimate->estimate_date}}</td>
                                      <td>{{@$estimate->status}}</td>
                                     
                                      <td>{{@$estimate->currency->symbol}} {{@$estimate->total_amount}}</td>
                                      <td>{{@$estimate->user->name}}</td>
                                        <td>
                                          <span>
                                            <a class=" pr-2" href="{{url('estimate/email/'.$estimate->id )}}">
                                              <i class="fas fa-mail-bulk"></i>
                                            </a>
                                            @can('update-contact', User::class)
                                              <a class=" pr-2" href="{{url('/estimate/edit', $estimate)}}">
                                                <i class="fas fa-edit"></i>
                                              </a>
                                            @endcan
                                            @can('delete-contact', User::class)
                                            <span id="delbtn{{@$estimate->id}}"></span>
                                              <form id="delete-contact-{{$estimate->id}}"
                                                  action="{{ url('estimate/destroy', $estimate) }}"
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
</div>


{{-- ANCHOR MODAL VIEW estimate --}}


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>

{{-- MODAL VIEW estimate ENDS --}}

{{-- SECTION Add Currency modal Starts Here --}}
<div class="modal fade" id="addestimate" tabindex="-1" role="dialog" aria-labelledby="addestimateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addestimateLabel">{{__('Add estimate')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('office/currency/store')}}" method="POST">
                    @csrf


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
@include('crm.customer.estimate_js')
@endsection
