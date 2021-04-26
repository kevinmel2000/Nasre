@extends('client.layouts.app')

@section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    {{-- <!-- Content Header (Page header) --> --}}
    @include('client.layouts.breadcrumb')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        {{-- <!-- Small boxes (Stat box) --> --}}
        <div class="row">

          <div class="col-md-12">

            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('User Profile')}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <div class="text text-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <form action="{{url('client/profile')}}" method="post">
                      @csrf
                
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">{{__('Username')}}</label>
                                <input type="text" class="form-control form-control-gm" value="{{@$customer->username}}" readonly>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">{{__('Email')}}</label>
                                <input type="text" name="email" class="form-control form-control-gm" value="{{@$customer->first_contact->email}}"  />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">{{__('Phone')}}</label>
                                <input type="text" name="phone" class="form-control form-control-gm" value="{{@$customer->first_contact->phone}}">
                              </div>
                            </div>
                          </div>
                          <input type="submit" class="btn btn-primary" value="Save Profile">
                        </div>
                      </div>
                    </form>

                    <br><br>
                    <form action="{{url('client/profile/update_password')}}" method="post">
                      @csrf
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



