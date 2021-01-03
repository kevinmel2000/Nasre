@extends('crm.layouts.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<style>
.bg1{
	background-color: #eedfdf	
}	
</style>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            @include('crm.customer.common.contact_inner_sidebar')
            <div class="col-md-9">
										<div class="card" id="new_task_card">
                      <div class="card-header bg-gray">
                        <h3 class="card-title">{{__('New Task')}}</h3>
                    </div>
											<form action="{{url('task/store')}}" method="post">
												@csrf
												<input type="hidden" name="relation" value="Customer">
												<input type="hidden" name="lead_customer_id" value="{{@$customer->id}}">

												<div class="card-body bg-light-gray">
													<div class="row">
														<div class="col-md-9">
																<div class="form-group">
																		<label for="">{{__('Task Description')}} </label>
																		<textarea name="description" class="form-control form-control-sm" rows="4"
																				placeholder="Task description here" required></textarea>
																</div>
	
																<div class="row">
															
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
																					$priorities = ['High','Med','Low'];
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
																			$types = ['Email', 'Call', 'Follow up', 'Meeting', 'Letter', 'Event']
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
																			$statusess = ['Waiting' ,'Started', 'In progress', 'Completed', 'Rejected']
																			@endphp
																			@foreach ($statusess as $status)
																			<option value="{{$status}}">{{$status}}</option>
																			@endforeach
																	</select>
																</div>
															</div>
																<div class="col-md-4">
																		<div class="form-group">
																				<label for="">{{__('Task Start Date')}} </label>
																				<input type="date" name="start_date" class="form-control form-control-sm" required />
																		</div>
																</div>
		
															</div>

			
														</div>
														<div class="col-md-3 mt-2">
																		
																		<div class="form-group">
																			<label class="cl-switch cl-switch-green">
																				<label class="label" for="Billable">{{__('Billable Task')}}</label>
																				<input type="checkbox"  name="billable" id="billable" value="yes" checked>
																				<span class="switcher float-left  mr-2"></span>
																			</label>
																		</div>
																		<div class="form-group" id="bill_amount_field">
																			<label for="">{{__('Task Bill Amount')}}</label>
																			<input type="number" step="0.01" name="bill_amount" class="form-control form-control-sm">
																		</div>
																		<div class="form-group">
																			<label class="cl-switch cl-switch-green">
																					<span class="label" for="is_all_day">{{__('Full Day Task')}}</span>
																					<input type="checkbox" name="is_all_day" id="is_all_day" value="yes" checked>
																					<span class="switcher float-left mr-2"></span>
																			</label>
																			<div id="is_all_day_show"></div>
																		</div>
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
														<div id="repeat_window_show"></div>
														<div class="col-md-6 com-sm-12 mt-3">
																<button class="btn btn-primary btn-block ">
																		{{__('Save Task')}}
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
														<h3 class="card-title">{{__('Manage tasks')}}</h3>
														
												</div>
												<div id="new_task_window"></div>
												<div class="card-body">
													<div class="table-responsive">
													<table class="table table-bordered table-striped">
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
																		<td>{{$task->id}}</td>
																		<td>{{$task->description}}</td>
																		<td>{{$task->start_date}}</td>
																		<td>{{$task->type}}</td>
																		<td>{{$task->status}}</td>
																		<td>{{$task->priority}}</td>
																		<td>{{$task->owner->name}}</td>
																		<td>
																			<span>
																				@can('update-lead', User::class)
																					<a class="text-primary pr-2" href="#" data-toggle="modal" data-target="#editTask{{$task->id}}">
																						<i class="fas fa-edit"></i>
																					</a>

{{-- Edit Modal starts --}}
<div class="modal fade bd-example-modal-lg" id="editTask{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
				<form method="POST" action="{{url('task/update', $task)}}">
					@csrf
					@method('PUT')	
					<div class="card-body">
							<div class="row">
									<div class="col-md-9">
											<div class="form-group">
													<label for="">{{__('Task Description')}} </label>
													<textarea name="description" class="form-control" rows="4" required>{{$task->description}}</textarea>
											</div>
									</div>
									<div class="col-md-3">
											<div class="form-group">
													<label>{{__('Type')}}</label>
													<select name="type" id='type{{$task->id}}' class="form-control flex-fill">
															@php
																$types = ['Email', 'Call', 'Follow up', 'Meeting', 'Letter', 'Event']
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
											<div class="form-group">
													<label for="">{{__('Status')}}</label>
													<select name="status" class="form-control" id="status{{$task->id}}">
															@php
																$statusess = ['Waiting' ,'Started', 'In progress', 'Completed', 'Rejected']
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
							</div>
							<div class="row">
								<input type="hidden" name="relation" value="Customer">
								<input type="hidden" name="lead_customer_id" value="{{$customer->id}}">
									<div class="col-md-3">
											<div class="form-group">
			
													<label for=""><span class="text-danger">*</span> {{__('Sales Agent (Task
														Owner)')}}</label>
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
									<div class="col-md-3">
										<div class="form-group">
												<label for="">{{__('Priority')}} </label>
												<select name="priority" class="form-control form-control-sm">
														@php
														$priorities = ['High','Med','Low'];
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
									<div class="col-md-3">
											<div class="form-group">
													<label for="">{{__('Task Start Date')}} </label>
													<input type="date" name="start_date" class="form-control form-control-sm" required value="{{$task->start_date}}"/>
											</div>
									</div>
									
									<div class="col-md-3 ">
										<div class="form-group">
											<label class="cl-switch cl-switch-green">
												<span class="label" for="is_all_day_modal{{$task->id}}">{{__('All Day')}}</span>
												<input type="checkbox" name="is_all_day" onchange="is_all_day_modal({{$task->id}})" id="is_all_day_modal{{$task->id}}" value="yes"  
												@if ($task->is_all_day == 'yes')
													checked
												@endif>
												<span class="switcher"></span>
												</label>
						
											@if ($task->is_all_day == 'no')
											<div class="form-group">
												<input type="time" name="start_time" id="start_time{{$task->id}}" value="{{@$task->start_time}}" class="form-control form-control-sm" />
											</div>
											<div class="form-group">
												<input type="time" name="end_time" id="end_time{{$task->id}}" value="{{@$task->end_time}}" class="form-control form-control-sm" />
											</div>
											@endif
											<div id="is_all_day_show_modal{{$task->id}}"></div>
										</div>
								</div>
								<div class="col-md-3">
									<label class="cl-switch cl-switch-green">
										<span class="label" for="repeat_task_modal{{$task->id}}">{{__('Repeat Task')}}</span>
										<input type="checkbox" name="repeat_task" onchange="repeat_task_modal({{$task->id}})" id="repeat_task_modal{{$task->id}}" value="yes"
										@if ($task->repeat_task == 'yes')
												checked
										@endif>
										<span class="switcher"></span>
										</label>
			
									
								</div>
								
									<div class="col-md-3">
										<div class="form-group">
										<label class="cl-switch cl-switch-green">
											<span class="label" for="billable_modal{{$task->id}}">{{__('Billable')}}</span>
											<input type="checkbox" name="billable" id="billable_modal{{$task->id}}" onchange="billable_modal({{$task->id}})" value="yes" 
											@if($task->billable == 'yes')
												checked
											@endif
											>
											<span class="switcher"></span>
										</label>
										</div>
										<div 
											@if ($task->billable == 'yes')
												class="form-group d-show"  
											@else 
												class="form-group d-hide"  
											@endif
											id="bill_amount_modal{{$task->id}}"
										>
											<label for="">{{__('Bill Amount')}}</label>
											<input type="number" step="0.01" name="bill_amount" value="{{@$task->bill_amount}}" class="form-control form-control-sm">
										</div>
		
								</div>
						</div>
						<div id="repeat_window_show_modal{{$task->id}}"></div>
						{{-- If repeat task is on --}}
						@if ($task->repeat_task == 'yes')
							<div class="card" id="repeat_window_show_modal_pre_valued{{$task->id}}">
								<div class="card-body bg1" >
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="">{{__('Repeat Every')}}</label>
												<select name="repeat_every" class="form-control form-control-sm">
													@php
															$repeats = ['week','day', 'month', 'year'];
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
												<label for="">{{__('Repeat on a specific Day of the Month')}}</label>
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
                    <!-- /.card-body -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>


{{-- ANCHOR MODAL VIEW task --}}


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>

{{-- MODAL VIEW task ENDS --}}

{{-- SECTION Add Currency modal Starts Here --}}
<div class="modal fade" id="addtask" tabindex="-1" role="dialog" aria-labelledby="addtaskLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addtaskLabel">{{__('Add task')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('office/currency/store')}}" method="POST">
                    @csrf


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-info">{{__('Add')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
{{-- !SECTION ADD Currency modal ends here --}}

@endsection

@section('scripts')

@include('crm.customer.task_js')
@endsection
