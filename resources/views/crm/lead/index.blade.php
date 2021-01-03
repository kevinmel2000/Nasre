@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <div class="content-wrapper">
    @include('crm.layouts.breadcrumb')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="btn btn-secondary">{{__('Total Leads')}}
                      <span class="badge badge-light bg-info ml-1">
                        @if (Auth::user()->role->name == 'admin')
                          {{session('total_leads')}}
                        @else 
                          {{@$total_staff_leads ?? '0'}}
                        @endif
                      </span>
                    </button>  
                   
                    <a class="btn btn-default" href="{{url('lead')}}">{{__('Pending Leads')}}
                      <span class="badge badge-light bg-info ml-1"> {{@$pending_leads ?? '0'}}</span>
                    </a>  
                    <a class="btn btn-default" href="{{url('lead/won')}}">{{__('Won Leads')}} 
                        <span class="badge badge-light bg-success ml-1"> {{@$won_leads ?? '0'}}</span>
                      </a>
                      <a class="btn btn-default" href="{{url('lead/poorfit')}}">{{__('Poorfit Leads')}} 
                        <span class="badge badge-light bg-primary ml-1"> {{@$poor_leads ?? '0'}}</span>
                      </a>
                      <a class="btn btn-default" href="{{url('lead/dead')}}">{{__('Dead Leads')}} 
                        <span class="badge badge-light bg-danger ml-1"> {{@$dead_leads ?? '0'}}</span>
                      </a>
                  </div>
                  @if (Auth::user()->role->name == 'admin')
                  <div class="col-md-12 mt-2">
                    <div class="card">
                      <div class="card-body bg-light-gray">
                        <form action="{{url('lead/sort')}}" method="post">
                          @csrf  
                          <div class="row">
                            <div class="col-md-3">
                              <label for="">{{__('Sort')}}</label>
                              <select name="sort_status_wise" id="sort_status_wise" class="form-control form-control-sm">
                                @if (@$request->sort_status_wise == null)
                                  <option selected disabled>{{__('Select an option')}}</option>
                                @endif
                                @php
                                    $status_types = [__('pending_leads'),__('won_leads'),__('poorfit_leads'),__('dead_leads')]
                                @endphp
                                @foreach ($status_types as $status)
                                    @if ($status == @$request->sort_status_wise)
                                      <option value="{{$status}}" selected>{{underscoreToCamelCase($status)}}</option>
                                    @else
                                      <option value="{{$status}}">{{underscoreToCamelCase($status)}}</option>
                                    @endif
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-3">
                              <label for="">{{__('Date Period')}}</label>
                              <select name="date_sort" id="date_sort" class="form-control form-control-sm">
                                @if (@$request->date_sort == null)
                                  <option selected disabled>{{__('Select an option')}}</option>
                                @endif
                                @php
                                    $status_types = [
                                      __('custom'),
                                      __('today'),
                                      __('yesterday'),
                                      __('this_week'),
                                      __('last_week'),
                                      __('this_month'),
                                      __('last_month'),
                                      __('last_3_months'),
                                      __('last_6_months'),
                                      __('this_year'),
                                      __('last_year')
                                      ]
                                @endphp
                                @foreach ($status_types as $status)
                                @if ($status == @$request->date_sort)
                                      <option value="{{$status}}" selected>{{underscoreToCamelCase($status)}}</option>
                                    @else
                                      <option value="{{$status}}">{{underscoreToCamelCase($status)}}</option>
                                    @endif
                                @endforeach
                              </select> 
                            </div>
                            <div
                            @if (@$request->date_sort == 'custom')
                              class="col-md-3 d-show"
                            @else 
                              class="col-md-3 d-hide"  
                            @endif
                            id="date_range_col">
                              <div class="form-group">
                                <label>{{__('Date range:')}}</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" name="custom_range" class="form-control form-control-sm" id="reservation" value="{{@$request->custom_range}}">
                                </div>
                                <!-- /.input group -->
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label for="">{{__('Lead Owner')}}</label>
                              <div class="input-group">
                                <select name="owner_id" id="owner_id" class="form-control form-control-sm">
                                  @if (@$request->owner_id == null)
                                    <option selected disabled>{{__('Select an option')}}</option>
                                  @endif
                                  @foreach ($lead_owners as $lead_owner)
                                    @if ($lead_owner->id == @$request->owner_id)
                                      <option value="{{$lead_owner->id}}" selected>{{$lead_owner->name}} | {{$lead_owner->email}}</option>
                                    @else
                                      <option value="{{$lead_owner->id}}">{{$lead_owner->name}} | {{$lead_owner->email}}</option>
                                    @endif
                                  @endforeach
                                </select> 
                                <span class="input-group-append">
                                  <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                  </button>
                                </span>
                              </div>
                            </div>
                            
                          </div>
                        </form>
                      </div>
                    </div>                   
                  </div>
                  @endif
                </div>

              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Manage Leads')}}</h3>
                  <a type="button" class="btn btn-sm btn-primary float-right" href="{{url('lead/create')}}">{{__('New Lead')}}</a>
                  <a type="button" class="btn btn-sm btn-info float-right mr-2" href="{{url('lead/import')}}">
                    <i class="fas fa-cloud-upload-alt mr-1"></i>
                    {{__('Import Bulk Leads ')}}
                  </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="leadsTable" class="table table-bordered table-striped display">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Name')}}</th>
                      <th>{{__('Source')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Prospect')}}</th>
                      <th>{{__('Temp')}}</th>
                      <th>{{__('Score')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                              <td
                              @if (@$lead->lead_status_id == '1')
                                  class="bg-success"
                              @endif
                              >{{@$lead->id}}</td>
                              <td>
                                @can('update-lead', User::class)
                                      <a href="{{url('/lead/show', $lead->id)}}" data-toggle="tooltip" title="{{@$lead->company_name}}">
                                        {{substr(@$lead->first_name.' '.@$lead->last_name.'..', 0,20)}}
                                      </a>
                                @endcan
                                
                              </td>
                              
                              <td>{{substr(@$lead->leadSource->name, 0,25)}}</td>
                              <td>{{@$lead->leadStatus->name}}</td>
                              <td>{{@$lead->prospect_status}}</td>
                             
                                @if ($lead->lead_temprature == __('Hot'))
                                  @php
                                      $color = __('danger');
                                  @endphp
                                @elseif ($lead->lead_temprature == __('Warm'))
                                  @php
                                      $color = __('warning');
                                  @endphp
                                @elseif ($lead->lead_temprature == __('Cold'))
                                  @php
                                      $color = __('info');
                                  @endphp
                                @else
                                  @php
                                    $color = __('default');
                                  @endphp 
                                @endif
                                
                                <td class="bg-{{@$color}}">
                                {{@$lead->lead_temprature}}</td>
                                <td>{{@$lead->score}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$lead->created_at->toDayDateTimeString()}}" class="mr-2">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$lead->updated_at->toDayDateTimeString()}}" class="mr-2">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  <span>
                                    @can('update-lead', User::class)
                                      <a class="mr-2 text-primary" href="{{url('/lead/show', $lead->id)}}">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                    @endcan
  
                                    @can('delete-lead', User::class)
                                    <span id="delbtn{{@$lead->id}}"></span>
                                      <form id="delete-lead-{{$lead->id}}"
                                          action="{{ url('lead/destroy', $lead->id) }}"
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
                      <th>{{__('Name')}}</th>
                      <th>{{__('Source')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Prospect')}}</th>
                      <th>{{__('Temp')}}</th>
                      <th>{{__('Score')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('scripts')
  @include('crm.lead.index_js')
@endsection



