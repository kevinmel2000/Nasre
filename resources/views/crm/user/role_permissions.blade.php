@extends('crm.layouts.app')

@section('styles')
<style>
.minWidth{
  min-width: 150px
}  
</style>
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <div class="content-wrapper">
    @include('crm.layouts.breadcrumb')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

          <div class="col-md-12">

            <div class="card">
                <div class="card-header bg-gray">
                  <h3 class="card-title">{{__('Manage Permissions')}}</h3>
                  
                </div>
                <!-- /.card-header -->
                <div class="card-body bg-light-gray">
                  <div class="row">
                    <div class="col-md-4">
                      <form action="{{url('user/role/permissions/roleid')}}" method="post">
                        @csrf
                        <label for="">{{__('Select Role to Get & Set Permissions')}}</label>
                        <select name="role_id" id="role_id" class="form-control submit">
                          @if (count($roles)> 0)
                            @foreach ($roles as $role)
                              @if ($selected_role_id == $role->id)
                                  <option value="{{$role->id}}" selected>{{$role->name}}</option>
                              @else 
                                  <option value="{{$role->id}}">{{$role->name}}</option>    
                              @endif
                            @endforeach
                          @endif
                        </select>
                      </form>
                    </div>
                  </div>
                  {{-- Show Errors --}}
                  @if($errors)
                      @foreach ($errors->all() as $error)
                          <div class="text text-danger">{{ $error }}</div>
                      @endforeach
                  @endif
                  <hr>
               
                  @foreach ($modules as $module)
                   
                    @if ($$module == NULL)
                      <div class="input-group">
                        <span class="minWidth">{{underscoreToCamelCase($module)}}</span>
                        <form method="post" action="{{route('post_role_permissions')}}" >
                          @csrf
                          <input type="hidden" name="module_name" value="{{$module}}">
                          <input type="hidden" name="role_id" value="{{$selected_role_id}}">
                          <label class="cl-switch cl-switch-green">
                            <label for="create-{{$module}}" class="label pl-1 pr-3"> {{__('Create')}} </label>
                            <input type="checkbox" name="create" id="create-{{$module}}" 
                            class="submit">
                            <span class="switcher"></span>
                          </label>
                        
                          
                        </form>
                        <form method="post" action="{{route('post_role_permissions')}}" >
                          @csrf
                          <input type="hidden" name="module_name" value="{{$module}}">
                          <input type="hidden" name="role_id" value="{{$selected_role_id}}">
                          <input type="checkbox" name="read" id="read-{{$module}}"
                          class="submit"
                          >
                          <label for="read-{{$module}}" class="pl-1 pr-3"> {{__('Read')}} </label>
                        </form>
                        <form method="post" action="{{route('post_role_permissions')}}" >
                          @csrf
                          <input type="hidden" name="module_name" value="{{$module}}">
                          <input type="hidden" name="role_id" value="{{$selected_role_id}}">
                          <input type="checkbox" name="update" id="update-{{$module}}"
                          class="submit"
                          >
                          <label for="update-{{$module}}" class="pl-1 pr-3"> {{__('Update')}} </label>
                        </form>
                        <form method="post" action="{{route('post_role_permissions')}}" >
                          @csrf
                          <input type="hidden" name="module_name" value="{{$module}}">
                          <input type="hidden" name="role_id" value="{{$selected_role_id}}">
                          <input type="checkbox" name="delete" id="delete-{{$module}}"
                          class="submit"
                          >
                          <label for="delete-{{$module}}" class="pl-1 pr-3"> {{__('Delete')}} </label>
                        </form>
                      </div>
                      @else 
                      {{-- NOTE: if module already have a row in the modules table for permissions --}}
                      <div class="input-group">
                        <span class="minWidth">{{underscoreToCamelCase($module)}}</span>
                        <div class="mr-4">
                          <form 
                          action="{{url('user/role/permissions', $$module)}}" 
                          method="post">
                          @csrf
                          @if ($$module != NULL)
                            @method('PUT')
                          @endif
                          <input type="hidden" name="module_name" value="{{$module}}">
                          <input type="hidden" name="role_id" value="{{$selected_role_id}}">
                          <input type="hidden" name="create[]" value="off" />
                          <label class="cl-switch cl-switch-green">
                            <span for="create-{{$module}}" class="label"> Create </span>
                            <input type="checkbox" name="create[]" id="create-{{$module}}" 
                            class="submit"
                            @if (@$$module->create == 'on')
                                checked
                            @endif>
                            <span class="switcher"></span>
                          </label>
                         </form>
                        </div>  
                        <div class="mr-4">
                          <form 
                          action="{{url('user/role/permissions', $$module)}}" 
                          method="post">
                          @csrf
                          @if ($$module != NULL)
                            @method('PUT')
                          @endif
                          <input type="hidden" name="module_name" value="{{$module}}">
                          <input type="hidden" name="role_id" value="{{$selected_role_id}}">
                          <input type="hidden" name="read[]" value="off" />
                          <label class="cl-switch cl-switch-green">
                            <span for="read-{{$module}}" class="label "> {{__('Read')}} </span>
                            <input type="checkbox" class="submit"  name="read[]" id="read-{{$module}}"
                            @if (@$$module->read == 'on')
                                checked
                            @endif>
                            <span class="switcher"></span>
                          </label>
                          </form>                        
                        </div>  
                        <div class="mr-4">
                          <form 
                          action="{{url('user/role/permissions', $$module)}}" 
                          method="post">
                          @csrf
                          @if ($$module != NULL)
                            @method('PUT')
                          @endif
                          <input type="hidden" name="module_name" value="{{$module}}">
                          <input type="hidden" name="role_id" value="{{$selected_role_id}}">
                          <input type="hidden" name="update[]" value="off" />
                          <label class="cl-switch cl-switch-green">
                            <span for="update-{{$module}}" class="label"> {{__('Update')}} </span>
                            <input type="checkbox" name="update[]" id="update-{{$module}}"
                            class="submit"
                            @if (@$$module->update == 'on')
                                checked
                            @endif>
                            <span class="switcher"></span>
                          </label>
                        </form>
                        </div>
                        <div class="mr-4">
                          <form 
                          action="{{url('user/role/permissions', $$module)}}" 
                          method="post">
                          @csrf
                          @if ($$module != NULL)
                            @method('PUT')
                          @endif
                          <input type="hidden" name="module_name" value="{{$module}}">
                          <input type="hidden" name="role_id" value="{{$selected_role_id}}">
                          <input type="hidden" name="delete[]" value="off" />
                          <label class="cl-switch cl-switch-green">
                            <span for="delete-{{$module}}" class="label"> {{__('Delete')}} </span>
                            <input type="checkbox" name="delete[]" id="delete-{{$module}}"
                            class="submit"
                            @if (@$$module->delete == 'on')
                                checked
                            @endif>
                            <span class="switcher"></span>
                          </label>
                        </form>
                        </div>
                      </div>
                    @endif

                  @endforeach
                  <hr>
                </div>
                <!-- /.card-body -->
              </div>


          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


{{-- All Modal Starts Here --}}
<div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addRoleLabel">{{__('Add Role')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{url('user/role/store')}}" method="POST">
            <div class="modal-body">
                @csrf
                <label for="">{{__('Enter a Unique Role (Small Case Preferred)')}}</label>
                <input type="text" name="name" class="form-control"/>

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


