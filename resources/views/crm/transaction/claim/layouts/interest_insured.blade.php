<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Interest ID-Name</th>
						<th>Amount</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>001-Machinery</td>
						<td>{{ number_format(100000000,0) }}</td>
						<td>
							<a href="" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<tr>
						<td>
							<select class="form-control">
								<option>Interest List</option>
							</select>
						</td>
						<td>
							<input type="number" class="form-control" name="">
						</td>
						<td>
							<a href="" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></a>
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
						<td>Total Sum Insured</td>
						<td>
							<input type="text" class="form-control" name="" placeholder="tst (*total from interest insured)">
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<td>Type</td>
						<td>
							<select class="form-control">
								<option>PML</option>
							</select>
						</td>
						<td>
							<input type="number" name="" class="form-control" placeholder="pcl">
						</td>
						<td>
							<b>%</b>
						</td>
						<td>
							<input type="text" name="" class="form-control" placeholder="=pct*tsi">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>