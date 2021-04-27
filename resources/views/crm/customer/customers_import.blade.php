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
                  <h3 class="card-title">{{__('Bulk Import Customers')}}</h3>
                    <a type="button" class="btn btn-sm btn-info float-right mr-2" href="{{url('/customer')}}">
                      <i class="fas fa-arrow-circle-left mr-1"></i>
                      {{__('Go Back ')}}
                    </a>
                </div>
                <div class="card-body">
                  
                  <p class="font14 textLeft">
                    <b>{{__("Instructions: ")}}</b> <br/>
                    {{__("1. First line would be the heading of all the fields, don't change field's name in the heading.")}} <br/>
                    {{__('2.')}} <b>{{__(' username & email ')}}</b>{{__('are unique and required')}} <br/>
                    {{__('3.')}} <b>{{__('password, last_name & title_id')}}</b> {{__("are required.")}} <br/>
                    {{__('4. ')}} <b>{{__('prospect_status')}}</b> {{__(" can be Prospect / Lost-Prospect / Non-Prospect ")}} <br/>
                    {{__('5. ')}} <b>{{__('customer_type')}}</b> {{__(" can be Customer / Past-Customer / Non-Customer. ")}} <br/>
                    <a href="{{url('/public_files/sample_customers.xlsx')}}" target="_blank">{{__('Sample Excel File')}}</a>
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
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Get Language ID</label>
                        <select class="select2 form-control">
                          @foreach ($languages as $lang)
                              <option>{{$lang->id}} - {{$lang->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Get Industry ID</label>
                        <select class="select2 form-control">
                          @foreach ($industries as $industry)
                              <option>{{$industry->id}} - {{$industry->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <label for="">{{__('Dummy Content and Order of the Excel Data')}}</label>
                    <table class="table table-bordered text-nowrap">
                      <thead>
                        <tr>
                          <th>{{__('username')}} <span class="text-danger">*</span> </th>
                          <th>{{__('password')}} <span class="text-danger">*</span></th>
                          <th>{{__('customer_type')}} </th>
                          <th>{{__('prospect_status')}} </th>
                          <th>{{__('owner_id')}} <span class="text-danger">*</span></th>
                          <th>{{__('vat_number')}} </th>
                          <th>{{__('website')}} </th>
                          <th>{{__('industry_id')}} </th>
                          <th>{{__('company_name')}} </th>
                          <th>{{__('title_id')}} <span class="text-danger">*</span></th>
                          <th>{{__('first_name')}} </th>
                          <th>{{__('last_name')}} <span class="text-danger">*</span></th>
                          <th>{{__('email')}} </th>
                          <th>{{__('phone')}} </th>
                          <th>{{__('whatsapp')}} </th>
                          <th>{{__('language_id')}} </th>
                          <th>{{__('decision_maker')}} </th>
                          <th>{{__('personal_id')}} </th>
                          <th>{{__('gender')}} </th>
                          <th>{{__('address_line_1')}} </th>
                          <th>{{__('address_line_2')}} </th>
                          <th>{{__('zip')}} </th>
                   
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>{{__('johndoe')}}</td>
                          <td>{{__('password')}}</td>
                          <td>{{__('Customer')}}</td>
                          <td>{{__('Prospect_status')}}</td>
                          <td>{{__('1')}}</td>
                          <td>{{__('861222')}}</td>
                          <td>{{__('Mandala.com')}}</td>
                          <td>{{__('1')}}</td>
                          <td>{{__('Mandala')}}</td>
                          <td>{{__('2')}}</td>
                          <td>{{__('John')}}</td>
                          <td>{{__('doe')}}</td>
                          <td>{{__('johndoe@example.com')}}</td>
                          <td>{{__('9999955555')}}</td>
                          <td>{{__('9999955555')}}</td>
                          <td>{{__('1')}}</td>
                          <td>{{__('yes')}}</td>
                          <td>{{__('BAC999999')}}</td>
                          <td>{{__('male')}}</td>
                          <td>{{__('lorem ipsum')}}</td>
                          <td>{{__('lorem ipsum')}}</td>
                          <td>{{__('234444')}}</td>
                        
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <form action="{{url('customer/import')}}" method="post" enctype="multipart/form-data">
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



