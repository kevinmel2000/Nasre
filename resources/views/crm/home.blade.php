@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">

        <div class="card">
          <div class="card-body">
            @include('crm.graphs.graph03')
          </div>
        </div>

        <div class="row">
          <div class="col-md-7">
            @include('crm.graphs.graph01')
          </div>
          <div class="col-md-5">
            @include('crm.graphs.graph06')
          </div>
        </div>

        @include('crm.graphs.graph05')

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('scripts')
  @yield('script_graph01')
  @yield('script_graph03')
  @yield('script_graph05')
  @yield('script_graph06')
@endsection