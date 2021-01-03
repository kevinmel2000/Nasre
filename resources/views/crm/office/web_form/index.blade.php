@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
      <div class="card card-secondary">
        <div class="card-header bg-gray">
          <h2 class="card-title card-primary">{{__('Web to Lead Form')}}</h2>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table id="webformsTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{__('Form Title')}}</th>
                    <th>{{__('Heading')}}</th>
                    <th>{{__('iframe')}}</th>
                    <th>{{__('Actions')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach (@$web_forms as $web_form)
                          <tr>
                            <td>{{@$web_form->title}}</td>
                            <td>{{@$web_form->heading}}</td>
                            <td>@php
                              $url = url('form/'.@$web_form->token);
                          @endphp
                          <code class="text-secondary">{{ '<iframe width="600px" height="500px" src="'.$url.'" frameborder="0" allowfullscreen></iframe>' }}
                          </code></td>
                              <td>
                                <span>
                                  @can('update-office', User::class)
                                  
                                  <a href="#" class="text-primary mr-3" data-toggle="modal" data-target="#editTaxRate{{$web_form->id}}"> 
                                      <i class="fas fa-edit"></i> 
                                  </a>

                                  {{-- SECTION Edit Modal Starts Here --}}
                                  <div class="modal fade" id="editTaxRate{{$web_form->id}}" tabindex="-1" role="dialog" aria-labelledby="addtaxRateLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                      <div class="modal-content bg-light-gray">
                                          <div class="modal-header bg-gray">
                                          <h5 class="modal-taxRate" id="addtaxRateLabel">{{__('Form Layout and fields')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          </div>
                                          <div class="modal-body">
                                            {!! $web_form->formdata !!}
                                          </div>
                                      </div>
                                  </div>
                                </div>
                                  {{-- !SECTION Edit Modal Ends here --}}

                                  @endcan

                                  @can('delete-office', User::class)
                                    <span id="delbtn{{@$web_form->id}}"></span>
                                    <form id="delete-web_form-{{$web_form->id}}"
                                        action="{{ url('office/web_form/destroy', $web_form) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                  @endcan  
                                </span>
                              </td>

                          </tr>
                      @endforeach
                  </tbody>
                  
                </table>
                
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/sortable.js')}}"></script>
@include('crm.office.web_form.index_js')
@endsection