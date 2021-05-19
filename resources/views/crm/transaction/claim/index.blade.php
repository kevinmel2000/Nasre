@extends('crm.layouts.app')

@section('content')

<style type="text/css">
	/* Firefox */
		input[type=number] {
		  -moz-appearance: textfield;
		}

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">

<div class="content-wrapper">

	<div class="container-fluid">

		    <!--form id="multi-file-upload-ajaxsearch" method="POST" autocomplete="off"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">

				<div class="card">

					<div class="card-header bg-gray">
						Claim Incoming (Facultative)
					</div>

					<div class="card-body bg-light-gray ">

						@include('crm.transaction.claim.layouts.head')					

					</div>

				</div>

		   </form-->

			<form id="multi-file-upload-ajax" method="POST" autocomplete="off"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">

				<div class="card">

					<div class="card-header bg-gray">
						Claim Section (Facultative)
					</div>

					<div class="card-body bg-light-gray ">

						<div class="card">

							<div class="card-header bg-gray">
								Show Incoming Claim Information
							</div>

							<div class="card-body bg-light-gray ">

								<div class="card">

									<div class="card-header bg-gray">
										<table style="position:left" id="propertyTypePanelAmount" class="table table-bordered table-striped">
											<tbody>
												<tr>
													<td>
														<input type="text" name="slipnumberdata" id="slipnumberdata" class="form-control form-control-sm" autocomplete="off">					
													</td>
													<td>
														<a class="text-primary mr-3 float-right " data-toggle="modal" data-target="#detailmodaldata" href="#detailmodaldata">
														<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#detailmodaldata2">{{__('Detail Slip')}}</button>
														</a>
													</td>
													<td>
														<button type="button" id="detailclaimbutton" name="detailclaimbutton" class="btn btn-sm btn-primary float-right" >{{__('Get Detail Claim')}}</button>
													</td>
												</tr>
											</tbody>
										</table>	
									</div>

									@include('crm.transaction.claim.layouts.claim_slipmodaldetail')

									<div class="card-body bg-light-gray ">

										@include('crm.transaction.claim.layouts.claimsection')

									</div>

								</div>

							</div>

						</div>

					 </div>

				</div>

				<div class="card">

					<div class="card-header bg-gray">
						Retro Section (Facultative)
					</div>

					<div class="card-body bg-light-gray ">

						<div class="card">

							<div class="card-header bg-gray">
								Recovery Claim 
							</div>

							<div class="card-body bg-light-gray ">

								<div class="card">

									<div class="card-header bg-gray">
										
									</div>

									<div class="card-body bg-light-gray ">

										@include('crm.transaction.claim.layouts.retrosection')

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

				<div class="card">

					<div class="card-header bg-gray">
						Other
					</div>

					<div class="card-body bg-light-gray ">

						<div class="card">

							<div class="card-body bg-light-gray ">

								<div class="card">

									<div class="card-header bg-gray">
										
									</div>

									<div class="card-body bg-light-gray ">

										@include('crm.transaction.claim.layouts.othersection')

									</div>

								</div>

							</div>

						</div>

					</div>

					<div class="card card-primary">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12 com-sm-12 mt-3">
									<button type="submit" id="addallclaiminsured-btn" class="btn btn-primary btn-block ">
										{{__('Save')}}
									</button>
								</div>
								
							</div>
						</div>
					</div> 

				</div>

				

			</form>

	</div>

</div>

@endsection

@section('scripts')



@include('crm.transaction.claim.index_script')


@endsection