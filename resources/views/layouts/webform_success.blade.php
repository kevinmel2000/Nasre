@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1>Your request is submitted successfully</h1>
      
      <a href="{{ @$url }}">Go To Home</a>
    </div>
  </div>
</div>

@endsection