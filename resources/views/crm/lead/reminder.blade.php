@extends('crm.layouts.app')

@section('styles')
<style>
	.card-img-top {
					text-align: center;
					max-height: 80px;
					max-width: 80px;
	}
</style>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            @include('crm.lead.common.lead_inner_sidebar')
            <div class="col-md-9">
							<div class="card" id="new_reminder_card">
								<div class="card-header bg-gray">
									<h4 class="card-title">{{__('Reminder')}}</h4>
								</div>
								<form action="{{url('reminder/store')}}" method="post">
									@csrf
									<input type="hidden" name="relation" value="Lead">
									<input type="hidden" name="lead_customer_id" value="{{$lead->id}}">
									<div class="card-body bg-light-gray">
											<div class="row">
													<div class="col-md-6">
															<div class="form-group">
																	<label for="">{{__('Description')}} </label>
																	<textarea name="description" class="form-control form-control-sm" rows="4"
																			placeholder="{{__('Description here')}}" required></textarea>
															</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="">{{__('Date')}}</label>
															<input type="date" class="form-control form-control-sm" name="date">
														</div>
														<div class="form-group">
															<label for="">{{__('Time')}}</label>
															<input type="time" class="form-control form-control-sm" name="time">
														</div>
													</div>
													<div class="col-md-3">
															<div class="form-group">
																	<label for="">{{__('User')}}</label>
																	<select name="user_id" class="form-control form-control-sm">
																			@foreach ($users as $user)
																			<option value="{{$user->id}}">{{$user->name}}</option>
																			@endforeach
																	</select>
															</div>
														
													</div>
											</div>

											<div id="repeat_window_show"></div>
											<div class="row">
													<div class="col-md-6 com-sm-12 mt-3">
															<button class="btn btn-primary btn-block ">
																	{{__('Save Reminder')}}
															</button>
													</div>
													<div class="col-md-6 com-sm-12 mt-3">
														<input type="submit" name="send_email" value="Save & Email Reminder" class="btn btn-primary btn-block">
													</div>
											</div>
									</div>
								</form>
							</div>
							<div class="card card-secondary">
								<div class="card-header">
										<h3 class="card-title">{{__('Manage reminders')}}</h3>
								</div>
								<div id="new_reminder_window"></div>
								<div class="card-body">
									<div class="table-responsive">
									<table class="table table-bordered table-striped">
										<thead>
											<th>{{__('ID')}}</th>
											<th>{{__('Description')}}</th>
											<th>{{__('Date')}}</th>
											<th>{{__('Time')}}</th>
											<th>{{__('User')}}</th>
											<th>{{__('Actions')}}</th>
										</thead>
										<tbody>
											@foreach ($reminders as $reminder)
													<tr>
														<td>{{$reminder->id}}</td>
														<td>{{$reminder->description}}</td>
														<td>{{$reminder->date}}</td>
														<td>{{$reminder->time}}</td>
														<td>{{$reminder->user->name}}</td>
													
														<td>
															<span>
																@can('update-lead', User::class)
																	<a class="pr-2" href="#" data-toggle="modal" data-target="#editreminder{{$reminder->id}}">
																		<i class="fas fa-edit"></i>
																	</a>
																	{{-- Edit Modal starts --}}
																	<div class="modal fade bd-example-modal-lg" id="editreminder{{$reminder->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
																			<div class="modal-dialog modal-lg">
																					<div class="modal-content">
																					<form method="POST" action="{{url('reminder/update', $reminder)}}">
																						@csrf
																						@method('PUT')	
																						<input type="hidden" name="relation" value="Lead">
																						<input type="hidden" name="lead_customer_id" value="{{$lead->id}}">
																						<div class="card-body">
																								<div class="row">
																										<div class="col-md-9">
																												<div class="form-group">
																														<label for="">{{__('Description')}} </label>
																														<textarea name="description" class="form-control" rows="4" required>{{$reminder->description}}</textarea>
																												</div>
																												<div class="col-md-12  pt-4">
																													<label class="cl-switch ios">
																														<span class="label" for="send_email_modal{{$reminder->id}}">{{__('Send Email?')}}</span>
																														<input type="checkbox" name="send_email" id="send_email_modal{{$reminder->id}}" value="yes" 
																														@if ($reminder->send_email == 'yes')
																															checked
																														@endif>
																														<span class="switcher"></span>
																														</label>
																										
																												</div>
																										</div>
																										<div class="col-md-3">
																											<div class="form-group">
																												<label for="">{{__('Date')}}</label>
																												<input type="date" class="form-control form-control-sm" name="date" value="{{$reminder->date}}">
																											</div>
																											<div class="form-group">
																												<label for="">{{__('Time')}}</label>
																												<input type="time" class="form-control form-control-sm" name="time" value="{{$reminder->time}}">
																											</div>
																											<div class="form-group">
																												<label for=""><span class="text-danger">*</span> {{__('User')}} </label>
																												<select name="user_id" class="form-control form-control-sm" required>
																														@foreach ($users as $user)
																														@if ($reminder->user_id == $user->id)
																															<option value="{{$user->id}}" selected>{{$user->name}}</option>
																														@else
																															<option value="{{$user->id}}">{{$user->name}}</option>
																														@endif
																														@endforeach
																												</select>
																										</div>
																										</div>
																		
																										

																								</div>
																								<div class="row">
																										<div class="col-md-12 com-sm-12 mt-3">
																												<button class="btn btn-primary btn-block ">
																														{{__('Update Reminder')}}
																												</button>
																										</div>
																								</div>
																								
																						</div>
																					</form>
																					</div>
																			</div>
																	</div>
																	{{-- edit modal ends --}}
																@endcan

																@can('delete-lead', User::class)
																<span id="delbtn{{@$reminder->id}}"></span>
																	<form id="delete-reminder-{{$reminder->id}}"
																			action="{{ url('reminder/destroy', $reminder) }}"
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
										<tfoot>
											<th>{{__('ID')}}</th>
											<th>{{__('Description')}}</th>
											<th>{{__('Date')}}</th>
											<th>{{__('Time')}}</th>
											<th>{{__('User')}}</th>
											<th>{{__('Actions')}}</th>
										</tfoot>
									</table>
								</div>
								</div>
							</div>
						</div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>


@endsection

@section('scripts')
@include('crm.lead.reminder_js')
@yield('inner_script')
@endsection
