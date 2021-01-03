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
										<div class="card" id="new_reminder_card">
											<form action="{{url('reminder/store')}}" method="post">
												@csrf
												<div class="card-body bg-light-gray">
														<div class="row">
																<div class="col-md-9">
																		<div class="form-group">
																				<label for="">{{__('Description')}} </label>
																				<textarea name="description" class="form-control form-control-sm" rows="4"
																						 required></textarea>
																		</div>
																		<div class="row">
																			<div class="col-md-6">
																				<div class="form-group">
																						<label for=""><span class="text-danger">*</span>{{__('Reminder for Customer/Lead ?')}} </label>
																						<select name="relation"  class="relation form-control form-control-sm"
																								required>
																								<option selected disabled>{{__('Select User Type')}}</option>
																								<option value="{{__('Customer')}}">{{__('Customer')}}</option>
																								<option value="{{__('Lead')}}">{{__('Lead')}}</option>
																						</select>
																				</div>
																		</div>
																		<div class="col-md-6">
																				<div class="form-group">
																						<label for=""><span class="text-danger">*</span>{{__('Select Customer/Lead')}} </label>
																						<select name="lead_customer_id" id="lead_customer_id"
																								class="form-control form-control-sm" required>
																						</select>
																				</div>
																		</div>
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

																	<div class="form-group">
																		<label>{{__('Date')}}:</label>
																			<div class="input-group date" id="date" data-target-input="nearest">
																					<input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="date">
																					<div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
																							<div class="input-group-text"><i class="fa fa-calendar"></i></div>
																					</div>
																			</div>
																	</div>

																	<div class="form-group">
																		<label>{{__('Time')}}:</label>
																		<div class="input-group date" id="time" data-target-input="nearest">
																				<input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#time"  name="time"/>
																				<div class="input-group-append" data-target="#time" data-toggle="datetimepicker">
																						<div class="input-group-text"><i class="fas fa-clock"></i></div>
																				</div>
																		</div>
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
																	<input type="submit" name="send_email" value="{{__('Save & Email Reminder')}}" class="btn btn-primary btn-block">
																</div>
														</div>
												</div>
											</form>
										</div>
	
										<div class="card card-secondary">
												<div class="card-header">
														<h3 class="card-title">{{__('Manage Reminders')}}</h3>
												</div>
												<div id="new_reminder_window"></div>
												<div class="card-body">
													<div class="table-responsive">
													<table id="remindersTable" class="table table-striped table-bordered">
														<thead>
															<th>{{__('ID')}}</th>
															<th>{{__('Reminder For')}}</th>
															<th>{{__('Description')}}</th>
															<th>{{__('Date')}}</th>
															<th>{{__('Time')}}</th>
															<th>{{__('User')}}</th>
															<th>{{__('Actions')}}</th>
														</thead>
														<tbody>
															@foreach ($reminders as $reminder)
																	<tr>
																		<td>{{@$reminder->id}}</td>
																		<td>
																			@if (@$reminder->relation == 'Customer')
																							{{@$reminder->customer->username}}
																			@else
																							{{@$reminder->lead->first_name}} {{@$reminder->lead->last_name}}
																			@endif
																		</td>
																		<td>{{@$reminder->description}}</td>
																		<td>{{@$reminder->date}}</td>
																		<td>{{@$reminder->time}}</td>
																		<td>{{@$reminder->user->name}}</td>
																		
																		<td>
																			<span>
																				<a class="text-secondary mr-2" href="{{url('reminder/email/'.$reminder->id )}}">
																					<i class="fas fa-mail-bulk"></i>
																				</a>
																				@can('update-lead', User::class)
																					<a class="text-primary mr-2" href="#" data-toggle="modal" data-target="#editreminder{{$reminder->id}}">
																						<i class="fas fa-edit"></i>
																					</a>
																					{{-- Edit Modal starts --}}
																					<div class="modal fade bd-example-modal-lg" id="editreminder{{$reminder->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
																							<div class="modal-dialog modal-lg">
																									<div class="modal-content bg-light-gray">
																									<form method="POST" action="{{url('reminder/update', $reminder)}}">
																										@csrf
																										@method('PUT')	
																										<div class="card-body">
																												<div class="row">
																														<div class="col-md-9">
																																<div class="form-group">
																																		<label for="">{{__('Description')}} </label>
																																		<textarea name="description" class="form-control" rows="4" required>{{@$reminder->description}}</textarea>
																																</div>
																																<div class="row">
																																		<div class="col-md-6">
																																			<div class="form-group">
																																					<label for=""><span class="text-danger">*</span> {{__('Customer/Lead ?')}} </label>
																																					<select name="relation" id="relation{{$reminder->id}}" class="form-control form-control-sm relation" required>
																																							@php
																																									$relations = ['Customer','Lead'];
																																							@endphp
																																							@foreach ($relations as $relation)
																																								@if ($reminder->relation == $relation)
																																									<option value="{{@$relation}}" selected>{{$relation}}</option>
																																								@else
																																									<option value="{{@$relation}}">{{$relation}}</option>
																																								@endif
																																							@endforeach
																																					</select>
																																			</div>
																																	</div>
																																	<div class="col-md-6">
																																			<div class="form-group">
																																					<label for=""><span class="text-danger">*</span>{{__('Select Customer/Lead')}} </label>
																																					<select name="lead_customer_id" id="lead_customer_id{{$reminder->id}}" class="lead_customer_id form-control form-control-sm" required >
																																						@if ($reminder->relation == 'Customer')
																																							@foreach ($customers as $customer)
																																											@if ($reminder->customer_id == $customer->id)
																																												<option value="{{@$customer->id}}" selected>{{@$customer->username}}</option>
																																											@else 
																																												<option value="{{$customer->id}}">{{@$customer->username}}</option>	
																																											@endif
																																							@endforeach
																																						@elseif(@$reminder->relation == 'Lead')				
																																							@foreach ($leads as $lead)
																																								@if (@$reminder->lead_id == @$lead->id)
																																									<option value="{{$lead->id}}" selected>{{@$lead->first_name}} {{@$lead->last_name}}</option>
																																								@else 
																																									<option value="{{$lead->id}}">{{@$lead->first_name}} {{@$lead->last_name}}</option>	
																																								@endif
																																							@endforeach
																																						@endif
																																					</select>
																																			</div>
																																	</div>
																																</div>
																														</div>
																														<div class="col-md-3">
			<div class="form-group">
				<label>{{__('Date')}}:</label>
					<div class="input-group date" id="date{{$reminder->id}}" data-target-input="nearest" >
							<input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date{{$reminder->id}}" name="date" value="{{$reminder->date}}" >
							<div class="input-group-append" data-target="#date{{$reminder->id}}" data-toggle="datetimepicker">
									<div class="input-group-text" ><i class="fa fa-calendar"></i></div>
							</div>
					</div>
			</div>

			<div class="form-group">
				<label>{{__('Time')}}:</label>
				<div class="input-group date" id="time{{$reminder->id}}" data-target-input="nearest">
						<input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#time{{$reminder->id}}"  name="time" value="{{$reminder->time}}" />
						<div class="input-group-append" data-target="#time{{$reminder->id}}" data-toggle="datetimepicker">
								<div class="input-group-text" ><i class="fas fa-clock"></i></div>
						</div>
				</div>
			</div>
																															<div class="form-group">
																																<label for=""><span class="text-danger">*</span> {{__('User')}} </label>
																																<select name="user_id" class="form-control form-control-sm" required>
																																		@foreach ($users as $user)
																																		@if (@$reminder->user_id == $user->id)
																																			<option value="{{@$user->id}}" selected>{{@$user->name}}</option>
																																		@else
																																			<option value="{{@$user->id}}">{{@$user->name}}</option>
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
													
													</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		</section>
</div>


{{-- ANCHOR MODAL VIEW reminder --}}

@endsection

@section('scripts')

@include('crm.reminder.index_js')

@endsection
