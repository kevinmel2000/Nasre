@extends('installation.layout')

@section('content')
@include('installation.steps_style')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@include('installation.steps_script')
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <center><h1 class="text-light">Mandala CRM Installation</h1></center>
    <center><h2 class="text-light">Welcome To The Setup Wizard</h2></center>
    <br/>
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small class="text-light">Basic Details</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small class="text-light">Permissions</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small class="text-light">Database Details</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                <p><small class="text-light">SMTP Details</small></p>
            </div>
        </div>
    </div>
    
    <form action="{{url('install/submit')}}" method="post" role="form">
      @csrf
        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                 <h3 class="panel-title">Basic Details</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Application Name</label>
                    <input maxlength="100" type="text" required="required" class="form-control" name="app_name" value="Mandala CRM"/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Application Environment</label>
                    <select name="app_env" class="form-control" required>
                      <option value="local" selected>Local</option>
                      <option value="production">production</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Application Debug</label>
                    <select name="app_debug" class="form-control" required>
                      <option value="true" selected>true</option>
                      <option value="false">false</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Application URL (Set url security http/https)</label>
                    <input type="text" name="app_url" class="form-control" value="{{'http://'.$_SERVER['HTTP_HOST']}}">
                  </div>
                </div>
              </div>

              <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
            </div>
        </div>
        
        <div class="panel panel-primary setup-content" id="step-2">
            <div class="panel-heading">
                 <h3 class="panel-title">Permissions</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table striped bordered">
                    <thead>
                      <th>Directory</th>
                      <th>Permissions</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>bootstrap/cache</td>
                        <td>
                          @if (@$bootstrap_permission >= '0755')
                            <i class="fas fa-circle text-success"></i> 
                          @else
                            <i class="fas fa-circle text-danger"></i> 
                          @endif
                          {{@$bootstrap_permission}}</td>
                      </tr>
                      <tr>
                        <td>storage/app</td>
                        <td>
                          @if (@$stg_app_permission >= '0755')
                            <i class="fas fa-circle text-success"></i> 
                          @else
                            <i class="fas fa-circle text-danger"></i> 
                          @endif
                          {{@$stg_app_permission}}</td>
                      </tr>
                      <tr>
                        <td>storage/framework</td>
                        <td>
                          @if (@$stg_framework_permission >= '0755')
                            <i class="fas fa-circle text-success"></i> 
                          @else
                            <i class="fas fa-circle text-danger"></i> 
                          @endif
                          {{@$stg_framework_permission}}</td>
                      </tr>
                      <tr>
                        <td>storage/logs</td>
                        <td>
                          @if (@$stg_logs_permission >= '0755')
                            <i class="fas fa-circle text-success"></i> 
                          @else
                            <i class="fas fa-circle text-danger"></i> 
                          @endif
                          {{@$stg_logs_permission}}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                @if (@$stg_logs_permission >= '0755' && @$stg_framework_permission >= '0755' && @$stg_app_permission >= '0755' && @$bootstrap_permission >= '0755')
                  <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                @endif
            </div>
        </div>
        
        <div class="panel panel-primary setup-content" id="step-3">
            <div class="panel-heading">
                 <h3 class="panel-title">Database Details</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">DB_CONNECTION</label>
                      <input type="text" required="required" class="form-control" name="db_connection"  value="mysql" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">DB_HOST</label>
                        <input type="text" required="required" class="form-control" name="db_host" value="127.0.0.1" />
                    </div>
                    <div class="form-group">
                      <label class="control-label">DB_POST</label>
                      <input type="text" required="required" class="form-control" name="db_port" value="3306" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">DB_DATABASE</label>
                      <input type="text" required="required" class="form-control" name="db_database"  value="Mandala_crm" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">DB_USERNAME</label>
                        <input type="text" required="required" class="form-control" name="db_username" value="root" />
                    </div>
                    <div class="form-group">
                      <label class="control-label">DB_PASSWORD</label>
                      <input type="text" class="form-control" name="db_password" value="root" />
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
            </div>
        </div>
        
        <div class="panel panel-primary setup-content" id="step-4">
            <div class="panel-heading">
                 <h3 class="panel-title">SMTP Details</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <p>Run this Cron Job in your server to send email, because this software will insert the email data in the (queue)database, and on running cron, it will automatically be sent to the user form the queue.</p>
                  <strong>
                    /usr/local/bin/php /home/user_name/public_html/Mandala_crm/artisan schedule:run >/dev/null 2>&1
                  </strong>
                </div>
              </div>
              <br/>
              <br/>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">MAIL_DRIVER</label>
                    <input type="text" class="form-control" name="mail_driver"  value="smtp" />
                  </div>
                  <div class="form-group">
                      <label class="control-label">MAIL_HOST</label>
                      <input type="text" class="form-control" name="mail_host" value="smtp.mailtrap.io" />
                  </div>
                  <div class="form-group">
                    <label class="control-label">MAIL_PORT</label>
                    <input type="text" class="form-control" name="mail_port" value="2525" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">MAIL_USERNAME</label>
                    <input type="text" class="form-control" name="mail_username"  value="null" />
                  </div>
                  <div class="form-group">
                    <label class="control-label">MAIL_PASSWORD</label>
                    <input type="text" class="form-control" name="mail_password" value="null" />
                  </div>
                  <div class="form-group">
                      <label class="control-label">MAIL_ENCRYPTION</label>
                      <input type="text" class="form-control" name="mail_encryption" value="null" />
                  </div>
                </div>
              </div>
              <button class="btn btn-success pull-right" type="submit">Submit & Save</button>
            </div>
        </div>
    </form>
</div>
@endsection