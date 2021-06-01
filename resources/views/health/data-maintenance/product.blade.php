@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">

        {{-- NOTE Show All Errors Here --}}
        @include('crm.layouts.error')

        {{-- <form method="POST" action={{url('health/product/store')}}>
          @csrf --}}
        <div class="card">
          <div class="card-header bg-gray">
            {{__('New Product Data')}}
          </div>

          {{-- <div class="card-body bg-light-gray ">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="lead-details-id" role="tabpanel" aria-labelledby="lead-details">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">{{__('Enter Code')}} </label>
                          <input type="text" name="countrycode" style="width: 25%;" class="form-control form-control-sm" data-validation="length" data-validation-length="3" required/>
                        </div>
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

              </div>
            </div>
          </div> --}}
        </div>

        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 com-sm-12 mt-3">
                        <button class="btn btn-primary">
                            {{__('Halaman Utama')}}
                        </button>
                        <a href="{{url('/data-maintenance/formProduct')}}">
                            <button class="btn btn-primary">
                                {{__('Tambah Produk Coverage Baru')}}
                            </button>
                        </a>
                    </div>
                    {{-- <div class="col-md-12 com-sm-12 mt-3">
                        <button class="btn btn-primary">
                            {{__('Tambah Produk Coverage Baru')}}
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>


    {{-- </form> --}}

    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 com-sm-12 mt-3">
                  <div class="table-responsive">
                    <table id="countryTable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{__('Kode Produk')}}</th>
                        <th>{{__('Nama Produk')}}</th>
                        <th>{{__('Deskripsi')}}</th>
                        <th>{{__('COB')}}</th>
                        <th>{{__('Inner Limit')}}</th>
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
