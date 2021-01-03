@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('crm.layouts.breadcrumb')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">

            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Manage Customers')}}</h3>
                  <a type="button" class="btn btn-sm btn-primary float-right" href="{{url('customer/create')}}">{{__('New Customer')}} </a>
                  <a type="button" class="btn btn-sm btn-info float-right mr-2" href="{{url('customer/import')}}">
                    <i class="fas fa-cloud-upload-alt mr-1"></i>
                    {{__('Import Bulk Customers ')}}
                  </a>
                </div>
                <div class="card-body">
                   <div class="table-reponsive">
                  <table id="customers_tbl" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Company')}}</th>
                      <th>{{__('Username/Full Name')}}</th>
                      <th>{{__('Contact')}}</th>
                      <th>{{__('Customer Type')}}</th>
                      <th>{{__('Prospect')}}</th>
                      <th>{{__('Industry')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$customers as $customer)
                            <tr>
                                <td>{{@$customer->id}}</td>
                                <td>{{@$customer->company_name}}</td>
                                <td>
                                  


  <a href="#" data-toggle="modal" data-target="#viewCustomer{{@$customer->id}}">
    @can('update-contact', User::class)
    <a href="{{url('/customer/show', $customer->id)}}">
      {{@$customer->username}} |
      {{@$customer->first_contact->first_name}} {{@$customer->first_contact->last_name}}
    </a>
    @else 
      {{@$customer->first_contact->first_name}} {{@$customer->first_contact->last_name}}
    @endcan
  </a>
  <div class="modal fade" id="viewCustomer{{@$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
          <h5 class="modal-title">#{{@$customer->id}} | {{$customer->username}} </h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                  <label for=""> {{__('Company')}} </label>
                  <input type="text"  value="{{@$customer->company_name}}"  name="customer_number" class="form-control form-control-sm" readonly/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                  <label for=""> {{__('Website')}} </label>
                  <input type="text"  value="{{@$customer->website}}"  name="customer_title" class="form-control form-control-sm" readonly/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">{{__('VAT')}} </label>
                <input type="text" value="{{@$customer->vat}}" class="form-control form-control-sm" readonly>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for=""> {{__('Customer Type')}}</label>
                <input type="text" value="{{@$customer->customer_type}}" class="form-control form-control-sm" readonly>
              </div>
            </div>

        </div>

        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="">{{__('Prospect Status')}}</label>
              <input type="text" value="{{@$customer->prospect_status}}"  class="form-control form-control-sm" readonly/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="">{{__('Industry')}} </label>
              <input type="text" value="{{@$customer->industry->name}}"  class="form-control form-control-sm" readonly/>
            </div>
          </div>

        </div>

        <div class="card">
          <div class="card-header bg-gray">{{__('Primary Contact')}}</div>
          <div class="card-body bg-light-blue">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('Title')}} </label>
                  <input type="text" value="{{@$customer->first_contact->title->name}}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('First Name')}}</label>
                  <input type="text" value="{{ @$customer->first_contact->first_name }}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('Last Name')}} </label>
                  <input type="text" value="{{ @$customer->first_contact->last_name }}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('Email')}} </label>
                  <input type="text" value="{{ @$customer->first_contact->email }}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('Phone')}} </label>
                  <input type="text" value="{{@$customer->first_contact->phone}}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('Whatsapp')}} </label>
                  <input type="text" value="{{ @$customer->first_contact->whatsapp }}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('Customer Speaks')}} </label>
                  <input type="text" value="{{ @$customer->first_contact->language->name }}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('Personal ID')}}</label>
                  <input type="text" value="{{ @$customer->first_contact->personal_id }}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('BirthDate')}} </label>
                  <input type="text" value="{{@$customer->first_contact->birthdate}}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">{{__('Gender')}} </label>
                  <input type="text" value="{{ @$customer->first_contact->gender }}"  class="form-control form-control-sm" readonly/>
                </div>
              </div>
              <div class="col-md-3">
              </div>
              <div class="col-md-3">
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
        </div>
      </div>
    </div>
  </div>

  {{-- View invoice Modal Ends --}}

                                </td>
                                <td>
                                  <a href="tel:{{@$customer->first_contact->phone}}">{{@$customer->first_contact->phone}}
                                    <span class="font20">
                                      <i class="fas fa-phone-square-alt"></i>
                                    </span>
                                  </a>
                                
                                  <a href="https://wa.me/{{@$customer->first_contact->whatsapp}}" target="_blank" class="mr-1">
                                    <span class="font20">
                                      <i class="fab fa-whatsapp-square text-success"></i>
                                    </span>
                                  </a>
                                  <br>
                                  <a href="mailto:{{@$customer->first_contact->email}}">
                                    {{@$customer->first_contact->email}}
                                    <span class="font20">
                                      <i class="fas fa-envelope-square text-secondary"></i>
                                    </span>
                                  </a>
                                </td>
                                <td>{{@$customer->customer_type}}</td>
                                <td>{{@$customer->prospect_status}}</td>
                                <td>{{@$customer->industry->name}}</td>
                                
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$customer->created_at->toDayDateTimeString()}}" class="mr-2">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$customer->updated_at->toDayDateTimeString()}}" class="mr-2">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                   
                                    @can('update-contact', User::class)
                                      <a class="text-primary mr-2" href="{{url('/customer/show', $customer->first_contact)}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    @endcan
  
                                    @can('delete-contact', User::class)
                                      <span id="delbtn{{@$customer->id}}"></span>
                                      <form id="delete-customer-{{$customer->id}}"
                                          action="{{ url('customer/destroy', $customer->id) }}"
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
                    <tfoot>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Company')}}</th>
                      <th>{{__('Name')}}</th>
                      <th>{{__('Contact')}}</th>
                      <th>{{__('Customer Type')}}</th>
                      <th>{{__('Prospect')}}</th>
                      <th>{{__('Industry')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                </div>
              </div>


          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


@endsection

@section('scripts')
  @include('crm.customer.index_js')
@endsection



