@extends('crm.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
      <div class="card card-secondary">
        <div class="card-header bg-gray">
          <h2 class="card-title card-primary">{{__('Web to Lead Form')}}</h2>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3" id="row1">
              <!-- Widget: user widget style 2 -->
              <div class="card card-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-secondary">
                  {{__('Add fields to the form')}}
                </div>
                <div class="card-footer p-0">
                  <ul class="nav flex-column">
                    @foreach ($formfields as $formfield)
                      <li class="nav-item">
                        <span href="#" class="nav-link">
                          {{$formfield->name}}
                          @if (@$formfield->required == 'yes')
                            <span class="text-danger">*</span> 
                          @endif
                          <button 
                            type="button"
                            class="btn btn-info btn-sm floatRight mb-1" 
                            id="addField{{@$formfield->id}}"
                            {!! $addFields[@$formfield->id] !!}
                          >
                            <i class="fas fa-plus float-right"></i>
                          </button>
                          <button 
                            type="button" 
                            class="btn btn-danger btn-sm floatRight d-hide mb-1" 
                            id="removeField{{@$formfield->id}}"
                            {!! $removeFields[@$formfield->id] !!}
                          >
                            <i class="fas fa-minus float-right"></i>
                          </button>
                        </span>
                      </li>                        
                    @endforeach
                  </ul>
                </div>
              </div>
              <!-- /.widget-user -->
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <p>{{__('You can change width and height!')}}</p>
                @php
                    $url = url('form/'.$token);
                @endphp
                <code class="text-secondary">{{ '<iframe width="600px" height="500px" src="'.$url.'" frameborder="0" allowfullscreen></iframe>' }}
                </code>
                <br />
                <br />
                <form action="{{url('office/web_form/store')}}" method="POST">
                  @csrf
                  <input type="hidden" name="formdata" id="formdata">
                  <input type="hidden" name="token" value="{{$token}}">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">{{__('Form Title')}} <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-sm" required />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">{{__('Return URL')}} <span class="text-danger">*</span>
                          <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{__('On this url, page will redirect after submitting the form. URL must include http or https')}}"></i> 
                        </label>
                        <input type="url" name="returnurl" class="form-control form-control-sm" value=" <?php echo "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" required />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">{{__('Lead Source for this form')}} <span class="text-danger">*</span></label>
                        <select name="lead_source_id" class="form-control form-control-sm" required>
                          @foreach ($lead_sources as $source)
                            <option value="{{@$source->id}}">{{@$source->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="">{{__('Form Heading')}} <span class="text-danger">*</span></label>
                    <input type="text" name="heading" class="form-control form-control-sm" id="heading" required />
                  </div>
                  <div class="form-group">
                    <label for="">{{__('Form Note')}}</label>
                    <textarea name="note" id="note" class="form-control form-control-sm" rows="2"></textarea>
                  </div>
                  <button type="submit" id="submitForm" class="mt-3 btn btn-block btn-primary"><i class="fas fa-save"></i> {{__('Create Form')}}</button>
                </form>
                <div class="card bg-light-blue">
                  <div class="card-body">
                   
                    <div id="form" style="background-color: aliceblue">
                      @php
                          echo "<link rel=\"stylesheet\" href='".asset('css/bootstrap.min.css')."'>";
                          echo "<link rel=\"stylesheet\" href='".asset('css/style.css')."'>";
                          echo "<script src='".asset('js/app.js')."'></script>";
                      @endphp
                      <link rel="stylesheet" href="{{asset('css/googlefont.css')}}" />
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-12">
                            <form action="{{url('lead/webform', $token)}}" method="post">
                              <h3 id="showheading"></h3>
                              <p id="shownote"></p>
                              <div id="formfields"></div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
  <script src="{{asset('js/sortable.js')}}"></script>
  @include('crm.office.web_form.create_js')
@endsection