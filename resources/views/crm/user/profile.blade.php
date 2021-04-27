@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <div class="content-wrapper">
    @include('crm.layouts.breadcrumb')

    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">

            <div class="card card-secondary">
                <div class="card-header bg-gray">
                  <h3 class="card-title">{{__('User Profile')}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body bg-light-gray">
                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <div class="text text-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <form action="{{url('user/profile', $user)}}" method="post">
                      @csrf
                      @method('PUT')
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">{{__('Name')}}</label>
                                <input type="text" name="name" class="form-control form-control-gm" value="{{@$user->name}}">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">{{__('Email')}}</label>
                                <input type="text" class="form-control form-control-gm" value="{{@$user->email}}" readonly />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">{{__('Phone')}}</label>
                                <input type="text" name="phone" class="form-control form-control-gm" value="{{@$user->phone}}">
                              </div>
                            </div>
                          </div>
                          <input type="submit" class="btn btn-primary" value="Save Profile">
                        </div>
                      </div>
                    </form>

                    <br><br>
                    <form action="{{url('user/profile/update_password', $user)}}" method="post">
                      @csrf
                      @method('PUT')
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">{{__('Old Password')}}</label>
                                <input type="text" name="old_password" class="form-control form-control-gm">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">{{__('New Password')}}</label>
                                <input type="text" name="new_password" class="form-control form-control-gm" />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">{{__('Confirm Password')}}</label>
                                <input type="text" name="confirm_password" class="form-control form-control-gm">
                              </div>
                            </div>
                          </div>
                          <input type="submit" class="btn btn-primary" value="Update Password">
                        </div>
                      </div>
                      
                    </form>
                </div>
              </div>
          </div>

          
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>

@endsection

@section('scripts')
@include('crm.user.profile_js')
@endsection



