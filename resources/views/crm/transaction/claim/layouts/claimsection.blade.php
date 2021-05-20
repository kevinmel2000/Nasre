<div class="row">
	<div class="col-md-3">
	    <input type="hidden" name="_token2" id="token" value="{{ csrf_token() }}">                                 
		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<th>
							Reg Comp
						</th>
						<th>
							<input type="text" name="regcomp" id="regcomp" class="form-control" autocomplete="off">
						</th>
					</tr>
				</tbody>
			</table>
		</div>	
	</div>
	<div class="col-md-3">
		 <div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<th>
								Doc Number
							</th>
							<th>
								<input type="text" name="docnumber" id="docnumber" class="form-control" autocomplete="off">
							</th>
						</tr>
					</tbody>
				</table>
		</div>	
	</div>
	<div class="col-md-3">
		<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<th>
								Date Of Receipt
							</th>
							<th>
								<input type="text" name="dateofreceipt" id="dateofreceipt" class="form-control datepicker" autocomplete="off">
							</th>
						</tr>
					</tbody>
				</table>
		</div>	
	</div>
	<div class="col-md-3">
		<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td>
								Date Of Document
							</td>
							<td>
								<input type="text" name="dateofdocument" id="dateofdocument" class="form-control datepicker" autocomplete="off">
															
							</td>
						</tr>
					</tbody>
				</table>
		</div>	
		
	</div>
</div>


<div class="row">
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-2">
				<table class="table">
					<tbody>
						<tr>
							<td>Cause Of Loss</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>
							<select id="causeofloss" name="causeofloss" class="e1 form-control form-control-sm ">
								<option selected disabled>{{__('Select Cause Of Loss')}}</option>
								@foreach($causeofloss as $pi)
								<option value="{{ $pi->id }}">{{ $pi->nama }} - {{ $pi->keterangan }}</option>
								@endforeach
							</select>
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>
							<input type="text" name="desccauseofloss" id="desccauseofloss" class="form-control" autocomplete="off">					
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<table class="table">
					<tbody>
						<tr>
							<td>Nature Of Loss</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>
							<select id="natureofloss" name="natureofloss" class="e1 form-control form-control-sm ">
								<option selected disabled>{{__('Select Nature Of Loss')}}</option>
								@foreach($natureofloss as $pi)
								<option value="{{ $pi->id }}">{{ $pi->accident }} - {{ $pi->keterangan }}</option>
								@endforeach
							</select>
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>
							<input type="text" name="descnatureofloss" id="descnatureofloss" class="form-control" autocomplete="off">					
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<table class="table">
					<tbody>
						<tr>
							<td>Date Of Loss</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>
							<input type="hidden" name="dateinsurance" id="dateinsurance" class="form-control datepicker" autocomplete="off">					
							<input type="hidden" name="datereinsurance" id="datereinsurance" class="form-control datepicker" autocomplete="off">					
							
							<input type="text" name="dateofloss" id="dateofloss" class="form-control datepickerloss" autocomplete="off">					
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>Curr Of Loss</td>
							<td>
							<select name="currofloss" id="currofloss" class="form-control">
								<option value="Y">Yes</option>
								<option value="N">No</option>
							</select>
							</td>
							<td>
							<input type="text" name="desccurrofloss" id="desccurrofloss" class="form-control" autocomplete="off">					
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<table class="table">
					<tbody>
						<tr>
							<td>Surveyor / Adjuster</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>
							<select id="surveyoradjuster" name="surveyoradjuster" class="e1 form-control form-control-sm ">
								<option selected disabled>{{__('Select Surveyor')}}</option>
								@foreach($surveyor as $pi)
								<option value="{{ $pi->id }}">{{ $pi->number }} - {{ $pi->keterangan }}</option>
								@endforeach
							</select>
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>
							<input type="text" name="descsurveyoradjuster" id="descsurveyoradjuster" class="form-control" autocomplete="off">					
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>


		<div class="row">
			<div class="col-md-2">
				
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>National Re's Liab</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>
							<input type="text" name="nationalresliab" id="nationalresliab" class="form-control" autocomplete="off">					
							</td>
							<td>
							<input type="text" name="descnationalresliab" id="descnationalresliab" class="form-control" autocomplete="off">					
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>


		<div class="row">
			<div class="col-md-2">
				
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>Cedant's Share</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-5">
				<table class="table">
					<tbody>
						<tr>
							<td>
							<input type="text" name="cedantshare" id="cedantshare" class="form-control" autocomplete="off">					
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>

	</div>

	<div class="col-md-5">

		<div class="row">
			<div class="col-md-12">
				<table  id="propertyTypePanelAmount" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>{{__('No')}}</th>
							<th>{{__('Description')}}</th>
							<th>{{__('Amount')}}</th>
							<th>{{__('Action')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Input</td>
							<td>
								<div class="form-group">
									<select id="descripitontableselect" name="descripitontableselect" class="form-control form-control-sm ">
										<option value="Lawyer Fee" selected readonly>Lawyer Fee</option>
										<option value="Surveyor Fee">Surveyor Fee</option>
										<option value="Descripiton Fee">Descripiton Fee</option>
									</select>
								</div>  
							</td>
							<td>
								<input type="text" id="amounttablemanual" name="amounttablemanual" placeholder="Amount Manual"  class="form-control form-control-sm amount" data-validation="length"  data-validation-length="0" />
                            </td>
							<td>
								<div class="form-group">
									<button type="button" id="addmanualclaim-btn" name="addmanualclaim-btn" class="btn btn-md btn-primary">{{__('Add')}}</button>
									
								</div>
							</td>
						</tr>
						<tr>
							<td>Input</td>
							<td colspan='2'>
								<div class="form-group">
									<select id="descripitonriskselect" name="descripitonriskselect" class="form-control form-control-sm ">
										<option value="" selected>Select Data</option>
									</select>
								</div>  
							</td>
							
							<td>
								<div class="form-group">
									<button type="button" id="addmanualclaim-btn2" name="addmanualclaim-btn2" class="btn btn-md btn-primary">{{__('Add')}}</button>
								</div>
							</td>
						</tr>
						<tr>
							<td><input type="checkbox" id="checkriskamount" name="checkriskamount" value="1"></td>
							<td colspan='2'>
								<input type="text" id="amounttablerisk" name="amounttablerisk" readonly="true" placeholder="Amount Location Manual" class="form-control form-control-sm amount" data-validation="length"  data-validation-length="0" />
        					</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>			

	</div>

</div>

	<div class="row">
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-2">
					
				</div>
				<div class="col-md-5">
					<table class="table">
						<tbody>
							<tr>
								<td>National Re's Share on Loss</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-5">
					<table class="table">
						<tbody>
							<tr>
								<td>
								<input type="text" name="shareonloss" id="shareonloss" class="form-control" autocomplete="off">					
								</td>
							</tr>
						</tbody>
					</table>	
				</div>
			</div>
		</div>
		<div class="col-md-5">
		<div class="row">
				<div class="col-md-3">
					<table class="table">
						<tbody>
							<tr>
								<td>Total Loss Amt</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-9">
					<table class="table">
						<tbody>
							<tr>
								<td>
								<input type="text" name="totallossamount" id="totallossamount" class="form-control form-control-sm amount" autocomplete="off">					
								</td>
							</tr>
						</tbody>
					</table>	
				</div>
			</div>
		</div>			
	</div>




<div class="row">
	<div class="col-md-2">
		<table class="table">
			<tbody>
				<tr>
					<td>Potential Recovery</td>
					<td>	
						<select name="potentialrecoverydecision" id="potentialrecoverydecision" class="form-control">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table">
			<tbody>
				<tr>
					<td>
					<textarea name="potentialrecovery" id="potentialrecovery" class="form-control" autocomplete="off"></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-4">
		<table class="table">
			<tbody>
				<tr>
					<td>
					Estimasi Amount Subrogasi
					</td>
					<td>
					<input type="text" name="subrogasi" id="subrogasi" class="form-control" autocomplete="off">
							
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>


<div class="row">
	<div class="col-md-2">
		<table class="table">
			<tbody>
				<tr>
					<td>Kronologi</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-9">
		<table class="table">
			<tbody>
				<tr>
					<td>
					<textarea name="kronologi" id="kronologi" class="form-control" autocomplete="off"></textarea>
					</td>
				</tr>
			</tbody>
		</table>	
	</div>
</div>



<div class="row">
	<div class="col-md-2">
		<table class="table">
			<tbody>
				<tr>
					<td>Staff Recommendation</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-9">
		<table class="table">
			<tbody>
				<tr>
					<td>
					<textarea name="staffrecomend" id="staffrecomend" class="form-control" autocomplete="off"></textarea>
					</td>
				</tr>
			</tbody>
		</table>	
	</div>
</div>

<div class="row">
	<div class="col-md-2">
		<table class="table">
			<tbody>
				<tr>
					<td>Assistan Manager Recommendation</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-9">
		<table class="table">
			<tbody>
				<tr>
					<td>
					<textarea name="assistantmanagerrecomend" id="assistantmanagerrecomend" class="form-control" autocomplete="off"></textarea>
					</td>
				</tr>
			</tbody>
		</table>	
	</div>
</div>


<div class="card card-primary">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12 com-sm-12 mt-3">
				<button type="submit" id="addclaiminsured-btn" class="btn btn-primary btn-block ">
					{{__('POST')}}
				</button>
			</div>
			
		</div>
	</div>
</div> 
