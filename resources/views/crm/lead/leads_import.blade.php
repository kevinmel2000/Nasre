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
                  <h3 class="card-title">{{__('Bulk Import Leads')}}</h3>
                    <a type="button" class="btn btn-sm btn-info float-right mr-2" href="{{url('/lead')}}">
                      <i class="fas fa-arrow-circle-left mr-1"></i>
                      {{__('Go Back ')}}
                    </a>
                </div>
                <div class="card-body">
                  
                  <p class="font14 textLeft">
                    <b>{{__("Instructions: ")}}</b> <br/>
                    {{__("1. First line would be the heading of all the fields, don't change field's name in the heading.")}} <br/>
                    {{__('2.')}} <b>{{__(' user_id ')}}</b>{{__('is the id, who is importing the lead. while')}} <b>{{__(' owner_id ')}}</b>{{__("is the id of the staff, who has to follow the lead!")}} <br/>
                    {{__('3. Get ')}} <b>{{__('language_id and industry_id')}}</b> {{__("from the dropdown list.")}} <br/>
                    {{__('4. ')}} <b>{{__('prospect_status')}}</b> {{__(" can be Prospect / Lost-Prospect / Non-Prospect ")}} <br/>
                    {{__('5. ')}} <b>{{__('lead_temprature')}}</b> {{__(" can be Cold / Hot / Warm ")}} <br/>
                    {{__('6. ')}} <b>{{__('score')}}</b> {{__(" can be 1 to 10 in integer only. ")}} <br/>
                    {{__('7. ')}} <b>{{__('is_dead & is_poor_fit')}}</b> {{__(" can be yes/no ")}} <br/>
                    <a href="{{url('/public_files/sample_leads.xlsx')}}" target="_blank">{{__('Sample Excel File')}}</a>
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
                          <th>{{__('user_id')}} <span class="text-danger">*</span> </th>
                          <th>{{__('title_id')}} <span class="text-danger">*</span></th>
                          <th>{{__('language_id')}} </th>
                          <th>{{__('first_name')}} </th>
                          <th>{{__('last_name')}} <span class="text-danger">*</span></th>
                          <th>{{__('company_name')}} </th>
                          <th>{{__('website')}} </th>
                          <th>{{__('email')}} </th>
                          <th>{{__('fax')}} </th>
                          <th>{{__('phone')}} </th>
                          <th>{{__('whatsapp')}} </th>
                          <th>{{__('prospect_status')}} </th>
                          <th>{{__('owner_id')}} <span class="text-danger">*</span></th>
                          <th>{{__('last_owner_id')}} </th>
                          <th>{{__('industry_id')}} </th>
                          <th>{{__('lead_source_id')}} </th>
                          <th>{{__('lead_status_id')}} <span class="text-danger">*</span></th>
                          <th>{{__('lead_temprature')}} </th>
                          <th>{{__('score')}} </th>
                          <th>{{__('is_dead')}} </th>
                          <th>{{__('is_poor_fit')}} </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>{{__('1')}}</td>
                          <td>{{__('4')}}</td>
                          <td>{{__('2')}}</td>
                          <td>{{__('John')}}</td>
                          <td>{{__('Doe')}}</td>
                          <td>{{__('Company Name')}}</td>
                          <td>{{__('Mandala.com')}}</td>
                          <td>{{__('john@demo.com')}}</td>
                          <td>{{__('9899999999')}}</td>
                          <td>{{__('9999666666')}}</td>
                          <td>{{__('9999666666')}}</td>
                          <td>{{__('Prospect')}}</td>
                          <td>{{__('1')}}</td>
                          <td>{{__('1')}}</td>
                          <td>{{__('2')}}</td>
                          <td>{{__('2')}}</td>
                          <td>{{__('4')}}</td>
                          <td>{{__('Hot')}}</td>
                          <td>{{__('10')}}</td>
                          <td>{{__('no')}}</td>
                          <td>{{__('no')}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <form action="{{url('lead/import')}}" method="post" enctype="multipart/form-data">
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



