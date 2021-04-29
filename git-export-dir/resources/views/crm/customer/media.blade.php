@extends('crm.layouts.app')

@section('styles')
<style>
	.card-img-top {
					text-align: center;
					max-height: 80px;
					max-width: 80px;
	}
	.height235{
		height: 235px;
	}
	.height240{
		height: 240px;
	}
</style>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            @include('crm.customer.common.contact_inner_sidebar')
            <div class="col-md-9">
							<div class="card">
								<div class="card-header bg-gray">
												<h4 class="card-title">{{__('Media')}}</h4>
								</div>
								<div class="card-body bg-light-gray">
									<form method="POST" action="{{url('media/store')}}" enctype="multipart/form-data">
													@csrf
													<input type="hidden" name="lead_customer_id" value="{{$customer->id}}">
													<input type="hidden" name="relation" value="Customer">
													<div class="row">
																	<div class="col-md-4">
																					<div class="form-group">
																									<label><span class="text-danger">* </span>{{__('Select File to upload')}} </label>
																									<div class="input-group">
																													<input type="file" name="file_name" id="featured_image" required>
																									</div>
																					</div>
																	</div>
													</div>
													<input type="submit" value="Upload" class=" btn btn-success">
									</form>
								</div>
							</div>   
							
							<div class="col-md-12">
								<div class="card-group">
												@foreach ($media as $item)
												@php
												$link = asset(config('app.file_path').$item->file_name)
												@endphp
												<div class="col-md-3">
														<div class="card height235">
															<div class="card-header height240">
															<center>
																<a href="{{$link}}" target="_blank" >
																	@if ($item->file_type == '.pdf')
																		<img src="{{asset('images/pdf.png')}}" class="card-img-top">
																	@elseif($item->file_type == 'image')
																		<img src="{{asset(config('app.file_path').$item->file_name)}}" class="card-img-top">
																	@elseif($item->file_type == '.zip')
																		<img src="{{asset('images/zip.png')}}" class="card-img-top">  
																	@elseif($item->file_type == '.xlsx')
																		<img src="{{asset('images/excel.png')}}" class="card-img-top">      
																	@elseif($item->file_type == '.html' || $item->file_type == '.htm')
																		<img src="{{asset('images/html.png')}}" class="card-img-top">
																	@elseif($item->file_type == '.docx' || $item->file_type == '.doc' || $item->file_type == '.txt')
																		<img src="{{asset('images/word.png')}}" class="card-img-top">    
																	@endif
																	<div class="pt-2">{{Str::limit($item->file_name, 40)}}</div>    
																</a>
															</center>
															</div>
															<div class="card-body mb-2">
																<center>
																	<span>{{__('Uploaded By')}}: {{$item->owner->name}}</span><br>
																	<input type="hidden" value="{{asset(config('app.file_path').$item->file_name)}}" id="myInput">
																	<button class="btn btn-info btn-sm" onclick="copyToClipboard(''+'{{ $link }}'+'')">{{__('Get Link')}}</button>
																{{-- this is for permanant delete --}}
																@can('delete-lead', User::class)
																<span id="delbtn{{@$item->id}}"></span>
																<form id="delete-item-{{$item->id}}" action="{{ url('media/destroy', $item->id) }}" method="POST" >
																	@method('DELETE')
																	@csrf
																</form>
																@endcan
															</center>
															</div>
														</div>
												</div>
												@endforeach
								</div>
							</div>

  
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>


@endsection

@section('scripts')
@include('crm.customer.media_js')
@endsection
