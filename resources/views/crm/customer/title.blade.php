@extends('crm.layouts.app')

@section('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">

            <div class="card">
                <div class="card-header bg-gray">
                  <h3 class="card-title">{{__('Manage Titles')}}</h3>
                  <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addTitle">+ {{__('Add Title')}} </button>
                </div>
                <div class="card-body">
                    <p class="text-danger"> {{__('Note: It\'s better to update the title than delete,
                      because if you had used the title earlier, than on delete, it will disappear from all those places, wherever you have used it! ')}}</p>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('ID')}}</th>
                      <th>{{__('Title Name')}}</th>
                      <th>{{__('Created At')}}</th>
                      <th>{{__('Updated At')}}</th>
                      <th>{{__('Actions')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                        @foreach (@$contact_titles as $title)
                            <tr>
                                <td>{{$title->id}}</td>
                                <td>{{$title->name}}</td>
                                <td>{{$title->created_at}}</td>
                                <td>{{$title->updated_at}}</td>
                                <td>
                                  <a href="#" data-toggle="tooltip" data-title="{{$title->created_at->toDayDateTimeString()}}" class="mr-2">
                                    <i class="fas fa-clock text-info"></i>
                                  </a>
                                  <a href="#" data-toggle="tooltip" data-title="{{$title->updated_at->toDayDateTimeString()}}" class="mr-2">
                                    <i class="fas fa-history text-primary"></i>
                                  </a>
                                  
                                    <a href="#" class="text-primary mr-2" data-toggle="modal" data-target="#editTitle{{$title->id}}"> <i class="fas fa-edit"></i> </a>

                                    <span id="delbtn{{@$title->id}}"></span>
                                    <form id="delete-title-{{$title->id}}"
                                        action="{{ url('contact/title/destroy', $title->id) }}"
                                        method="POST"  >
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </td>

{{-- Edit Modal Starts Here --}}
<div class="modal fade" id="editTitle{{$title->id}}" tabindex="-1" role="dialog" aria-labelledby="addTitleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
          <h5 class="modal-title" id="addTitleLabel">{{__('Update Title')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('contact/title', $title->id)}}" method="POST">
              @csrf
              <label for="">{{__('Enter a Unique Title')}} </label>
              <p> {{__('Note: This will update the title, wherever it is used!')}} </p>
              <input type="text" name="name" class="form-control" value="{{@$title->name}}"/>
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
                        <th>{{__('Title Name')}}</th>
                        <th>{{__('Created At')}}</th>
                        <th>{{__('Updated At')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
              </div>


          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


{{-- SECTION Add Title modal Starts Here --}}
<div class="modal fade" id="addTitle" tabindex="-1" role="dialog" aria-labelledby="addTitleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-light-gray">
        <div class="modal-header bg-gray">
          <h5 class="modal-title" id="addTitleLabel">{{__('Add Title')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('contact/title')}}" method="POST">
              @csrf
              <label for="">{{__('Enter a Unique Title ')}}</label>
              <input type="text" name="name" class="form-control"/>
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
{{-- !SECTION ADD Title modal ends here --}}
@endsection

@section('scripts')
@include('crm.customer.title_js')
@endsection



