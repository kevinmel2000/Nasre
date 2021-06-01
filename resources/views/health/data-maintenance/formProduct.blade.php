@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">

        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')
        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 com-sm-12 mt-3">
                        <button class="btn btn-primary">
                            {{__('Halaman Utama')}}
                        </button>
                        <button href="{{url('/data-maintenance/formProduct')}}" class="btn btn-primary">
                            {{__('Tambah Produk Coverage Baru')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action={{url('health/product/store')}}>
          @csrf
        <div class="card">
          <div class="card-header bg-gray">
            {{__('Form Product')}}
          </div>

          <div class="card-body bg-light-white ">
            <div class="tab-content">
                <table width="100%">
                    <tr>
                        <td>Kode Produk</td>
                        <td>
                            <div class="form-group col-md-12">
                            <input type="text" name="productcode" style="width: 80%;" class="form-control form-control-sm" data-validation="length" data-validation-length="3" disabled/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Produk (E)</td>
                        <td>
                            <div class="form-group col-md-12">
                                <input type="text" name="productcode" style="width: 80%;" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
                            </div>
                        </td>
                        <td>Nama Produk (I)</td>
                        <td>
                            <div class="form-group col-md-12">
                                <input type="text" name="productcode" style="width: 80%;" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Keterangan Produk (E)</td>
                        <td>
                            <div class="form-group col-md-12">
                                <input type="text" name="productcode" style="width: 80%;" class="form-control form-control-sm" required/>
                            </div>
                        </td>
                        <td>Keterangan Produk (I)</td>
                        <td>
                            <div class="form-group col-md-12">
                                <input type="text" name="productcode" style="width: 80%;" class="form-control form-control-sm"  required/>
                            </div>
                        </td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td style="color:rgb(196, 130, 55); font-size: 20px;"><h3>Reimbursement</h3><br></td>
                    </tr>

                    <tr>
                        <td>Reimbursement</td>
                        <td>
                            <div class="form-group col-md-12">
                                <input type="text" name="productcode" style="width: 80%;" class="form-control form-control-sm"  required/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>IL Applicable</td>
                        <td>
                            <div class="form-group col-md-12">
                                <input type="checkbox" name="productcode"/>
                                <label for="">{{__('Ya')}} </label>
                            </div>
                        </td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td style="color:rgb(196, 130, 55); font-size: 20px;"><h3>Inner Limt (IL)</h3><br></td>
                    </tr>
                    <tr>
                        <td>Allowed 0 to IL</td>
                        <td>
                            <div class="form-group col-md-12">
                                <input type="checkbox" name="productcode"/>
                                <label for="">{{__('Ya')}} </label>
                            </div>
                        </td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td style="color:rgb(196, 130, 55); font-size: 20px;"><h3>Overall Limt (OL)</h3><br></td>
                    </tr>
                    <tr>
                        <td>Max Age</td>
                        <td>
                            <div class="form-group col-md-12">
                                <input type="text" name="productcode" style="width: 50%;" class="form-control form-control-sm"  required/>
                            </div>
                        </td>
                        <td>Max Age Renew</td>
                        <td>
                            <div class="form-group col-md-12">
                                <input type="text" name="productcode" style="width: 50%;" class="form-control form-control-sm"  required/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Age Band</td>
                        <td>
                            <div class="form-group col-md-12">
                                <select class="form-control" style="width: 80%;" aria-label="1 -10">
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                  <option value="6">6</option>
                                  <option value="7">7</option>
                                  <option value="8">8</option>
                                  <option value="9">9</option>
                                  <option value="10">10</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>
              {{-- <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                        <label for="">{{__('Kode Produk')}} </label>
                      <div class="form-group col-md-12">
                          <input type="text" name="productcode" style="width: 25%;" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Country Name')}}</label>
                          <input type="text" name="countryname" class="form-control form-control-sm " data-validation="length" data-validation-length="0-150" />
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Continent')}}</label>
                          <select name="continent" class="form-control form-control-sm e1">
                              <option selected disabled>{{__('Select Continent')}}</option>
                              <option value="AF">Africa</option>
                              <option value="AN">Antartica</option>
                              <option value="AS">Asia</option>
                              <option value="EU">Europa</option>
                              <option value="NA">North America </option>
                              <option value="OC">Oceania</option>
                              <option value="SA">South America</option>
                          </select>
                      </div>
                    </div>
                </div>

              </div> --}}
            </div>
          </div>
        </div>
        <div class="card card-primary">
            <div class="card-body">
                <div class="align-items-right">
                    <button href="{{url('/data-maintenance/formProduct')}}" class="btn btn-primary" style="float: right; margin: 10px;">
                        {{__('Simpan')}}
                    </button>
                    <button class="btn btn-danger" style="float: right; margin: 10px;">
                        {{__('Tutup')}}
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class="card card-primary">
        <div class="card-body">
            <div class="card-header bg-gray">
                {{__('Cedding Map')}}
            </div>
            <div class="row">
                <button href="{{url('/data-maintenance/formProduct')}}" class="btn btn-primary" style="margin: 10px;">
                    {{__('Tambah')}}
                </button>
                <div class="col-md-12 com-sm-12 mt-3">
                  <div class="table-responsive">
                    <table id="countryTable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{__('Mapping ID')}}</th>
                        <th>{{__('Kode Cedding')}}</th>
                        <th>{{__('Cedding Name')}}</th>
                        <th width="20%">{{__('Actions')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>

                    </table>
                  </div>
                </div>

            </div>
        </div>
    </div>

  </div>
  </div>
@endsection

@section('scripts')
{{-- @include('health.data-maintenance.product_js') --}}
@endsection
