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
                  <h3 class="card-title">{{__('Manage Statusess')}}</h3>
                  <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addTitle">+ {{__('Add Status')}} </button>
                </div>
                <div class="card-body">
                    
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Status Name')}}</th>
                      <th>{{__('Created At')}}</th>
                      <th>{{__('Updated At')}}</th>
                      <th>{{__('Actions')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$lead_statuses as $status)
                            <tr>
                                <td>{{$status->id}}</td>
                                <td>{{$status->name}}</td>
                                <td>{{$status->created_at}}</td>
                                <td>{{$status->updated_at}}</td>
                                <td>
                                    <a href="#" type="button" class="text-primary mr-3" data-toggle="modal" data-target="#editStatus{{$status->id}}"> <i class="fas fa-edit"></i> </a>
                                    <span id="delbtn{{@$status->id}}"></span>
                                    
                                    <form id="delete-status-{{$status->id}}"
                                        action="{{ url('/lead/status/destroy', $status->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </td>

{{-- Edit Modal Starts Here --}}
<div class="modal fade" id="editStatus{{$status->id}}" tabindex="-1" role="dialog" aria-labelledby="addStatusLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
          <h5 class="modal-title" id="addStatusLabel">{{__('Update Status')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('lead/status', $status->id)}}" method="POST">
              @csrf
              <label for="">{{__('Enter a Unique Status')}} </label>
              <p> {{__('Note: This will update the status, wherever it is used!')}} </p>
              <input type="text" name="name" class="form-control" value="{{@$status->name}}" required/>
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
{{-- Edit Modal Ends here --}}
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Status Name')}}</th>
                        <th>{{__('Created At')}}</th>
                        <th>{{__('Updated At')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                    </tfoot>
                  </table>
                  <br>
                  <p class="text-danger"> {{__('Note: It\'s better to update the status than delete,
                    because if you had used the status earlier, than on delete, it will disappear from all those places, wherever you have used it!')}} </p>
                </div>
                <!-- /.card-body -->
              </div>


          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


{{-- All Modal Starts Here --}}
<div class="modal fade" id="addTitle" tabindex="-1" role="dialog" aria-labelledby="addStatusLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addStatusLabel">{{__('Add Status')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('lead/status')}}" method="POST">
              @csrf
              <label for="">{{__('Enter a Unique Status')}} </label>
              <input type="text" name="name" class="form-control" required/>
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

@include('crm.lead.status_js')
@yield('inner_script')
@endsection



