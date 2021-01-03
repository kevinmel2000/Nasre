@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Manage Products')}}</h3>
                  
                  <a type="button" class="btn btn-sm btn-primary float-right" href="{{url('product/create')}}">{{__('New Product')}} </a>
                  <a type="button" class="btn btn-sm btn-info float-right mr-2" href="{{url('product/import')}}">
                    <i class="fas fa-cloud-upload-alt mr-1"></i>
                    {{__('Import Bulk Products ')}}
                  </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="productsTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('SKU')}}</th>
                      <th>{{__('Name')}}</th>
                      <th>{{__('Price')}} ({{__('in')}} {{@$base_currency->name}})</th>
                      <th>{{__('Discount')}} ({{__('in')}} {{@$base_currency->name}})</th>
                      <th>{{__('Units')}}</th>
                      <th>{{__('Group')}}</th>
                      <th width="20%">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$products as $product)
                            <tr>
                              <td>{{@$product->id}}</td>
                              <td>{{@$product->sku}}</td>
                              <td>{{@$product->name}}</td>
                              <td>{{@$product->price}}</td>
                              <td>{{@$product->discount}}</td>
                              <td>{{@$product->units}}</td>
                              <td>{{@$product->productgroup->name}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$product->created_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$product->updated_at->toDayDateTimeString()}}" class="mr-3">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    @can('update-product', User::class)
                                      <a class="text-primary mr-3" href="{{url('/product/edit', $product)}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    @endcan
  
                                    @can('delete-product', User::class)

                                    <span id="delbtn{{@$product->id}}"></span>
                                  
                                      <form id="delete-product-{{$product->id}}"
                                          action="{{ url('product/destroy', $product) }}"
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
    </section>
  </div>

@endsection

@section('scripts')
@include('crm.product.index_js')
@endsection



