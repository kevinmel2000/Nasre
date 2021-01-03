@extends('crm.layouts.app')

@section('content')
  <div class="content-wrapper">
  
      <div class="container-fluid">
         
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('invoice/store')}}>
          @csrf
        <div class="card ">
          <div class="card-header bg-gray">
            {{__('New Invoice')}}
          </div>
          
          <div class="card-body bg-light-gray">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for=""><span class="text-danger">*</span> {{__('Invoice Number')}} </label>
                          <input type="text" name="invoice_number" class="form-control form-control-sm" required/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for=""><span class="text-danger">*</span> {{__('Invoice Title')}} </label>
                          <input type="text" name="invoice_title" class="form-control form-control-sm" required/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for=""><span class="text-danger">*</span>{{__('Select Customer')}} </label>
                        <select name="customer_id" id="customer_id" class="form-control form-control-sm" required>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for=""><span class="text-danger">*</span> {{__('Sales Agent (Invoice Owner)')}}</label>
                        <select name="invoice_owner_id" class="form-control form-control-sm" required>
                          @foreach ($salesperson as $user)
                              <option value="{{$user->id}}">{{$user->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Invoice Date')}} </label>
                      <input type="date" name="invoice_date" class="form-control form-control-sm"/>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Due Date')}} </label>
                      <input type="date" name="due_date" class="form-control form-control-sm"/>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Status')}} </label>
                      <select name="status" class="form-control form-control-sm">
                        @php
                          $statusess = ['draft', 'sent', 'open', 'revised', 'declined'];
                        @endphp
                        @foreach ($statusess as $status)
                            <option value="{{$status}}">{{$status}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Currency')}} </label>
                      <select name="currency_id" class="form-control form-control-sm">
                        @foreach ($currencies as $currency)
                            <option value="{{@$currency->id}}"
                              @if (@$currency->is_base_currency == 'yes')
                                  selected
                              @endif
                              >
                              {{@$currency->name}}
                              @if (@$currency->is_base_currency == 'yes')
                                  - {{__('Base Currency')}}
                              @endif
                            </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Amount Due')}} </label>
                      <input type="number" id="amount_due" name="amount_due" value="0" step="0.01" class="form-control form-control-sm"/>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Amount Paid')}} </label>
                      <input type="number" name="amount_paid" value="0" step="0.01" class="form-control form-control-sm"/>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Shipping Charges(if any)')}} </label>
                      <input type="number" name="shipping_charges" value="0" step="0.01" class="form-control form-control-sm"/>
                    </div>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">{{__('Terms and Conditions')}} </label>
                      <textarea name="termsandconditions" class="form-control form-control-sm" rows="5">{{@$terms->field_value}}</textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">{{__('Customer Notes')}} </label>
                      <textarea name="customer_notes" class="form-control form-control-sm" rows="5"></textarea>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header bg-gray">{{__('Products')}}</div>
          <div class="card-body bg-light-gray">
            <div class="row mb-2">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <span class="pr-2 text-bold">{{__('Select Product from list')}}</span>
                          <select id="product_id" class="form-control form-control-sm">
                            <option disabled selected> {{__('Select Product')}}</option>
                            @foreach ($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <span class="text-danger"> * </span> {{__('Product Name')}}
                          <input type="text" class="form-control form-control-sm" id='product_name'>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <span class="text-danger"> * </span> {{__('Price')}}
                          <input type="number" class="form-control form-control-sm" step="0.02"  id="product_price" placeholder="Price">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <span class="text-danger"> * </span> {{__('Quantity')}}
                          <input type="number" class="form-control form-control-sm" placeholder="Qty" id="product_qty">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <span>{{__('Tax')}}(%)</span>
                          <input type="number" class="form-control form-control-sm" step="0.02" id="product_tax" placeholder="Tax" value="0">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <span>{{__('Total Amount')}}</span>
                        <div class="input-group">
                          <input type="number" class="form-control form-control-sm" placeholder="Amount" id="product_amount" step="0.02" readonly />
                          <span class="input-group-append">
                            <button type="button" id="add_product" class="btn btn-success">
                              <i class="fas fa-plus"></i>
                            </button>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            
            </div>
            <div class="row">

              <table id="invoice_products" class="table">
                <thead>
                  <th><span class="text-danger"> * </span> {{__('Product Name')}}</th>
                  <th><span class="text-danger"> * </span> {{__('Price')}}</th>
                  <th><span class="text-danger"> * </span> {{__('Quantity')}}</th>
                  <th>{{__('Tax')}}(%)</th>
                  <th>{{__('Amount')}}</th>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2"><label for="" class="float-right pt-2">{{__('SubTotal')}}</label></td>
                    <td colspan="1"><input type="number" name="sub_total" class="form-control form-control-sm" id="priceTotalWithTax" step="0.02" placeholder="0" readonly /></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><label for="" class="float-right pt-2">{{__('Discount')}}(%)</label></td>
                    <td>
                      
                      <select name="discount_type" id="discount_type" class="form-control form-control-sm">
                        @php
                          $discount_types = ['Before Tax', 'After Tax'];
                        @endphp
                        @foreach ($discount_types as $type)
                            <option value="{{$type}}">{{$type}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <div class="input-group">
                        <input type="number" name="discount_percentage" class="form-control form-control-sm" id="getDiscountTotal"  step="0.01" value="0" min="0" required/>
                        <span class="input-group-append">
                          <button class="input-group-text btn-sm" type="button" id="inputGroup-sizing-sm">%</button>
                        </span>
                      </div>
                    
                    </td>
                    <td>
                      <div class="input-group">
                        <input type="number" name="discount_total" class="form-control form-control-sm" id="discountTotal" step="0.02" placeholder="0" readonly/>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2"><label for="" class="float-right pt-2 text-danger">{{__('Adjustments')}}</label></td>
                    <td><input type="number" name="adjustments" id="adjustments" value="0" class="form-control form-control-sm" step="0.01" required/></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2"><label for="Total Amount" class="float-right pt-2">{{__('Total Amount')}}</label></td>
                    <td><input type="number" name="total_amount" class="form-control form-control-sm" id="totalAmount" step="0.02" placeholder="0" readonly/></td>
                  </tr>
                </tbody>
              </table>
              
            </div>
          </div>
        </div>

        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 com-sm-12 mt-3">
                        <button class="btn btn-primary btn-block ">
                            {{__('Save Invoice')}}
                        </button>
                    </div>
                    <div class="col-md-6 com-sm-12 mt-3">
                      <input type="submit" name="send_email" value="Save & Send Email" class="btn btn-primary btn-block">
                    </div>
                </div>
            </div>
        </div>   
    </form>
  </div>
  </div>

@endsection


@section('scripts')

@include('crm.invoice.create_js')
  
@endsection