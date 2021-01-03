@extends('crm.layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('proposal/update', $proposal)}}>
          @csrf
          @method('PUT')
        <div class="card card-default card-tabs">
          <div class="card-header bg-gray">{{__('Edit proposal')}}</div>
          <div class="card-body bg-light-gray">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for=""><span class="text-danger">*</span> {{__('Subject')}} </label>
                          <input type="text" name="subject" class="form-control form-control-sm" value="{{@$proposal->subject}}" data-validation="length" data-validation-length="2-150" required/>
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for=""><span class="text-danger">*</span> {{__('Customer/Lead')}} </label>
                      <select name="relation" id="relation" class="form-control form-control-sm" required>
                        <option selected disabled>{{__('Select User Type')}}</option>
                        @php
                            $relations= ['Customer', 'Lead'];
                        @endphp
                        @foreach ($relations as $relation)
                          @if ($proposal->relation == $relation)
                            <option value="{{$relation}}" selected>{{$relation}}</option>
                          @else 
                            <option value="{{$relation}}">{{$relation}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for=""><span class="text-danger">*</span>{{__('Select Lead/Customer')}} </label>
                      <select name="lead_customer_id" id="lead_customer_id" class="form-control form-control-sm" required>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Proposal Date')}} </label>
                      <input type="date" name="proposal_date" value="{{@$proposal->proposal_date}}" class="form-control form-control-sm"/>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Proposal Expiry Date')}} </label>
                      <input type="date" name="open_till_date" value="{{@$proposal->open_till_date}}" class="form-control form-control-sm"/>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="">{{__('Status')}} </label>
                      <select name="status" class="form-control form-control-sm">
                        @php
                          $statusess = [
                            __('draft'), 
                            __('sent'), 
                            __('open'), 
                            __('revised'), 
                            __('declined'), 
                            __('accepted')
                          ];
                        @endphp
                        @foreach ($statusess as $status)
                        @if ($proposal->status == $status)
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
                          @if (@$proposal->currency_id == $currency->id)
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

           
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for=""><span class="text-danger">*</span> {{__('Sales Agent')}}</label>
                      <select name="assigned_to" class="form-control form-control-sm" required>
                        @foreach ($users as $user)
                          @if (@$proposal->assigned_to == $user->id)
                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                          @else
                            <option value="{{$user->id}}">{{$user->name}}</option>
                          @endif
                            
                        @endforeach
                      </select>
                    </div>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label for="">{{__('Message')}} </label>
                  <textarea name="message" class="form-control form-control-sm" rows="5">{{@$proposal->message}}</textarea>
                </div>
                
              </div>
            </div>
          </div>
        </div>

        <div class="card card-secondary">
          <div class="card-header">Products</div>
          <div class="card-body bg-light-gray">
            <div class="row">
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
              <table id="proposal_products" class="table">
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
                    <td colspan="2"><label for="" class="float-right pt-2">{{__('Sub-Total')}}</label></td>
                    <td colspan="1"><input type="number" name="sub_total" class="form-control form-control-sm" id="priceTotalWithTax" step="0.02" placeholder="0" readonly /></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><label for="" class="float-right pt-2">Discount(%)</label></td>
                    <td>
                      <select name="discount_type" id="discount_type" class="form-control form-control-sm">
                        @php
                          $discount_types = [
                            __('Before Tax'), 
                            __('After Tax')
                          ];
                        @endphp
                        @foreach ($discount_types as $type)
                            @if ($proposal->discount_type == $type)
                              <option value="{{$type}}" selected>{{$type}}</option>
                            @else
                              <option value="{{$type}}">{{$type}}</option>
                            @endif
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <div class="input-group">
                        <input type="number" name="total_discount_percentage" class="form-control form-control-sm" id="getDiscountTotal" step="0.01" value="{{@$proposal->total_discount_percentage}}" min="0" required/>
                        <span class="input-group-append">
                          <button class="input-group-text btn-sm" type="button" id="inputGroup-sizing-sm">%</button>
                        </span>
                      </div>
                    
                    </td>
                    <td>
                      <div class="input-group">
                        <input type="number" name="discountTotal" class="form-control form-control-sm" id="discountTotal" step="0.02" placeholder="0" value="{{@$proposal->discountTotal}}" readonly/>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2"><label for=""  class="float-right pt-2 text-danger ">{{__('Adjustments')}}</label></td>
                    <td><input type="number" name="adjustments" id="adjustments" value="{{@$proposal->adjustments}}" class="form-control form-control-sm" step="0.01" required/></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2"><label for="Total Amount" class="float-right pt-2">{{__('Total Amount')}}</label></td>
                    <td><input type="number" name="totalAmount" class="form-control form-control-sm" id="totalAmount" step="0.02" placeholder="0" value="{{@$proposal->totalAmount}}" readonly/></td>
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
                            {{__('Update proposal')}}
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

@include('crm.proposal.edit_js')
  
@endsection