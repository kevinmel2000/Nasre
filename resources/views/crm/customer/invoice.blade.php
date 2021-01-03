@extends('crm.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            @include('crm.customer.common.contact_inner_sidebar')
            <div class="col-md-9">
                <div class="card">
                  <div class="card-header bg-gray">
                    <span class="float-left">{{__('Manage Invoices')}}</span>
                    @php
                        $relation = 'Customer';
                    @endphp
                    <a class="card-title bg-primary pl-2 pr-2 rounded float-right" href="{{url('invoice/create/'.$relation.'/'.$customer->id)}}" id="addNewNote">{{__('New Invoice')}}</a>
                  </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table id="invoicesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Due Date')}}</th>
                                    <th>{{__('To')}}</th>
                                    <th>{{__('Invoice Date')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Paid')}}</th>
                                    <th>{{__('Due Amount')}}</th>
                                    <th>{{__('Total Amount')}}</th>
                                    <th>{{__('Assigned To')}}</th>
                                    <th>{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$invoices as $invoice)
                                    <tr>
                                      <td>{{@$invoice->id}}</td>
                                      <td>
                                        <a href="#" data-toggle="modal" data-target="#viewinvoice{{@$invoice->id}}">
                                          {{@$invoice->invoice_title}}
                                        </a>
                                      {{-- View invoice Modal Starts --}}
                                      <div class="modal fade" id="viewinvoice{{@$invoice->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title text-success">#{{@$invoice->id}} |  {{__('Invoice')}} - {{$invoice->invoice_title}} </h5>
                                              
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="row">
                                                <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label for=""><span class="text-danger">*</span> {{__('Invoice Number')}} </label>
                                                      <input type="text"  value="{{@$invoice->invoice_number}}"  name="invoice_number" class="form-control form-control-sm" readonly/>
                                                  </div>
                                                </div>
                                                <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label for=""><span class="text-danger">*</span> {{__('Invoice Title')}} </label>
                                                      <input type="text"  value="{{@$invoice->invoice_title}}"  name="invoice_title" class="form-control form-control-sm" readonly/>
                                                  </div>
                                                </div>
                                                <div class="col-md-3">
                                                  <div class="form-group">
                                                    <label for=""><span class="text-danger">*</span>{{__('Customer Username')}} </label>
                                                    <input type="text" value="{{@$invoice->contact->username}}" class="form-control form-control-sm" readonly>
                                                  </div>
                                                </div>
                              
                                                <div class="col-md-3">
                                                  <div class="form-group">
                                                    <label for=""><span class="text-danger">*</span> {{__('Sales Agent')}}</label>
                                                    <input type="text" value="{{@$invoice->user->name}}" class="form-control form-control-sm" readonly>
                                                  </div>
                                                </div>
                              
                                            </div>
                              
                                            <div class="row">
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Invoice Date')}} </label>
                                                  <input type="date" value="{{@$invoice->invoice_date}}" name="invoice_date" class="form-control form-control-sm" readonly/>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Due Date')}} </label>
                                                  <input type="date" value="{{@$invoice->due_date}}" name="due_date" class="form-control form-control-sm" readonly/>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Status')}} </label>
                                                  <select name="status" class="form-control form-control-sm" readonly>
                                                    @php
                                                      $statusess = ['draft', 'sent', 'open', 'revised', 'declined'];
                                                    @endphp
                                                    @foreach ($statusess as $status)
                                                        @if (@$invoice->status == $status)
                                                          <option value="{{$status}}" selected>{{$status}}</option>
                                                        @endif
                                                    @endforeach
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Currency')}} </label>
                                                  <input type="text" value="{{@$invoice->currency->name}}"  class="form-control form-control-sm" readonly>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Amount Due')}} </label>
                                                  <input type="number" name="amount_due" value="{{@$invoice->amount_due}}" step="0.01" class="form-control form-control-sm" readonly/>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Amount Paid')}} </label>
                                                  <input type="number" name="amount_paid" value="{{@$invoice->amount_paid}}" step="0.01" class="form-control form-control-sm" readonly/>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Shipping Charges(if any)')}} </label>
                                                  <input type="number" name="shipping_charges" value="{{@$invoice->shipping_charges}}" step="0.01" class="form-control form-control-sm" readonly/>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label for="">{{__('Mail To')}}</label>
                                                  <input type="text" name="mail_to" value="{{@$invoice->mail_to}}" class="form-control form-control-sm" readonly>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="">{{__('Terms and Conditions')}} </label>
                                                  <textarea name="termsandconditions" class="form-control form-control-sm" rows="5" readonly>{{@$invoice->termsandconditions}}</textarea>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="">{{__('Customer Notes')}} </label>
                                                  <textarea name="customer_notes" class="form-control form-control-sm" rows="5" readonly>{{@$invoice->customer_notes}}</textarea>
                                                </div>
                                              </div>
                                            </div>
                                              <div class="row">
                                                <div class="col-md-12">
                                                  <table class="table">
                                                    <thead>
                                                      <th>#</th>
                                                      <th>{{__('Product')}}</th>
                                                      <th>{{__('Price')}}</th>
                                                      <th>{{__('Qty')}}</th>
                                                      <th>{{__('Tax')}}</th>
                                                      <th>{{__('Amount')}}</th>
                                                      <th>{{__('Created At')}}</th>
                                                    </thead>
                                                    <tbody>
                                                      @foreach(@$invoice->invoiceProducts as $product)
                                                      <tr>
                                                        <td>{{@$product->id}}</td>
                                                        <td>{{@$product->product_name}}</td>
                                                        <td>{{@$invoice->currency->symbol}} {{@$product->product_price}}</td>
                                                        <td>{{@$product->product_qty}}</td>
                                                        <td>{{@$product->product_tax}} %</td>
                                                        <td>{{@$invoice->currency->symbol}} {{@$product->product_amount}}</td>
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
                                                        <td>{{__('Sub Total')}}</td>
                                                        <td>{{@$invoice->currency->symbol}} {{@$invoice->sub_total}}</td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>{{__('Discount')}}</td>
                                                        <td>{{@$invoice->total_discount_percentage}}%</td>
                                                        <td>{{@$invoice->currency->symbol}} {{@$invoice->discount_total}}</td>
                                                        <td>{{@$invoice->discount_type}}</td>
                                                      </tr>
                                                      <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>{{__('Adjustments')}}</td>
                                                        <td>{{@$invoice->currency->symbol}} {{@$invoice->adjustments}}</td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td colspan="4" class="font-bold">{{__('Total Amount = Sub Total - Discount + Adjustments')}} </td>
                                                        <td>{{__('Total Amount')}}</td>
                                                        <td>{{@$invoice->currency->symbol}} {{@$invoice->total_amount}}</td>
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
        
                                      {{-- View invoice Modal Ends --}}
        
                                      </td>
                                      
                                      <td>{{@$invoice->due_date}}</td>
                                      <td>
                                          <span class="badge badge-success">{{@$invoice->relation}}</span>
                                            {{@$invoice->contact->username}} | {{@$invoice->contact->email}}
                                      </td>
                                      <td>{{@$invoice->invoice_date}}</td>
                                      <td>{{@$invoice->status}}</td>
                                      <td>{{@$invoice->currency->symbol}} {{@$invoice->amount_paid}}</td>
                                      <td>{{@$invoice->currency->symbol}} {{@$invoice->amount_due}}</td>
                                      <td>{{@$invoice->currency->symbol}} {{@$invoice->total_amount}}</td>
                                      <td>{{@$invoice->user->name}}</td>
                                        <td>
                                          <span>
                                            @can('update-contact', User::class)
                                              <a class="text-primary pr-2" href="{{url('/invoice/edit', $invoice)}}">
                                                <i class="fas fa-edit"></i>
                                              </a>
                                            @endcan
                                            @can('delete-contact', User::class)
                                            <span id="delbtn{{@$invoice->id}}"></span>
                                              <form id="delete-contact-{{$invoice->id}}"
                                                  action="{{ url('invoice/destroy', $invoice) }}"
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
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>


{{-- ANCHOR MODAL VIEW invoice --}}


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>

{{-- MODAL VIEW invoice ENDS --}}

{{-- SECTION Add Currency modal Starts Here --}}
<div class="modal fade" id="addinvoice" tabindex="-1" role="dialog" aria-labelledby="addinvoiceLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addinvoiceLabel">{{__('Add invoice')}}</h5>
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
@include('crm.customer.invoice_js')
@endsection
