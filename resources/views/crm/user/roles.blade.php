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
                  <h3 class="card-title">{{__('Manage Roles')}}</h3>
                  @can('create-role', User::class)
                  <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addRole">{{__('New Role')}} </button>
                  @endcan
                </div>
                <div class="card-body">

                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <div class="text text-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                  <div class="table-responsive">  
                  <table id="roles" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('Role ID')}}</th>
                      <th>{{__('Set Default')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Name')}}</th>
                      <th>{{__('Created At')}}</th>
                      <th>{{__('Updated At')}}</th>
                      <th>{{__('Actions')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @if (count($roles)>0)
                        @foreach (@$roles as $role)

                        <tr>
                          <td>{{ @$role->id }}</td>
                            <td>
                              @if ($role->id != '1')
                                <form action="{{url('/user/role/default', $role)}}" method="post">
                                  @csrf
                                  @method('PUT')
                                  <label class="cl-switch cl-switch-green">
                                    <input type="checkbox" name="default_role" id="setDefault{{$role->id}}" value="yes"
                                    class="submit"
                                    @if ($role->default_role == 'yes')
                                        checked
                                    @endif>
                                    <span class="switcher"></span>
                                  </label>
                                  <label for="setDefault{{$role->id}}" class="label text-info">{{__('Set Default')}}</label>
                                  @if ($role->default_role == 'yes')
                                    <span class="badge badge-danger">{{__('Default Role')}}</span>
                                  @endif
                                </form>
                              @endif
                            </td>
                            <td>{{ucfirst(@$role->status)}}</td>
                            <td>
                              <span class="badge badge-primary"> {{@$role_counter[$i]}} </span>
                               {{(@$role->name)}} 

                            </td>
                            <td>{{@$role->created_at->toDayDateTimeString()}}</td>
                            <td>{{@$role->updated_at->toDayDateTimeString()}}</td>
                            <td>
                              @if ($role->id != '1')

                                @can('update-role', User::class)
                                  <a href="{{route('permissions_role_id', $role)}}" class="mr-3 text-info" data-toggle="tooltip" title="Permissions"><i class="fas fa-user-lock"></i></a>
                                @endcan
                                @can('update-role', User::class)
                                  <a href="#" class="mr-3 text-primary" data-toggle="modal" data-target="#updateRole{{$role->id}}"><i class="fas fa-edit"></i></a>
                                @endcan
                                
                                {{-- Edit Modal Starts --}}
                                <div class="modal fade" id="updateRole{{$role->id}}" tabindex="-1" role="dialog" aria-labelledby="updateRole{{$role->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="updateRole{{$role->id}}Label">{{__('Update Role')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{url('user/role',$role)}}" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                  <label for="">{{__('Enter a Unique Role')}}</label>
                                                  <input type="text" name="name" class="form-control" value="{{@$role->name}}" data-validation="length" data-validation-length="2-25" />
                                                </div>
                                                <div class="form-group">
                                                  @php
                                                      $status = ['active', 'inactive'];
                                                  @endphp
                                                  <select name="status" class="form-control">
                                                    @foreach ($status as $item)
                                                        @if ($item == $role->status)
                                                            <option value="{{$item}}" selected>{{$item}}</option>
                                                        @else 
                                                            <option value="{{$item}}">{{$item}}</option>
                                                        @endif
                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                                <input type="submit" class="btn btn-info" value="Update">
                                            </div>
                                        </form>
                                      </div>
                                    </div>
                                </div>
                                {{-- Edit Modal Ends --}}
                                @can('delete-role', User::class)
                                  <span id="delbtn{{@$role->id}}"></span>
                                  <form id="delete-role-{{$role->id}}"
                                    action="{{ url('user/role/destroy', $role) }}"
                                          method="POST">
                                          @method('DELETE')
                                          @csrf
                                  </form>                                  
                                @endcan
                              @endif  
                              
                            </td>

                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>{{__('Role ID')}}</th>
                      <th>{{__('Set Default')}}</th>
                      <th>{{__('Status')}}</th>
                      <th>{{__('Name')}}</th>
                      <th>{{__('Created At')}}</th>
                      <th>{{__('Updated At')}}</th>
                      <th>{{__('Actions')}}</th>
                    </tr>
                    </tfoot>
                  </table>
                  </div>
                  <br>
                  <p><span class="text-danger">{{__('Note')}}:</span> {{__('If you "inactive" any role, all the users with that role will also gets "inactive" status and vice-versa.')}}
                    <br> 
                    {{__('If you "delete" any role, all the users with that role will be assigned default user role and permissions as set by the admin for that default role. ')}}
                   </p>
                </div>
              </div>


          </div>
        </div>
      </div>
    </section>
  </div>


<div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
          <h5 class="modal-title" id="addRoleLabel">{{__('Add Role')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{url('user/role/store')}}" method="POST">
            <div class="modal-body">
                @csrf
                <label for="">{{__('Enter a Unique Role')}}</label>
                <input type="text" name="name" data-validation="length" data-validation-length="2-25" class="form-control"/>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-info">{{__('Add')}}</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection

@section('scripts')

@include('crm.user.roles_js')

@endsection



