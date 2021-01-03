@extends('crm.layouts.app')
@section('content')
  <div class="content-wrapper">
      <div class="container-fluid">
         
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('estimate/update', $estimate)}}>
          @csrf
          @method('PUT')
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Edit Estimate')}}
          </div>
          
          <div class="card-body bg-light-gray">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for=""><span class="text-danger">*</span> {{__('Estimate Number')}} </label>
                        <input type="text"  value="{{@$estimate->estimate_number}}"  name="estimate_number" class="form-control form-control-sm" required/>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for=""><span class="text-danger">*</span> {{__('Estimate Title')}} </label>
                        <input type="text"  value="{{@$estimate->estimate_title}}"  name="estimate_title" class="form-control form-control-sm" required/>
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
                      <label for=""><span class="text-danger">*</span> {{__('Sales Agent (estimate Owner)')}}</label>
                      <select name="estimate_owner_id" class="form-control form-control-sm" required>
                        @foreach ($salesperson as $user)
                          @if (@$estimate->assigned_to == $user->id)
                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                          @else
                            <option value="{{$user->id}}">{{$user->name}}</option>
                          @endif
                            
                        @endforeach
                      </select>
                    </div>
                  </div>

              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">{{__('Estimate Date')}} </label>
                    <input type="date" value="{{@$estimate->estimate_date}}" name="estimate_date" class="form-control form-control-sm"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">{{__('Due Date')}} </label>
                    <input type="date" value="{{@$estimate->due_date}}" name="due_date" class="form-control form-control-sm"/>
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
                          @if (@$estimate->status == $status)
                            <option value="{{$status}}" selected>{{$status}}</option>
                          @else
                            <option value="{{$status}}">{{$status}}</option>
                          @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">{{__('Currency')}} </label>
                    <select name="currency_id" class="form-control form-control-sm">
                      <option selected disabled>{{__('Select currency')}}</option>
                      @foreach ($currencies as $currency)
                        @if ($estimate->currency_id == $currency->id)
                        <option value="{{@$currency->id}}" selected>
                          {{@$currency->name}}
                          @if (@$currency->is_base_currency == 'yes')
                              - {{__('Base Currency')}}
                          @endif
                        </option>
                        @else
                        <option value="{{@$currency->id}}">
                          {{@$currency->name}}
                          @if (@$currency->is_base_currency == 'yes')
                              - {{__('Base Currency')}}
                          @endif
                        </option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">{{__('Shipping Charges(if any)')}} </label>
                    <input type="number" name="shipping_charges" value="{{@$estimate->shipping_charges}}" step="0.01" class="form-control form-control-sm"/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">{{__('Terms and Conditions')}} </label>
                    <textarea name="termsandconditions" class="form-control form-control-sm" rows="5">{{@$estimate->termsandconditions}}</textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">{{__('Customer Notes')}} </label>
                    <textarea name="customer_notes" class="form-control form-control-sm" rows="5">{{@$estimate->customer_notes}}</textarea>
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
              <table id="estimate_products" class="table">
                <thead>
                  <th><label for=""><span class="text-danger"> * </span> {{__('Product Name')}}</label></th>
                  <th><label for=""><span class="text-danger"> * </span> {{__('Price')}}</label></th>
                  <th><label for=""><span class="text-danger"> * </span> {{__('Quantity')}}</label></th>
                  <th><label for="">{{__('Tax')}}(%)</label></th>
                  <th><label for="">{{__('Amount')}}</label></th>
                </thead>
                <tbody>
                  {{-- <hr> --}}
                  <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2"><hr><label for="" class="float-right pt-2">{{__('SubTotal')}}</label></td>
                    <td colspan="1"><hr><input type="number" name="sub_total" class="form-control form-control-sm" id="priceTotalWithTax" step="0.02" placeholder="0" readonly /></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><hr><label for="" class="float-right pt-2">{{__('Discount')}}(%)</label></td>
                    <td>
                      <hr>
                      <select name="discount_type" id="discount_type" class="form-control form-control-sm">
                        @php
                          $discount_types = ['Before Tax', 'After Tax'];
                        @endphp
                        @foreach ($discount_types as $type)
                            @if ($estimate->discount_type == $type)
                              <option value="{{$type}}" selected>{{$type}}</option>
                            @else
                              <option value="{{$type}}">{{$type}}</option>
                            @endif
                        @endforeach
                      </select>
                    </td>
                    <td><hr>
                      <div class="input-group">
                        <input type="number" name="discount_percentage" class="form-control form-control-sm" id="getDiscountTotal" step="0.01" value="{{@$estimate->discount_percentage}}" min="0" required/>
                        <span class="input-group-append">
                          <button class="input-group-text btn-sm" type="button" id="inputGroup-sizing-sm">%</button>
                        </span>
                      </div>
                    
                    </td>
                    <td><hr>
                      <div class="input-group">
                        <input type="number" name="discount_total" class="form-control form-control-sm" id="discount_total" step="0.02" placeholder="0" value="{{@$estimate->discount_total}}" readonly/>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2"><hr><label for="" class="float-right pt-2 text-danger">{{__('Adjustments')}}</label></td>
                    <td><hr><input type="number" name="adjustments" id="adjustments" value="{{@$estimate->adjustments}}" class="form-control form-control-sm" step="0.01" required/></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2"><hr><label for="Total Amount" class="float-right pt-2">{{__('Total Amount')}}</label></td>
                    <td><hr><input type="number" name="total_amount" class="form-control form-control-sm" id="total_amount" step="0.02" placeholder="0" value="{{@$estimate->total_amount}}" readonly/></td>
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
                            {{__('Update estimate')}}
                        </button>
                    </div>
                   
                </div>
            </div>
        </div>   
    </form>
  </div>
    <!-- /.content -->
  </div>

@endsection


@section('scripts')

@include('crm.estimate.edit_js')
  
@endsection