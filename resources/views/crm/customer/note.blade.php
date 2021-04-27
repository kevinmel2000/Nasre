@extends('crm.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="container-fluid">
    <div class="row">
      @include('crm.customer.common.contact_inner_sidebar')
      <div class="col-md-9">
        
          <form method="POST" action={{url('/customer/note')}}>
            @csrf
            @method('PUT')
            <div class="card">
              <div class="card-header bg-gray">
                <span class="float-left">{{__('Customer Notes')}}</span>
                <a class="card-title bg-primary pl-2 pr-2 rounded float-right" href="#" id="addNewNote">{{__('New Note')}}</a>
              </div>
              
              <div class="card-body bg-light-gray">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="contact-details-id" role="tabpanel" aria-labelledby="contact-details">
                    <div class="row">
                      <div class="col-md-12">
                        <div id="noteField"></div>
                        <div id="newNotes"></div>
                        @foreach ($notes as $note)
                          <div class="card" id='noteCard{{@$note->id}}'>
                            <div>
                              <div class="card-item">
                                <p class="card-header">{{__('Added By')}} - {{@$note->user['name']}} 
                                <span class="float-right">
                                  {{@$note->created_at}}
                                </span>
                                </p>
                                <div class="card-body">
                                  {{$note->note}}
                                </div>
                                <div class="card-footer">
                                  <span  id="delbtn{{@$note->id}}"></span>
                                </div>
                              </div>
                            </div>
                          </div>                            
                        @endforeach
                        

                        
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
             
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


@endsection


@section('scripts')
@include('crm.customer.note_js')
  
@endsection