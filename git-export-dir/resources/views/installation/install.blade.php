@extends('installation.layout')

@section('content')
@include('installation.steps_style')  
<div class="title m-b-md">
  <a href="{{url('/install/steps')}}" class="btn btn-block  text-light installBtnBG" ><i class="fas fa-laptop-code pr-2"></i> {{__('auth.install')}}</a>
</div>
<br>
<div class="card">
  <div class="card-body">
    <p>{{__('Your server details (All extenstions must have "True" status):')}}</p>
    <i class="fas fa-circle fa-xs text-{{ (phpversion() > '7.2.5') ? 'success' : 'danger' }}"></i> 
    {{__('PHP version:')}} {{phpversion()}} 
    @if (phpversion() < '7.2.5')
      <span class="text-danger">{{__('Your php version is not valid as per Mandala CRM requirements.')}}</span>
    @endif
    
    <br/><i class="fas fa-circle fa-xs text-{{ (extension_loaded('bcmath') == 1) ? 'success' : 'danger' }}"></i> 
    {{__('BCMath')}} - {{ (extension_loaded('bcmath') == 1) ? 'True' : 'false' }}
    
    <br/><i class="fas fa-circle fa-xs text-{{ (extension_loaded('Ctype') == 1) ? 'success' : 'danger' }}"></i> 
    {{__('Ctype')}} - {{ (extension_loaded('Ctype') == 1) ? 'True' : 'false' }}
    
    <br/><i class="fas fa-circle fa-xs text-{{ (extension_loaded('Fileinfo') == 1) ? 'success' : 'danger' }}"></i> 
    {{__('Fileinfo')}} - {{ (extension_loaded('Fileinfo') == 1) ? 'True' : 'false' }}
    
    <br/><i class="fas fa-circle fa-xs text-{{ (extension_loaded('JSON') == 1) ? 'success' : 'danger' }}"></i> 
    {{__('JSON')}} - {{ (extension_loaded('JSON') == 1) ? 'True' : 'false' }}
    
    <br/><i class="fas fa-circle fa-xs text-{{ (extension_loaded('Mbstring') == 1) ? 'success' : 'danger' }}"></i> 
    {{__('Mbstring')}} - {{ (extension_loaded('Mbstring') == 1) ? 'True' : 'false' }}
    
    <br/><i class="fas fa-circle fa-xs text-{{ (extension_loaded('OpenSSL') == 1) ? 'success' : 'danger' }}"></i> 
    {{__('OpenSSL')}} - {{ (extension_loaded('OpenSSL') == 1) ? 'True' : 'false' }}
    
    <br/><i class="fas fa-circle fa-xs text-{{ (extension_loaded('PDO') == 1) ? 'success' : 'danger' }}"></i> 
    {{__('PDO')}} - {{ (extension_loaded('PDO') == 1) ? 'True' : 'false' }}
    
    <br/><i class="fas fa-circle fa-xs text-{{ (extension_loaded('Tokenizer') == 1) ? 'success' : 'danger' }}"></i> 
    {{__('Tokenizer')}} - {{ (extension_loaded('Tokenizer') == 1) ? 'True' : 'false' }}
    
    <br/><i class="fas fa-circle fa-xs text-{{ (extension_loaded('XML') == 1) ? 'success' : 'danger' }}"></i> 
    {{__('XML')}} - {{ (extension_loaded('XML') == 1) ? 'True' : 'false' }}
  </div>
</div>


@include('installation.steps_script')  
@endsection