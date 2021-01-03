@extends('crm.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

<style>
    .card-img-top {
        text-align: center;
        max-height: 100px;
        max-width: 100px;
    }
    .height255{
        height: 255px;
    }
    .height240{
        height: 240px;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-gray">
                            <h4 class="card-title">{{__('Media')}}</h4>
                        </div>
                        <div class="card-body bg-light-gray">
                            <form method="POST" action="{{url('media/store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><span class="text-danger">*</span> {{__('Customer/Lead ?')}} </label>
                                            <select name="relation" class="relation form-control form-control-sm"
                                                >
                                                <option selected disabled>{{__('Select User Type')}}</option>
                                                <option value="Customer">{{__('Customer')}}</option>
                                                <option value="Lead">{{__('Lead')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><span class="text-danger">* </span>{{__('Select Customer/Lead')}}
                                            </label>
                                            <select name="lead_customer_id" id="lead_customer_id"
                                                class="form-control form-control-sm">
                                            </select>
                                        </div>
                                    </div>
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
                </div>
                {{-- Files --}}

                <div class="col-md-12">
                    <div class="card-group">
                        @foreach ($medias as $item)
                        @php
                        $link = asset(config('app.file_path').$item->file_name)
                        @endphp
                        <div class="col-md-2">
                            
                                <div class="card height255" >
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
                                    <div class="card-body">
                                        <center><span>{{__('Uploaded By')}}: {{$item->owner->name}}</span>
                                        <input type="hidden" value="{{asset(config('app.file_path').$item->file_name)}}"
                                            id="myInput">
                                        <button class="btn btn-info btn-sm"
                                            onclick="copyToClipboard(''+'{{ $link }}'+'')">{{__('Get Link')}}</button>
                                        @can('delete-lead', User::class)
                                            <a class="btn btn-danger btn-sm" href="javascript:;"
                                                onclick="confirmDelete('{{$item->id}}')">{{__('Delete')}}</a>
                                            <form id="delete-item-{{$item->id}}"
                                                action="{{ url('media/destroy', $item->id) }}" method="POST"
                                                >
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
    </section>
</div>


{{-- ANCHOR MODAL VIEW media --}}

@endsection

@section('scripts')
@include('crm.media.index_js')

@endsection
