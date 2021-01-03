@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
      <div class="container-fluid">
         
        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        
        <form method="POST" action={{url('product/update', $product)}}>
          @csrf
          @method('PUT')
        <div class="card  card-tabs">
          <div class="card-header  bg-gray p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
              <li class="px-3"><h3 class="card-title">{{@$product->name}}</h3></li>
              
              <li class="ml-auto px-3 float-right"><h3 class="card-title"> <span class="badge badge-info pl-1 pr-1">{{__('Created')}} - {{@$product->created_at->toDayDateTimeString()}} </span></h3></li>
              <li class="px-3 float-right"><h3 class="card-title"><span class="badge badge-primary pl-1 pr-1">{{__('Last')}} {{__('updated')}} - {{@$product->updated_at->toDayDateTimeString()}}</span></h3></li>
            </ul>

          </div>
          
          <div class="card-body bg-light-gray">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                          <label for=""><span class="text-danger">*</span> {{__('Enter Product Name')}} </label>
                          <input type="text" name="name" class="form-control form-control-sm" value="{{@$product->name}}" data-validation="length" data-validation-length="2-50" required/>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="">{{__('Products Group')}} </label>
                          <select name="product_group_id" class="form-control form-control-sm">
                              <option selected disabled> {{__('Select Product Group')}}</option>
                              @if (count($productGroups)> 0)
                                @foreach ($productGroups as $productGroup)
                                  @if (@$product->product_group_id == $productGroup->id)
                                    <option value="{{@$productGroup->id}}" selected>{{@$productGroup->name}}</option>
                                  @else
                                    <option value="{{@$productGroup->id}}">{{@$productGroup->name}}</option>
                                  @endif
                                @endforeach
                              @endif
                          </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="">{{__('SKU (Stock Keeping Unit Number)')}}</label>
                          <input type="text" name="sku" class="form-control form-control-sm" value="{{@$product->sku}}" />
                      </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">{{__('Price')}} </label>
                            <input type="number" name="price" class="form-control form-control-sm"  step="0.02" placeholder="Enter number of units" value="{{@$product->price}}" />
                        </div>
                      </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="">{{__('Discount')}} ({{__('in')}} {{@$base_currency->name}})</label>
                          <input type="number" name="discount" class="form-control form-control-sm" step="0.02" value="{{@$product->discount}}"/>
                      </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">{{__('Units')}} </label>
                            <input type="number" name="units" value="{{@$product->units}}" class="form-control form-control-sm"/>
                        </div>
                      </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="">{{__('Tax Type 1')}}</label>
                          <select name="tax_type_1" class="form-control form-control-sm">
                              <option selected disabled>{{__('Select Tax Type 1')}}</option>
                              @if (count($taxrates) > 0)
                                @foreach ($taxrates as $taxrate)
                                  @if ($product->tax_type_1 == $taxrate->id)
                                    <option value="{{@$taxrate->id}}" selected>{{@$taxrate->name}}</option>
                                  @else
                                    <option value="{{@$taxrate->id}}">{{@$taxrate->name}}</option>
                                  @endif
                                @endforeach
                              @endif
                          </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">{{__('Tax Type 2')}}</label>
                        <select name="tax_type_2" class="form-control form-control-sm">
                            <option selected disabled>{{__('Select Tax Type 2')}}</option>
                            @if (count($taxrates) > 0)
                                @foreach ($taxrates as $taxrate)
                                    @if ($product->tax_type_2 == $taxrate->id)
                                    <option value="{{@$taxrate->id}}" selected>{{@$taxrate->name}}</option>
                                  @else
                                    <option value="{{@$taxrate->id}}">{{@$taxrate->name}}</option>
                                  @endif
                                @endforeach
                              @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">{{__('Tax Type 3')}}</label>
                        <select name="tax_type_3" class="form-control form-control-sm">
                            <option selected disabled>{{__('Select Tax Type 3')}}</option>
                            @if (count($taxrates) > 0)
                                @foreach ($taxrates as $taxrate)
                                    @if ($product->tax_type_3 == $taxrate->id)
                                    <option value="{{@$taxrate->id}}" selected>{{@$taxrate->name}}</option>
                                  @else
                                    <option value="{{@$taxrate->id}}">{{@$taxrate->name}}</option>
                                  @endif
                                @endforeach
                              @endif
                        </select>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <label for="">{{__('Short Description')}} </label>
                  <textarea name="short_description" class="form-control form-control-sm">{{@$product->short_description}}</textarea>
                </div>
                <div class="form-group">
                  <label for="">{{__('Long Description')}} </label>
                  <textarea name="long_description" class="form-control form-control-sm" rows="5">{{@$product->long_description}}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 com-sm-12 mt-3">
                        <button class="btn btn-primary btn-block ">
                            {{__('Update Product')}}
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
