<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lead\LeadController;
use App\Http\Controllers\Office\WebFormController;

// These are public routes for third party webpages outsite Laravel, these routes don't uses csrf tokens.
  Route::get('/form/{token}',  [WebFormController::class, 'getForm']);
  Route::post('/lead/webform/{token}', [LeadController::class, 'webToLeadForm']);


?>