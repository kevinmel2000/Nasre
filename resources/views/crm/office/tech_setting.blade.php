@extends('crm.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
      <div class="card card-secondary">
        <div class="card-header ">
          <div class="card-title card-primary">{{__('Tech Settings')}}</div>
        </div>
        <div class="card-body">
          <form @if (@$smtp) action="{{url('office/tech_setting/smtp', $smtp)}}" @else action="{{url('office/tech_setting/smtp/store')}}" @endif method="post">
            
            @csrf
            @if (@$smtp)
              @method('PUT')
            @endif

            <label for="">{{__('SMTP Settings')}}</label>
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label for="">{{__('HostName')}} 
                    <span data-toggle="tooltip" data-title="{{__('This is the server name for your SMTP server. For example, Gmail\'s hostname is: smtp.gmail.com')}}">
                      <i class="fas fa-question-circle"></i>
                    </span>
                  </label>
                  <input type="text" name="mail_host" value="{{@$smtp->mail_host}}" class="form-control form-control-sm" required />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="">{{__('Username')}}
                    <span data-toggle="tooltip" data-title="{{__('The username for the mail account itself!')}}">
                      <i class="fas fa-question-circle"></i>
                    </span>
                  </label>
                  <input type="text" name="mail_username" value="{{@$smtp->mail_username}}" class="form-control form-control-sm" required />
                </div>
              </div>

              <div class="col-md-6">
                <label for="">Port
                  <span data-toggle="tooltip" data-title="{{__('This is the port that your mail server expects communication to come through. In most cases this will be 465 for a secure (SSL) connection or 25 if not.')}}">
                    <i class="fas fa-question-circle"></i>
                  </span>
                </label>
                <div class="form-group">
                  <input type="text" name="mail_port" value="{{@$smtp->mail_port}}" class="form-control form-control-sm" required />
                </div>
              </div>

              <div class="col-md-6">
                <label for="">{{__('Password')}}
                  <span data-toggle="tooltip" data-title="{{__('The password for the mail account itself!')}}">
                    <i class="fas fa-question-circle"></i>
                  </span>
                </label>
                <div class="form-group">
                  <input type="text" name="mail_password" value="{{@$smtp->mail_password}}" class="form-control form-control-sm" required />
                </div>
              </div>
              
              <div class="col-md-12">
                <input type="submit" value="{{__('Save SMTP Setting')}}" class="btn btn-primary btn-sm">
              </div>
            </div>
          </form>
          {{-- !SECTION SMTP ENDS HERE --}}
        </div>
      </div>
    </div>
</div>


@endsection