@extends('crm.layouts.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="content-wrapper">
		<!-- Main content -->
		<section class="content">
				<div class="container-fluid">
						<div class="row">
								<div class="col-md-12">
									<button type="button" class="btn btn-primary btn-sm mb-1" id="addButton">{{__('Add New Task')}}</button>
									<button type="button" class=" btn btn-secondary btn-sm mb-1 d-hide" id="hideButton"> {{__('Hide Task Window')}}</button>
				<div class="card d-hide bg-light-gray" id="new_task_card">
					<form action="{{url('task/store')}}" method="post">
						@csrf
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
										<div class="form-group">
												<label for="">{{__('Task Description')}} </label>
												<textarea name="description" class="form-control form-control-sm" rows="3"
														required></textarea>
										</div>
										<div class="row">
											<div class="col-md-4">
													<div class="form-group">
															<label for=""><span class="text-danger">*</span> {{__('Customer/Lead ?')}} </label>
															<select name="relation"  class="relation form-control form-control-sm"
																	required>
																	<option selected disabled>{{__('Select User Type')}}</option>
																	<option value="{{__('Customer')}}">{{__('Customer')}}</option>
																	<option value="{{__('Lead')}}">{{__('Lead')}}</option>
															</select>
													</div>
											</div>
											<div class="col-md-4">
													<div class="form-group">
															<label for=""><span class="text-danger">*</span>{{__('Select Customer/Lead')}} </label>
															<select name="lead_customer_id" id="lead_customer_id"
																	class="form-control form-control-sm" required>
															</select>
													</div>
											</div>
											<div class="col-md-4">
													<div class="form-group">

															<label for=""><span class="text-danger">*</span> {{__('Sales Agent (Task
																Owner)')}}</label>
															<select name="owner_id" class="form-control form-control-sm" required>
																	@foreach ($salesperson as $user)
																	<option value="{{$user->id}}">{{$user->name}}</option>
																	@endforeach
															</select>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
														<label for="">{{__('Priority')}} </label>
														<select name="priority" class="form-control form-control-sm">
																@php
																$priorities = [
																	__('High'),
																	__('Med'),
																	__('Low')
																];
																@endphp
																@foreach ($priorities as $priority)
																<option value="{{$priority}}">{{$priority}}</option>
																@endforeach
														</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="">{{__('Type')}}</label>
													<select name="type" class="form-control form-control-sm">
															@php
															$types = [
																__('Email'), 
																__('Call'), 
																__('Follow up'), 
																__('Meeting'), 
																__('Letter'), 
																__('Event')
																]
															@endphp
															@foreach ($types as $type)
															<option value="{{$type}}">{{$type}}</option>
															@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="">{{__('Status')}}</label>
													<select name="status" class="form-control form-control-sm">
															@php
															$statusess = [
																__('Waiting'),
																__('Started'), 
																__('In progress'), 
																__('Completed'), 
																__('Rejected')
																]
															@endphp
															@foreach ($statusess as $status)
															<option value="{{$status}}">{{$status}}</option>
															@endforeach
													</select>
												</div>
											</div>
											<div class="col-md-4">
													<div class="form-group">

														{{-- This switch is for next column start and end time --}}
														<label class="cl-switch cl-switch-green floatRight">
															<span class="label" for="is_all_day">{{__('Full Day Task')}}</span>
															<input type="checkbox" name="is_all_day" id="is_all_day" value="yes" checked>
															<span class="switcher float-left mr-2"></span>
														</label>

														<label>{{__('Task Start Date')}}:</label>
														<div class="input-group date" id="date" data-target-input="nearest">
																<input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#date" name="start_date">
																<div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
																		<div class="input-group-text"><i class="fa fa-calendar"></i></div>
																</div>
														</div>
															
													</div>
											</div>

											<div class="col-md-4">
													<div id="is_all_day_show"></div>
											</div>											

											<div class="col-md-4">
												<label class="cl-switch cl-switch-green floatRight">
													<label class="label" for="Billable">{{__('Billable Task')}}</label>
													<input type="checkbox" name="billable" id="billable" value="yes" checked>
													<span class="switcher float-left  mr-2"></span>
												</label>
												<div class="form-group" id="bill_amount_field">
													<label for="">{{__('Bill Amount')}}</label>
													<input type="number" step=".01" name="bill_amount" class="form-control form-control-sm">
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<span class="pr-4">
														<label class="cl-switch cl-switch-green">
															<span class="label" for="repeat_task">{{__('Repeat Task')}}</span>
															<input type="checkbox" name="repeat_task" id="repeat_task" value="yes">
															<span class="switcher float-left mr-2"></span>
															</label>
													</span>
												</div>									
											</div>

										</div>
								</div>

							</div>

							<div id="repeat_window_show"></div>
							<div class="row">
									<div class="col-md-6 com-sm-12 mt-3">
											<button class="btn btn-primary btn-block ">
													{{__('Save Task')}}
											</button>
									</div>
									<div class="col-md-6 com-sm-12 mt-3">
										<input type="submit" name="send_email" value="{{__('Save & Send Email')}}" class="btn btn-primary btn-block">
									</div>
								
							</div>
						</div>
					</form>
				</div>
	
										<div class="card card-secondary">
												<div class="card-header bg-gray">
														<h3 class="card-title">{{__('Manage Tasks')}}</h3>
												</div>
												<div id="new_task_window"></div>
												<div class="card-body">
													<div class="table-responsive">
													<table id="tasksTable" class="table table-bordered table-striped">
														<thead>
															<th>{{__('ID')}}</th>
															<th>{{__('Task')}}</th>
															<th>{{__('Start Date')}}</th>
															<th>{{__('Type')}}</th>
															<th>{{__('Status')}}</th>
															<th>{{__('Priority')}}</th>
															<th>{{__('Sales Agent')}}</th>
															<th>{{__('Actions')}}</th>
														</thead>
														<tbody>
															@foreach ($tasks as $task)
																	<tr>
																		<td>{{@$task->id}}</td>
																		<td>{{@$task->description}}</td>
																		<td>{{@$task->start_date}}</td>
																		<td>{{@$task->type}}</td>
																		<td>{{@$task->status}}</td>
																		<td>{{@$task->priority}}</td>
																		<td>{{@$task->owner->name}}</td>
																		<td>
																			<span>
																				<a class="text-secondary mr-2" href="{{url('task/email/'.$task->id )}}">
																					<i class="fas fa-mail-bulk"></i>
																				</a>	
																				@can('update-lead', User::class)
																				
																				<a class="text-primary mr-2" href="#" data-toggle="modal" data-target="#editTask{{$task->id}}">
																						<i class="fas fa-edit"></i>
																					</a>

{{-- Edit Modal starts --}}
<div class="modal fade bd-example-modal-lg" id="editTask{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">

    <div class="modal-content bg-light-gray">
			<div class="modal-header bg-gray">
				{{__('Task Edit')}} &nbsp;  #{{$task->id}}
			</div>
				<form method="POST" action="{{url('task/update', $task)}}">
					@csrf
					@method('PUT')	
					<div class="card-body">
							<div class="row">
									<div class="col-md-12">
											<div class="form-group">
													<label for="">{{__('Task Description')}} </label>
													<textarea name="description" class="form-control" rows="2" required>{{$task->description}}</textarea>
											</div>
									</div>
							</div>
							<div class="row">
									<div class="col-md-4">
										<div class="form-group">
												<label>Type</label>
												<select name="type" id='type{{$task->id}}' class="form-control flex-fill">
														@php
															$types = [
																__('Email'), 
																__('Call'), 
																__('Follow up'), 
																__('Meeting'), 
																__('Letter'), 
																__('Event')
																]
														@endphp
														@foreach ($types as $type)
															@if ($task->type == $type)
																<option value="{{$type}}" selected>{{$type}}</option>
															@else
																<option value="{{$type}}">{{$type}}</option>
															@endif
														@endforeach
												</select>
										</div>

								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">{{__('Status')}}</label>
										<select name="status" class="form-control" id="status{{$task->id}}">
												@php
													$statusess = [
														__('Waiting'),
														__('Started'), 
														__('In progress'), 
														__('Completed'), 
														__('Rejected')
														]
												@endphp
												@foreach ($statusess as $status)
													@if ($task->status == $status)
														<option value="{{$status}}" selected>{{$status}}</option>
													@else
														<option value="{{$status}}">{{$status}}</option>
													@endif
												@endforeach
										</select>
								</div>
								</div>
								<div class="col-md-4">
										<div class="form-group">
												<label for=""><span class="text-danger">*</span> {{__('Customer/Lead')}} ? </label>
												<select name="relation" id="relation_modal{{$task->id}}"
													{{$update_relation_js[$task->id]}}  
													class="form-control form-control-sm" required >
														@php
																$relations = [
																	__('Customer'),
																	__('Lead')
																];
														@endphp
														@foreach ($relations as $relation)
															@if ($task->relation == $relation)
																<option value="{{$relation}}" selected>{{$relation}}</option>
															@else
																<option value="{{$relation}}">{{$relation}}</option>
															@endif
														@endforeach
												</select>
										</div>
								</div>
								<div class="col-md-4">
										<div class="form-group">
												<label for=""><span class="text-danger">*</span>{{__('Select Customer/Lead')}} </label>
												<select name="lead_customer_id" id="lead_customer_id_modal{{$task->id}}" class=" form-control form-control-sm" required>
													@if ($task->relation == 'Customer')
													@foreach ($customers as $customer)
																	@if ($task->customer_id == $customer->id)
																		<option value="{{$customer->id}}" selected>{{$customer->username}}</option>
																	@else 
																		<option value="{{$customer->id}}">{{$customer->username}}</option>	
																	@endif
													@endforeach
													@elseif($task->relation == 'Lead')				
														@foreach ($leads as $lead)
															@if ($task->lead_id == $lead->id)
																<option value="{{$lead->id}}" selected>{{$lead->first_name}} {{$lead->last_name}}</option>
															@else 
																<option value="{{$lead->id}}">{{$lead->first_name}} {{$lead->last_name}}</option>	
															@endif
														@endforeach
													@endif
												</select>
										</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for=""><span class="text-danger">*</span> {{__('Sales Agent (Task Owner)')}}</label>
										<select name="owner_id" class="form-control form-control-sm" required>
												@foreach ($salesperson as $user)
												@if ($task->owner_id == $user->id)
													<option value="{{$user->id}}" selected>{{$user->name}}</option>
												@else
													<option value="{{$user->id}}">{{$user->name}}</option>
												@endif
												@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
											<label for="">{{__('Priority')}} </label>
											<select name="priority" class="form-control form-control-sm">
													@php
													$priorities = [
														__('High'),
														__('Med'),
														__('Low')
													];
													@endphp
													@foreach ($priorities as $priority)
														@if ($task->priority == $priority)
															<option value="{{$priority}}" selected>{{$priority}}</option>
														@else
															<option value="{{$priority}}">{{$priority}}</option>
														@endif
													@endforeach
											</select>
									</div>
								</div>
								<div class="col-md-4">
										<div class="form-group">
											<label>{{__('Task Start Date')}}:</label>
											{{-- Label for next time column --}}
											<span class="floatRight">
												<label class="cl-switch cl-switch-green">
													<span class="label" for="is_all_day_modal{{$task->id}}">{{__('Full Day Task')}}</span>
													<input type="checkbox" name="is_all_day" id="is_all_day_modal{{$task->id}}" value="yes"  
													{{$full_day_js[$task->id]}}
													@if ($task->is_all_day == 'yes')
														checked
													@endif>
													<span class="switcher"></span>
												</label>
											</span>
												<div class="input-group date" id="start_date{{$task->id}}" data-target-input="nearest" >
														<input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#start_date{{$task->id}}" name="start_date" value="{{$task->start_date}}" >
														<div class="input-group-append" data-target="#start_date{{$task->id}}" data-toggle="datetimepicker">
																<div class="input-group-text" {{$start_date_js[$task->id]}}><i class="fa fa-calendar"></i></div>
														</div>
												</div>
												
										</div>
								</div>
								<div class="col-md-4">
									<div id="is_all_day_show_modal{{$task->id}}">
										@if ($task->is_all_day == 'no')
										{{-- If task is full day --}}
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>{{__('Start Time')}}:</label>
														<div class="input-group date">
																<input type="time" class="form-control form-control-sm datetimepicker-input"  name="start_time" value="{{$task->start_time}}" />
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<label>{{__('End Time')}}:</label>
														<div class="input-group date">
																<input type="time" class="form-control form-control-sm datetimepicker-input" name="end_time" value="{{$task->end_time}}" />
														</div>
												</div>
											</div>
										@endif											
									</div>
								</div>
								
								<div class="col-md-4">
									<label class="cl-switch cl-switch-green floatRight">
										<span class="label" for="billable_modal{{$task->id}}">{{__('Billable')}}</span>
										<input type="checkbox" name="billable" id="billable_modal{{$task->id}}" 	value="yes" 
										{{$billable_js[$task->id]}}
										@if($task->billable == 'yes')
											checked
										@endif
										>
										<span class="switcher"></span>
									</label>
									<div 
									@if ($task->billable == 'yes')
										class="form-group d-show"  
									@else 
										class="form-group d-hide" 
									@endif
									id="bill_amount_modal{{$task->id}}"
									>
										<label for="">{{__('Bill Amount')}}</label>
										<input type="number" name="bill_amount" step=".01"  value="{{@$task->bill_amount}}" class="form-control form-control-sm">
									</div>
								</div>								
							</div>
							<label class="cl-switch cl-switch-green">
								<span class="label" for="repeat_task_modal{{$task->id}}">{{__('Repeat Task')}}</span>
								<input type="checkbox" name="repeat_task" id="repeat_task_modal{{$task->id}}" value="yes"
								{{$repeat_task_js[$task->id]}}
								@if ($task->repeat_task == 'yes')
										checked
								@endif>
								<span class="switcher"></span>
							</label>
								<div id="repeat_window_show_modal{{$task->id}}"></div>
								{{-- If repeat task is on --}}
								@if ($task->repeat_task == 'yes')
									<div class="card" id="repeat_window_show_modal_pre_valued{{$task->id}}">
										<div class="card-body bgcolor1">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label for="">{{__('Repeat Every')}}</label>
														<select name="repeat_every" class="form-control form-control-sm">
															@php
																	$repeats = [
																		__('week'),
																		__('day'), 
																		__('month'), 
																		__('year')
																	];
															@endphp
															<option value="none" selected>{{__('None')}}</option>
															@foreach ($repeats as $repeat)
																@if ($task->repeat_every == $repeat)
																	<option value="{{$repeat}}" selected>{{$repeat}}</option>
																@else
																	<option value="{{$repeat}}">{{$repeat}}</option>
																@endif
																	
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="">{{__('Repeat on a specific Day of the Month(dd/mm/yyyy)')}}</label>
														<input type="date" name="repeat_day_month" class="form-control form-control-sm" value="{{$task->repeat_day_month}}">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="">{{__('Ends on')}}</label>
														<input type="date" name="end_date" class="form-control form-control-sm" value="{{$task->end_date}}">
													</div>
												</div>
											</div>
										</div>
									</div>										
								@endif								
							<div class="row">
									<div class="col-md-6 com-sm-12 mt-3">
											<button class="btn btn-primary btn-block ">
													{{__('Update Task')}}
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
																				<span id="delbtn{{@$task->id}}"></span>
																					<form id="delete-task-{{$task->id}}"
																							action="{{ url('task/destroy', $task) }}"
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
															<th>{{__('Task')}}</th>
															<th>{{__('Start Date')}}</th>
															<th>{{__('Type')}}</th>
															<th>{{__('Status')}}</th>
															<th>{{__('Priority')}}</th>
															<th>{{__('Sales Agent')}}</th>
															<th>{{__('Actions')}}</th>
														</tfoot>
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


{{-- ANCHOR MODAL VIEW task --}}

@endsection

@section('scripts')
@include('crm.task.index_js')
@endsection
