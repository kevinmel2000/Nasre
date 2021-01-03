<style>
#hide_password{
  display: none;
}  
</style>
<div class="col-md-3">
    <!-- Links Card Starts -->
    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">{{@$lead->first_name}} {{@$lead->last_name}}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
              @if ($route_active == 'show_lead')
                  <a class="nav-link active" href="{{url('/lead/show/'.$lead->id)}}">{{__("Home")}}</a>
              @else
                  <a class="nav-link" href="{{url('/lead/show/'.$lead->id)}}">{{__('Home')}}</a>
              @endif
              
              @if ($route_active == 'lead_proposal')
                  <a class="nav-link active" href="{{url('/lead/'.$lead->id.'/proposals')}}">{{__('Proposals')}}</a>
              @else
                  <a class="nav-link" href="{{url('/lead/'.$lead->id.'/proposals')}}">{{__('Proposals')}}</a>
              @endif

              @if ($route_active == 'lead_task')
                  <a class="nav-link active" href="{{url('/lead/'.$lead->id.'/tasks')}}">{{__('Tasks')}}</a>
              @else
                  <a class="nav-link" href="{{url('/lead/'.$lead->id.'/tasks')}}">{{__('Tasks')}}</a>
              @endif

              @if ($route_active == 'lead_media')
                  <a class="nav-link active" href="{{url('/lead/'.$lead->id.'/media')}}">{{__('Media Files')}}</a>
              @else
                  <a class="nav-link" href="{{url('/lead/'.$lead->id.'/media')}}">{{__('Media Files')}}</a>
              @endif

              @if ($route_active == 'lead_reminder')
                  <a class="nav-link active" href="{{url('/lead/'.$lead->id.'/reminders')}}">{{__('Reminders')}}</a>
              @else
                  <a class="nav-link" href="{{url('/lead/'.$lead->id.'/reminders')}}">{{__('Reminders')}}</a>
              @endif              
              </div>
        </div>
    </div>

    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <h3 class="profile-username text-center">{{ucfirst(@$lead->first_name)}} {{ucfirst(@$lead->last_name)}}</h3>
        <p class="text-muted text-center">{{@$lead->contactTitle->name}}</p>
        <ul class="list-group list-group-unbordered mb-3">
          @can('create-contact', User::class)
            <li class="list-group-item">
              @if (@$lead->leadStatus->name != 'Won')
                <a href="#" data-toggle="modal" data-target="#convertToCustomer{{@$lead->id}}" class="btn btn-success text-bold btn-sm btn-block" >
                  {{__('Convert To Customer')}}
                </a>
              @else 
                <span><i class="fas fa-check text-success"> {{__('Converted Into Customer')}}</i></span>  
              @endif
              {{-- Modal starts --}}
              <div class="modal fade bd-example-modal-lg" id="convertToCustomer{{@$lead->id}}" tabindex="-1" role="dialog" aria-labelledby="convertToCustomer{{@$lead->id}}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content bg-light-gray">
                   
                    <form action="{{url('contact/leadCustomer', $lead)}}" method="POST">
                      @csrf
                      @method('PUT')

                    <div class="modal-header bg-gray">
                      <h5 class="modal-title"> {{__('Convert To Customer')}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <span ><span class="text-danger">*</span> {{__('Username')}} 
                              <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{{__('Client can use this username to login in his account.')}}}"></i> 
                              <i class="fas fa-info-circle text-primary" data-toggle="tooltip" data-placement="top" title="{{__('Username must be in (lowercase a-z 0-9 allowed). No Spaces allowed')}}"></i>                    
                            </span>
                              <input type="text" name="username" class="form-control form-control-sm" placeholder="{{__('Enter a unique username')}}" id="username"  
                              data-validation="required|length|custom" data-validation-regexp="^([a-z0-9]*)$" data-validation-length="2-30" required />
                      
                              <span class="text text-danger" id="username_error">
                                {{@$errors->first('username')}}
                              </span>
                          </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                          <span ><span class="text-danger">*</span> {{__('Password')}}</span>
                          <div class="input-group">
                              <input type="password" id="password" name="password" class="form-control form-control-sm " placeholder="********" data-validation="required" required
                              />
                              <span class="input-group-append">
                               <i id="show_password" class="btn btn-info btn-sm pt-1 fas fa-eye"></i>
                               <i id="hide_password" class=" btn btn-secondary btn-sm pt-1 fas fa-eye-slash "></i>
                              </span>
                          </div>
                          <span class="text text-danger">{{@$errors->first('first_name')}}</span>
                      </div>
                          <div class="col-md-4 col-sm-12">
                            <span><span class="text-danger">*</span> {{__('Title/Position')}}</span>
                            <div class="input-group">
                                <select name="title_id" id="title_id{{@$lead->id}}" class="form-control form-control-sm" required data-validation="required">
                                    <option selected disabled>{{__('Select a Title')}}</option>
                                </select>
                                <div class="input-group-append">
                                  <button type="button" class=" btn  plus-button" data-toggle="modal" data-target="#addTitleModal">
                                    <span data-toggle="tooltip" data-placement="top" title="Add New Title"> + </span>
                                </button>
                            </div>
                            </div>
                            <span class="text text-danger">{{@$errors->first('title_id')}}</span>
                          </div>

                          <div class="col-md-4 col-sm-12">
                              <div class="form-group">
                                  <span ><span class="text-danger"></span> {{__('First Name')}}</span>
                                  <input type="text" name="first_name" class="form-control form-control-sm " placeholder="{{__('Enter Contact\'s First Name')}}" value="{{ @$lead->first_name }}"  
                                  />
                              </div>
                              <span class="text text-danger">{{@$errors->first('first_name')}}</span>
                          </div>
                          <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <span ><span class="text-danger">*</span> {{__('Last Name')}}</span>
                                <input type="text" name="last_name" class="form-control form-control-sm " placeholder="{{__('Enter Contact\'s Last Name')}}" value="{{ @$lead->last_name }}" required 
                                />
                            </div>
                            <span class="text text-danger">{{@$errors->first('last_name')}}</span>
                          </div>
          
          
          
                          <div class="col-md-4 col-sm-12">
                              <div class="form-group">
                                  <span ><span class="text-danger">*</span> {{__('Email')}}</span>
                                  <input type="text" name="email" class="form-control form-control-sm " placeholder="{{__('Enter Contact\'s Email')}}" id="email" value="{{ @$lead->email}}" data-validation="required|email" required/>
                                  <span class="text text-danger" id="email_error">
                                    {{@$errors->first('email')}}
                                  </span>
                              </div>
                          </div>
                        </div>
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                      <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
              {{-- Modal ends --}}

            </li>
          @endcan
          <li class="list-group-item">
            @if (@$lead->leadStatus->name != 'Won')
            <div class="row">
              <div class="col-md-6">
                @if (@$lead->is_dead == 'yes')
                    <i class="fas fa-times text-danger"> {{__('Marked as Dead')}}</i>
                @else 
                  <form action="{{url('lead/markAsDead', $lead)}}" id="markAsDead" method="post">
                    @csrf
                    @method('PUT')
                    <input type="button" id="markAsDeadBtn" class="btn btn-danger btn-sm btn-block" value="Mark as Dead">
                  </form>
                @endif
              </div>
              <div class="col-md-6">
                @if (@$lead->is_poor_fit == 'yes')
                  <i class="fas fa-times text-danger"> {{__('Marked as Poorfit')}}</i>
                @else
                  <form action="{{url('lead/markAsPoorfit', $lead)}}" id="markAsPoorfit" method="post">
                    @csrf
                    @method('PUT')
                    <input type="button" id="markAsPoorfitBtn" class="btn btn-danger btn-sm btn-block" value="Mark as Poor Fit">
                  </form>
                @endif
              </div>
              @if (@$lead->is_poor_fit == 'yes' || @$lead->is_dead == 'yes')
                <div class="col-md-12 mt-3">
                  <form action="{{url('lead/normalize', $lead)}}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="submit" class="btn btn-info btn-sm btn-block" value="Normalize">
                  </form>
                </div>
              @endif
            </div>
          @endif

          </li>

        </ul>
      </div>
    </div>

  </div>


 @section('inner_script')
  @include('crm.lead.common.lead_inner_sidebar_js')    
 @endsection