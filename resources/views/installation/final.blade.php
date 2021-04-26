@extends('installation.layout')

@section('content')
<style>
  #fix_height{
    height: 180px;
    overflow-y: auto;
  }
</style>
<div class="container">
    <center><h2 class="text-light">Mandala CRM Installation</h2></center>
    <center><h3 class="text-light">Welcome To The Setup Wizard</h3></center>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <label for="">Output of the commands running on the server:</label>
                <pre  id="fix_height" class="bg-dark text-light">
                  @php
                      print_r(@$artisan_op);
                  @endphp
                </pre>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <form action="{{url('install/final')}}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <label for="env">.env file data (update, if something is wrong!, you can also update this file later in the root directory)</label>
              <textarea name="env" class="form-control bg-dark text-light" id="" cols="30" rows="8">{{$contents}}</textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Admin Email</label>
                <input type="email" name="email" class="form-control" required />
                
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Admin Password</label>
                <input type="password" name="password" class="form-control" required/>
              </div>
            </div>
          </div>
          <input type="submit" value="Install" class="btn btn-primary btn-block btn-sm">
        </form>
      </div>
    </div>
</div>
@endsection