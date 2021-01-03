@extends('crm.layouts.app')

@section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
      <div class="card card-secondary">
        <div class="card-header bg-gray">
          <h2 class="card-title card-primary">{{__('ADD NEW FORM FIELD')}}</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          <form action="{{url('office/formfield/store')}}" method="post">
            @csrf
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">{{__('Field Name')}} </label>
                  <select name="name" class="form-control form-control-sm" required>
                    @foreach ($lead_fields as $field)
                      <option value="{{$field}}">{{$field}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">{{__('Field Type')}}</label>
                  @php
                      $types = [
                        __('text'),
                        __('textarea'),
                        __('number'),
                        __('date'),
                        __('time'),
                        __('color'),
                        __('datetime-local'),
                        __('email'),
                        __('checkbox'),
                        __('hidden'),
                        __('month'),
                        __('password'),
                        __('tel'),
                        __('url'),
                        __('week'),
                        __('submit'),
                      ]
                  @endphp
                  <select name="type" class="form-control form-control-sm" required>
                    @foreach ($types as $type)
                        <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">{{__('Placeholder')}}</label>
                  <input type="text" name="placeholder" class="form-control form-control-sm" maxlength="60" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">{{__('Help Text')}}</label>
                  <input type="text" name="helptext" class="form-control form-control-sm" maxlength="200" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">{{__('Character Limit')}}</label>
                  <input type="number" name="limit" class="form-control form-control-sm" maxlength="3" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">{{__('CSS Class')}}</label>
                  <input type="text" name="cssclass" class="form-control form-control-sm" />
                </div>
              </div>
              {{-- <div class="col-md-4">
                <div class="form-group">
                  <label for="">{{__('Match with Lead Field')}}</label>
                  <select name="matchLeadField" class="form-control form-control-sm">
                    @foreach ($lead_fields as $lead_field)
                      <option value="{{$lead_field}}">{{$lead_field}}</option>
                    @endforeach
                  </select>
                </div>
              </div> --}}
              <div class="col-md-4">
                <div class="form-group">
                  <input type="checkbox" name="required" class="mr-2"/>
                  <label for="">{{__('Is required ?')}}</label>
                </div>
              </div>
            </div>
            <input type="submit" value="Create New Field" class="btn btn-sm btn-primary">
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-gray">
          <h2 class="card-title card-primary">{{__('FORM FIELDS')}}</h2>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="fieldsTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>{{__('Field Name')}}</th>
                <th>{{__('Field Type')}}</th>
                <th>{{__('Match to Lead')}}</th>
                <th>{{__('Char Limit')}}</th>
                <th>{{__('Actions')}}</th>
              </tr>
              </thead>
              <tbody>
                  @foreach (@$formfields as $formfield)
                      <tr>
                        <td>{{@$formfield->name}}</td>
                        <td>{{@$formfield->type}}</td>
                        <td>{{@$formfield->matchLeadField}}</td>
                        <td>{{@$formfield->limit}}</td>
      
                          <td>
                            <a href="#" data-toggle="tooltip" data-title="{{$formfield->created_at->toDayDateTimeString()}}" class="mr-2">
                              <i class="fas fa-clock text-info"></i>
                            </a>
                            <a href="#" data-toggle="tooltip" data-title="{{$formfield->updated_at->toDayDateTimeString()}}" class="mr-2">
                              <i class="fas fa-history text-primary"></i>
                            </a>
                            <span>
                              @can('update-product', User::class)
                                <a href="#" class="text-primary mr-3" data-toggle="modal" data-target="#editGroup{{@$formfield->id}}">
                                  <i class="fas fa-edit"></i>
                                </a>
                    {{-- SECTION Add Currency modal Starts Here --}}
                      <div class="modal fade" id="editGroup{{@$formfield->id}}" tabindex="-1" role="dialog" aria-labelledby="editformfieldLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content bg-light-gray">
                            <div class="modal-header bg-gray">
                              <h5 class="modal-title" id="editformfieldLabel">{{__('Update Product Group')}}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="{{url('office/formfield', $formfield)}}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="">{{__('Field Name')}}
                                          <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('Field name must be in (lowercase a-z 0-9 allowed). No Spaces allowed')}}"></i>  
                                        </label>
                                        <input type="text" name="name" value="{{@$formfield->name}}" class="form-control form-control-sm" maxlength="30" 
                                        data-validation="required|length|custom" 
                                        data-validation-regexp="^([a-z0-9]*)$" 
                                        data-validation-length="2-30"
                                        required />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="">{{__('Field Type')}}</label>
                                        @php
                                            $types = [
                                              __('text'),
                                              __('textarea'),
                                              __('number'),
                                              __('date'),
                                              __('time'),
                                              __('color'),
                                              __('datetime-local'),
                                              __('email'),
                                              __('checkbox'),
                                              __('hidden'),
                                              __('month'),
                                              __('password'),
                                              __('tel'),
                                              __('url'),
                                              __('week'),
                                              __('submit'),
                                            ]
                                        @endphp
                                        <select name="type" class="form-control form-control-sm" required>
                                          @foreach ($types as $type)
                                              @if ($type == $formfield->type)
                                                <option value="{{$type}}" selected>{{$type}}</option>
                                              @else 
                                                <option value="{{$type}}">{{$type}}</option>  
                                              @endif
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="">{{__('Placeholder')}}</label>
                                        <input type="text" name="placeholder" value="{{@$formfield->placeholder}}" class="form-control form-control-sm" maxlength="60" />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="">{{__('Help Text')}}</label>
                                        <input type="text" name="helptext" value="{{@$formfield->helptext}}" class="form-control form-control-sm" maxlength="200" />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="">{{__('Character Limit')}}</label>
                                        <input type="number" name="limit" value="{{@$formfield->limit}}" class="form-control form-control-sm" maxlength="3" />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="">{{__('CSS Class')}}</label>
                                        <input type="text" name="cssclass" value="{{@$formfield->cssclass}}" class="form-control form-control-sm" />
                                      </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="">{{__('Match with Lead Field')}}</label>
                                        <select name="matchLeadField" class="form-control form-control-sm">
                                          @foreach ($lead_fields as $lead_field)
                                            @if ($lead_field == $formfield->matchLeadField)
                                                <option value="{{$lead_field}}" selected>{{$lead_field}}</option>
                                              @else 
                                                <option value="{{$lead_field}}">{{$lead_field}}</option>  
                                            @endif
                                          @endforeach
                                        </select>
                                      </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <input type="checkbox" name="required" class="mr-2"
                                        @if ($formfield->required == 'yes')
                                            checked
                                        @endif
                                        />
                                        <label for="">{{__('Is required ?')}}</label>
                                      </div>
                                    </div>
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
                              <span id="delbtn{{@$formfield->id}}"></span>
                                <form id="delete-formfield-{{@$formfield->id}}"
                                    action="{{ url('office/formfield/destroy', $formfield->id) }}"
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
      </div>
    </div>
</div>
@endsection

@section('scripts')
@include('crm.office.formfield.index_js')  
@endsection