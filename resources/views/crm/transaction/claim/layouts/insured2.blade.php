<div class="row">
	<div class="col-md-6">
		
		<div class="row">
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<td colspan="2">
									<small style="color: red;">*only show when insured saved</small>
								</td>
							</tr>
							<tr>
								<td>Number</td>
								<td>
									<input type="text" name="" class="form-control">
								</td>
							</tr>
							<tr>
								<td>Username</td>
								<td>
									<input type="text" name="" class="form-control" placeholder="user login">
								</td>
							</tr>
							<tr>
								<td>Prod Year</td>
								<td>
									<input type="text" id="slipipdate" name="" class="form-control datepicker" placeholder="">
								</td>
							</tr>
							<tr>
								<td>UY</td>
								<td>
									<input type="text" name="" class="form-control" placeholder="">
								</td>
							</tr>
							<tr>
								<td>Status</td>
								<td>
									<select class="form-control">
										<option value="off">Offer</option>
										<option value="binding">Binding</option>
										<option value="slip">Slip</option>
										<option value="endorsment">Endorsment</option>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<td colspan="3">
									<small style="color: red;">*create endorsment data</small>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<button class="btn btn-primary">Endorsment</button>
								</td>
							</tr>
							<tr>
								<td>
									<p>Endorsment / Selisih</p>
								</td>
								<td>
									<input type="text" name="" class="form-control">
								</td>
								<td>
									<input type="text" name="" class="form-control">
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<small style="color: red;">*automatic record status change</small>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Status</th>
								<th>Datetime</th>
								<th>User</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Offer</td>
								<td>01/10/2020</td>
								<td>UserA</td>
							</tr>
						</tbody>
					</table>
				</div>

			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<table class="table">
					<tbody>
						<tr>
							<td>Source</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-md-10">
				<div>
					<select class="form-control">
						<option>Ceding</option>
						<option>Broker</option>
					</select>
				</div>
				<div>
					<select class="form-control">
						<option>Ceding</option>
						<option>Broker</option>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<td>Currency</td>
								<td>
									<select class="form-control">
										<option>IDR</option>
										<option>USD</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>COB</td>
								<td>
									<select class="form-control">
										<option selected="" disabled="">COB List</option>
										<option>IDR</option>
										<option>USD</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>KOC</td>
								<td>
									<select class="form-control">
										<option selected="" disabled="">KOC List</option>
										<option>IDR</option>
										<option>USD</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Occupacy</td>
								<td>
									<select class="form-control">
										<option selected="" disabled="">OCC List</option>
										<option>IDR</option>
										<option>USD</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Building Const</td>
								<td>
									<select class="form-control">
										<option selected="" disabled="">Bid Const List</option>
										<option>IDR</option>
										<option>USD</option>
									</select>
								</td>
							</tr>
						</tbody>
						<tbody>
							
							<tr>
								<td>Attachment</td>
								<td>
									<input type="file" name="">
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<button class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-6">
				<p>
					Reference Number
				</p>
				<table class="table">
					<tbody>
						<tr>
							<td>Slip No</td>
							<td>
								<input type="text" name="" class="form-control">
							</td>
						</tr>
						<tr>
							<td>CN/DN</td>
							<td>
								<input type="text" name="" class="form-control">
							</td>
						</tr>
						<tr>
							<td>Policy No</td>
							<td>
								<input type="text" name="" class="form-control">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

	</div>

	<div class="col-md-6">
		<p>Extend Coverage</p>

		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Peril Code-Name</th>
						<th>Nilai (Permil %)</th>
						<th>Amount</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<select class="form-control">
								<option selected="" disabled="">Perl List</option>
								<option>A</option>
								<option>B</option>
							</select>
						</td>
						<td>
							<input type="text" name="" class="form-control">
						</td>
						<td>
							<input type="text" name="" class="form-control">
						</td>
						<td>
							<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<hr>

		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<td>Insurance Period</td>
						<td>
							<input type="text" name="" class="form-control datepicker" autocomplete="off">
						</td>
						<td>To</td>
						<td>
							<input type="text" name="" class="form-control datepicker" autocomplete="off">
						</td>
					</tr>
					<tr>
						<td>Reinsurance Period</td>
						<td>
							<input type="text" name="" class="form-control datepicker" autocomplete="off">
						</td>
						<td>To</td>
						<td>
							<input type="text" name="" class="form-control datepicker" autocomplete="off">
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<hr>

		<p>non proportional panel</p>

		<div class="row d-flex justify-content-end">
            <div class="col-md-6">
                <label class="cl-switch cl-switch-green">
                    <span for="switch-proportional" class="label"> Proportional </span>
                    <input type="checkbox" name="slipproportional[]" id="switch-proportional" class="submit" checked="">
                    <span class="switcher"></span>
                    <span class="label"> Non Proportional </span>
                </label>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>Add Layer</button>
            </div>
        </div>

        <div class="row">
        	<div class="col-md-12">
        		<div class="table-responsive">
        			<table class="table">
        				<tbody>
        					<tr>
        						<td>Layer *for non operational</td>
        						<td>
        							<select class="form-control">
        								<option selected="" disabled="">Choose Layer</option>
        							</select>
        						</td>
        					</tr>
        				</tbody>
        			</table>
        		</div>
        	</div>
        </div>

        <hr>

        <div class="row">
        	<div class="col-md-12">
        		<div class="table-responsive">
        			<table class="table">
        				<tbody>
        					<tr>
        						<td>Rate (permil %)</td>
        						<td><input type="text" name="" class="form-control"></td>
        						<td>Share</td>
        						<td>
        							<input type="number" name="" class="form-control">
        						</td>
        						<td><b>%</b></td>
        						<td>
        							<input type="text" name="" class="form-control" readonly="" placeholder="=b%*tsi">
        						</td>
        					</tr>
        					<tr>
        						<td>Basic Premium</td>
        						<td colspan="2">
        							<input type="text" name="" class="form-control" placeholder="=a%*tsi">
        						</td>
        						<td>
        							Gross Prm to NR
        						</td>
        						<td colspan="2">
        							<input type="text" name="" class="form-control" placeholder="=a%*b%*tsi">
        						</td>
        					</tr>
        					<tr>
        						<td>Commission</td>
        						<td>
        							<input type="number" name="" class="form-control">
        						</td>
        						<td><b>%</b></td>
        						<td>
        							<input type="text" name="" class="form-control" placeholder="=a%*b%*tsi*d%">
        						</td>
        						<td>Net Prm to NR</td>
        						<td>
        							<input type="text" name="" class="form-control" placeholder="=a%*b%*tsi*(100%-d%)">
        						</td>
        					</tr>
        				</tbody>
        			</table>
        		</div>
        	</div>
        </div>

	</div>
</div>

