@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">

        <div class="card">
          <div class="card-body">
            {{-- @include('crm.graphs.graph03') --}}
            <center><h1> Welcome {{ Auth::user()->name }} </h1></center>
          </div>
        </div>


      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

