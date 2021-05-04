
<div class="row">
	<div class="col-md-9">
		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<th>KOC</th>
						<th>
							<select id="claimkoc" name="claimkoc" class="e1 form-control form-control-sm ">
								<option selected readonly  value='0'>{{__('KOC list')}}</option>
								@foreach($koc as $cok)
								<option value="{{ $cok->id }}">{{ $cok->code }} - {{ $cok->description }}</option>
								@endforeach
							</select>
						</th>
						<th>
							<input type="text" name="" class="form-control" autocomplete="off">
						</th>
						<th>
							<button class="btn btn-default btn-block">Cancel All</button>
						</th>
						<th>
							<button class="btn btn-default btn-block">Retrieve Data</button>
						</th>
						<th>
							<button class="btn btn-default btn-block">Doc Check</button>
						</th>
					</tr>
					<tr>
						<th>COB</th>
						<th>
							<select id="claimcob" name="claimcob" class="e1 form-control form-control-sm ">
								<option selected readonly  value='0'>{{__('COB list')}}</option>
								@foreach($cob as $boc)
								<option value="{{ $boc->id }}">{{ $boc->code }} - {{ $boc->description }}</option>
								@endforeach
							</select>
						</th>
						<th>
							<input type="text" name="" class="form-control" autocomplete="off">
						</th>
						<th>
							<button class="btn btn-default btn-block">Correction</button>
						</th>
						<th>
							UY
						</th>
						<th>
							<input type="text" name="" class="form-control" autocomplete="off">
						</th>
					</tr>
				</tbody>
			</table>
		</div>	
	</div>

	<div class="col-md-3">
		<p>Print For</p>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<td>
						<input type="radio" name=""> Hard Copy
					</td>
					<td>
						<input type="radio" name=""> Rec Sheet
					</td>
				</tr>
				<tr>
					<td>
						<input type="radio" name=""> CE Report
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>