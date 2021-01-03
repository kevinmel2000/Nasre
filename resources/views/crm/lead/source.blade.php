@extends('crm.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Manage Sources')}}</h3>
                  <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addTitle">{{__('+ Add Source')}} </button>
                </div>
                <div class="card-body">
                    
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Source Name')}}</th>
                      <th>{{__('Created At')}}</th>
                      <th>{{__('Updated At')}}</th>
                      <th>{{__('Actions')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$lead_sources as $source)
                            <tr>
                                <td>{{$source->id}}</td>
                                <td>{{$source->name}}</td>
                                <td>{{$source->created_at}}</td>
                                <td>{{$source->updated_at}}</td>
                                <td>
                                    <a href="#" type="button" class="text-primary mr-3" data-toggle="modal" data-target="#editSource{{$source->id}}"> 
                                      <i class="fas fa-edit"></i> </a>

                                    <span id="delbtn{{@$source->id}}"></span>

                                    <form id="delete-source-{{$source->id}}"
                                        action="{{ url('/lead/source/destroy', $source->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </td>
                                <div class="modal fade" id="editSource{{$source->id}}" tabindex="-1" role="dialog" aria-labelledby="addSourceLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content bg-light-gray">
                                        <div class="modal-header bg-gray">
                                          <h5 class="modal-title" id="addSourceLabel">{{__('Update Title')}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="{{url('lead/source', $source->id)}}" method="POST">
                                              @csrf
                                              <label for="">{{__('Enter a Unique Source')}} </label>
                                              <p> {{__('Note: This will update the source, wherever it is used!')}} </p>
                                              <input type="text" name="name" class="form-control" value="{{@$source->name}}" data-validation="required|length" data-validation-length="2-30" required />
                                              @if($errors)
                                                @foreach ($errors->all() as $error)
                                                    <div class="text text-danger">{{ $error }}</div>
                                                @endforeach
                                            @endif
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                              <button type="submit" class="btn btn-info">{{__('Update Title')}}</button>
                                            </div>
                                          </form>
                                      </div>
                                    </div>
                                  </div>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Source Name')}}</th>
                        <th>{{__('Created At')}}</th>
                        <th>{{__('Updated At')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                    </tfoot>
                  </table>
                  <br>
                  <p class="text-danger"> {{__("Note: It's better to update the source than delete,
                    because if you had used the title earlier, than on delete, it will disappear from all those places, wherever you have used it!")}} </p>
                </div>
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>


{{-- All Modal Starts Here --}}
<div class="modal fade" id="addTitle" tabindex="-1" role="dialog" aria-labelledby="addSourceLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
          <h5 class="modal-title" id="addSourceLabel">{{__('Add Title')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('lead/source')}}" method="POST">
              @csrf
              <label for="">{{__('Enter a Unique Title')}} </label>
              <input type="text" name="name" class="form-control" data-validation="length|required" data-validation-length="2-30"/>
              @if($errors)
                @foreach ($errors->all() as $error)
                    <div class="text text-danger">{{ $error }}</div>
                @endforeach
            @endif
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

@section('scripts')
  @include('crm.lead.source_js')
  @yield('inner_script')
@endsection



