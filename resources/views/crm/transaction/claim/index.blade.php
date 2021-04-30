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

		<form autocomplete="off">

			<div class="card">

				<div class="card-header bg-gray">
					Claim Incoming (Facultative)
				</div>

				<div class="card-body bg-light-gray ">

					@include('crm.transaction.claim.layouts.head')

					<div class="card">

						<div class="card-header bg-gray">
							Incoming
						</div>

						<div class="card-body bg-light-gray ">

							<div class="card">

								<div class="card-header bg-gray">
									Insured
								</div>

								<div class="card-body bg-light-gray ">

									@include('crm.transaction.claim.layouts.insured')

								</div>

							</div>

							<div class="card">

								<div class="card-header bg-gray">
									
								</div>

								<div class="card-body bg-light-gray ">

									@include('crm.transaction.claim.layouts.insured2')

								</div>

							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="card">

										<div class="card-header bg-gray">
											Interest Insured
										</div>

										<div class="card-body bg-light-gray ">

											@include('crm.transaction.claim.layouts.interest_insured')

										</div>

									</div>
								</div>

								<div class="col-md-6">
									
								</div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

<script type="text/javascript">
	$(document).ready(function(){

		$('.datepicker').datepicker();

	})
</script>

@endsection