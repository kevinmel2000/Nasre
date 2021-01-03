@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('crm.layouts.breadcrumb')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">

            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Bulk Import Products')}}</h3>
                    <a type="button" class="btn btn-sm btn-info float-right mr-2" href="{{url('/product')}}">
                      <i class="fas fa-arrow-circle-left mr-1"></i>
                      {{__('Go Back ')}}
                    </a>
                </div>
                <div class="card-body">
                  
                  <p class="font14 textLeft">
                    <strong>{{__("Instructions: ")}}</strong> <br/>
                    {{__("1. First line would be the heading of all the fields, don't change field's name in the heading.")}} <br/>
                    {{__("2. sku field is unique.")}} <br/>
                    {{__("2. name field is required.")}} <br/>
                    {{__("4. Status can be active/inactive")}} <br/>
                    {{__("5. Put tax rate ids in these fields, tax_type_1, tax_type_2, tax_type_3. Visit tax rates page for tax rate ids !")}} <br/>
                    {{__("6. Similarly, get product_group_id from the product groups page.")}} <br/>
                    {{__("7. created_by_id is the id of the staff, who is creating this import, although you can choose id of your choice.")}} <br/>
                    <a href="{{url('/public_files/sample_products.xlsx')}}" target="_blank">{{__('Sample Excel File')}}</a>
                  </p>
                  @if($errors)
                    <table class="table table-danger">
                      @foreach ($errors->all() as $error)
                          <tr>
                            <td>{{ $error }}</td>
                          </tr>
                      @endforeach
                    </table>
                  @endif
                  @if(Session::has('message'))
                    <div class="alert alert-{{session('alert-type')}}" role="alert">
                      {{ session('message') }}
                    </div>
                  @endif
                  
                  <div class="table-responsive">
                    <label for="">{{__('Dummy Content and Order of the Excel Data')}}</label>
                    <table class="table table-bordered text-nowrap">
                      <thead>
                        <tr>
                          <th>{{__('name')}} <span class="text-danger">*</span> </th>
                          <th>{{__('short_description')}} </th>
                          <th>{{__('long_description')}} </th>
                          <th>{{__('price')}} </th>
                          <th>{{__('sku')}}</th>
                          <th>{{__('discount')}} </th>
                          <th>{{__('units')}} </th>
                          <th>{{__('tax_type_1')}} </th>
                          <th>{{__('tax_type_2')}} </th>
                          <th>{{__('tax_type_3')}} </th>
                          <th>{{__('product_group_id')}} </th>
                          <th>{{__('status')}} </th>
                          <th>{{__('created_by_id')}} </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>{{__('Product Name')}}</td>
                          <td>{{__('lorem ipsum')}}</td>
                          <td>{{__('lorem ipsum')}}</td>
                          <td>{{__('999')}}</td>
                          <td>{{__('DEV9797')}}</td>
                          <td>{{__('16')}}</td>
                          <td>{{__('4')}}</td>
                          <td>{{__('1')}}</td>
                          <td>{{__('2')}}</td>
                          <td>{{__('3')}}</td>
                          <td>{{__('3')}}</td>
                          <td>{{__('active')}}</td>
                          <td>{{__('1')}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <form action="{{url('product/import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="">{{__('Select an excel file(xlsx format)')}}</label>
                      <br>
                      <input type="file" name="file">
                    </div>
                    <input type="submit" value="Upload" class="btn btn-info">
                  </form>
                </div>
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection



