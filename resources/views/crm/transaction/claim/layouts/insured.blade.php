<div class="row">
	<div class="col-md-4">
		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<td>Number</td>
						<td>
							<input type="" name="" class="form-control" autocomplete="off">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<td>Insured</td>
						<td colspan="2">
							<select id="claiminsured" name="claiminsured" class="e1 form-control form-control-sm ">
								<option selected disabled>{{__('Select Prefix')}}</option>
								@foreach($prefixinsured as $pi)
								<option value="{{ $pi->id }}">{{ $pi->code }} - {{ $pi->name }}</option>
								@endforeach
							</select>
						</td>
						<td colspan="2">
							<input type="text" name="" class="form-control" autocomplete="off" placeholder="Search for Insured w/ Suggestion">
						</td>
						<td colspan="2">
							<input type="text" name="" class="form-control" autocomplete="off" placeholder="Suffix eg : QQ or Tbk">
						</td>
					</tr>
					<tr>
						<td>
							Our Share
						</td>
						<td>
							<input type="number" name="" class="form-control" placeholder="%">
						</td>
						<td>%</td>
						<td>From</td>
						<td>
							<input type="number" name="" class="form-control" placeholder="*total nasionalre share">
						</td>
						<td>To</td>
						<td>
							<input type="number" name="" class="form-control" placeholder="*total sum insured">
						</td>
					</tr>
					<tr>
						<td colspan="7">
							<span style="color: red;">*automatic calculation from slip with some insured (coinsurance)</span>
						</td>
					</tr>
					<tr>
						<td colspan="6">Location</td>
						<td>
							<button class="btn btn-block btn-primary">Add Risk Location</button>
						</td>
					</tr>

				</tbody>
			</table>

			<table class="table table-hover">
				<thead>
					<tr>
						<th>Loc Code</th>
						<th colspan="2">Address</th>
						<th>City</th>
						<th>Province</th>
						<th>Latitude Longitude</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>CODE00001</td>
						<td colspan="2">Jl. Cikini Raya</td>
						<td>Jakarta Pusat</td>
						<td>Jakarta</td>
						<td>-546545465464</td>
						<td>
							<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="table">
				<tbody>
					<tr>
						<td>Coinsurance</td>
						<td colspan="5">
							<input type="text" name="" class="form-control" placeholder="*add remarks to separate if any more than one coinsurance with same insured">
						</td>
						<td>
							<button class="btn btn-primary btn-block">Save</button>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</div>