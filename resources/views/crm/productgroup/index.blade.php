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
    <section class="content">
      <div class="container-fluid">


        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-gray">
                  <h3 class="card-title">{{__('Manage Product Groups')}}</h3>
                  <a type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addProductGroup">{{__('New Product Group')}} </a>
                 
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  {{-- NOTE Show All Errors Here --}}
                  @include('crm.layouts.error')
                  <table id="productsTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Group Name')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$productGroups as $productGroup)
                            <tr>
                              <td>{{@$productGroup->id}}</td>
                              <td>{{@$productGroup->name}}</td>
            
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$productGroup->created_at->toDayDateTimeString()}}" class="mr-2">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$productGroup->updated_at->toDayDateTimeString()}}" class="mr-2">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    @can('update-product', User::class)
                                      <a href="#" class="text-primary mr-3" data-toggle="modal" data-target="#editGroup{{@$productGroup->id}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                          {{-- SECTION Add Currency modal Starts Here --}}
                            <div class="modal fade" id="editGroup{{@$productGroup->id}}" tabindex="-1" role="dialog" aria-labelledby="editProductGroupLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content bg-light-gray">
                                  <div class="modal-header bg-gray">
                                    <h5 class="modal-title" id="editProductGroupLabel">{{__('Update Product Group')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{url('product/productgroup', $productGroup)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                          <label for="">{{__('Product Group Name')}}</label>
                                          <input type="text" name="name" class="form-control" value="{{@$productGroup->name}}" data-validation="length" data-validation-length="2-50" required>
                                        </div>
                                        
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                        <button type="submit" class="btn btn-info">{{__('Update')}}</button>
                                      </div>
                                    </form>
                                </div>
                              </div>
                            </div>
                            {{-- !SECTION ADD Currency modal ends here --}}
                                    @endcan
                                    
                                    @can('delete-product', User::class)

                                    <span id="delbtn{{@$productGroup->id}}"></span>
                                    
                                      <form id="delete-productgroup-{{@$productGroup->id}}"
                                          action="{{ url('product/productgroup/destroy', $productGroup->id) }}"
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


{{-- SECTION Add Currency modal Starts Here --}}
<div class="modal fade" id="addProductGroup" tabindex="-1" role="dialog" aria-labelledby="addProductGroupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content  bg-light-gray">
        <div class="modal-header  bg-gray">
          <h5 class="modal-title" id="addProductGroupLabel">{{__('Add Product Group')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('product/productgroup/store')}}" method="POST">
              @csrf
              <div class="form-group">
                <label for="">{{__('Product Group Name')}}</label>
                <input type="text" name="name" class="form-control" data-validation="length" data-validation-length="2-50" required>
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

@include('crm.productgroup.index_js')
@endsection



