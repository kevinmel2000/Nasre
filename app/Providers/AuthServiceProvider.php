<?php

namespace App\Providers;

use App\Models\Leads\Lead;

use App\Models\Contact\Contact;
use App\Policies\ContactPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Contact::class => 'App\Policies\ContactPolicy',
        Lead::class => 'App\Policies\LeadPolicy',
        Product::class => 'App\Policies\ProductPolicy',
        Project::class => 'App\Policies\ProjectPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // ANCHOR Project Gates
        Gate::define('viewany-office', 'App\Policies\OfficePolicy@viewany');
        Gate::define('view-office', 'App\Policies\OfficePolicy@view');
        Gate::define('create-office', 'App\Policies\OfficePolicy@create');
        Gate::define('update-office', 'App\Policies\OfficePolicy@update');
        Gate::define('delete-office', 'App\Policies\OfficePolicy@delete');

        // ANCHOR Contact Gates
        Gate::define('viewany-contact', 'App\Policies\ContactPolicy@viewany');
        Gate::define('view-contact', 'App\Policies\ContactPolicy@view');
        Gate::define('create-contact', 'App\Policies\ContactPolicy@create');
        Gate::define('update-contact', 'App\Policies\ContactPolicy@update');
        Gate::define('delete-contact', 'App\Policies\ContactPolicy@delete');
        
        // ANCHOR Role Gates
        Gate::define('viewany-user', 'App\Policies\UserPolicy@viewany');
        Gate::define('view-user', 'App\Policies\UserPolicy@view');
        Gate::define('create-user', 'App\Policies\UserPolicy@create');
        Gate::define('update-user', 'App\Policies\UserPolicy@update');
        Gate::define('delete-user', 'App\Policies\UserPolicy@delete');

        // ANCHOR Role Gates
        Gate::define('viewany-role', 'App\Policies\RolePolicy@viewany');
        Gate::define('view-role', 'App\Policies\RolePolicy@view');
        Gate::define('create-role', 'App\Policies\RolePolicy@create');
        Gate::define('update-role', 'App\Policies\RolePolicy@update');
        Gate::define('delete-role', 'App\Policies\RolePolicy@delete');

        // ANCHOR Lead Gates
        Gate::define('viewany-lead', 'App\Policies\LeadPolicy@viewany');
        Gate::define('view-lead', 'App\Policies\LeadPolicy@view');
        Gate::define('create-lead', 'App\Policies\LeadPolicy@create');
        Gate::define('update-lead', 'App\Policies\LeadPolicy@update');
        Gate::define('delete-lead', 'App\Policies\LeadPolicy@delete');

        // ANCHOR Product Gates
        Gate::define('viewany-product', 'App\Policies\ProductPolicy@viewany');
        Gate::define('view-product', 'App\Policies\ProductPolicy@view');
        Gate::define('create-product', 'App\Policies\ProductPolicy@create');
        Gate::define('update-product', 'App\Policies\ProductPolicy@update');
        Gate::define('delete-product', 'App\Policies\ProductPolicy@delete');
                
        // ANCHOR Project Gates
        Gate::define('viewany-project', 'App\Policies\ProjectPolicy@viewany');
        Gate::define('view-project', 'App\Policies\ProjectPolicy@view');
        Gate::define('create-project', 'App\Policies\ProjectPolicy@create');
        Gate::define('update-project', 'App\Policies\ProjectPolicy@update');
        Gate::define('delete-project', 'App\Policies\ProjectPolicy@delete');

        // ANCHOR Country Gates
        Gate::define('viewany-country', 'App\Policies\CountryPolicy@viewany');
        Gate::define('view-country', 'App\Policies\CountryPolicy@view');
        Gate::define('create-country', 'App\Policies\CountryPolicy@create');
        Gate::define('update-country', 'App\Policies\CountryPolicy@update');
        Gate::define('delete-country', 'App\Policies\CountryPolicy@delete');

        // ANCHOR Occupation Gates
        Gate::define('viewany-occupation', 'App\Policies\OccupationPolicy@viewany');
        Gate::define('view-occupation', 'App\Policies\OccupationPolicy@view');
        Gate::define('create-occupation', 'App\Policies\OccupationPolicy@create');
        Gate::define('update-occupation', 'App\Policies\OccupationPolicy@update');
        Gate::define('delete-occupation', 'App\Policies\OccupationPolicy@delete');

        // ANCHOR COB Gates
        Gate::define('viewany-cob', 'App\Policies\COBPolicy@viewany');
        Gate::define('view-cob', 'App\Policies\COBPolicy@view');
        Gate::define('create-cob', 'App\Policies\COBPolicy@create');
        Gate::define('update-cob', 'App\Policies\COBPolicy@update');
        Gate::define('delete-cob', 'App\Policies\COBPolicy@delete');
                
        // ANCHOR Currency Gates
        Gate::define('viewany-currency', 'App\Policies\CurrencyPolicy@viewany');
        Gate::define('view-currency', 'App\Policies\CurrencyPolicy@view');
        Gate::define('create-currency', 'App\Policies\CurrencyPolicy@create');
        Gate::define('update-currency', 'App\Policies\CurrencyPolicy@update');
        Gate::define('delete-currency', 'App\Policies\CurrencyPolicy@delete');

        // ANCHOR Exchange Gates
        Gate::define('viewany-exchange', 'App\Policies\CurrencyExchangePolicy@viewany');
        Gate::define('view-exchange', 'App\Policies\CurrencyExchangePolicy@view');
        Gate::define('create-exchange', 'App\Policies\CurrencyExchangePolicy@create');
        Gate::define('update-exchange', 'App\Policies\CurrencyExchangePolicy@update');
        Gate::define('delete-exchange', 'App\Policies\CurrencyExchangePolicy@delete');
    
        // ANCHOR KOC Gates
        Gate::define('viewany-koc', 'App\Policies\KOCPolicy@viewany');
        Gate::define('view-koc', 'App\Policies\KOCPolicy@view');
        Gate::define('create-koc', 'App\Policies\KOCPolicy@create');
        Gate::define('update-koc', 'App\Policies\KOCPolicy@update');
        Gate::define('delete-koc', 'App\Policies\KOCPolicy@delete');

        // ANCHOR GFH Gates
        Gate::define('viewany-gfh', 'App\Policies\GFHPolicy@viewany');
        Gate::define('view-gfh', 'App\Policies\GFHPolicy@view');
        Gate::define('create-gfh', 'App\Policies\GFHPolicy@create');
        Gate::define('update-gfh', 'App\Policies\GFHPolicy@update');
        Gate::define('delete-gfh', 'App\Policies\GFHPolicy@delete');

        // ANCHOR CedingBroker Gates
        Gate::define('viewany-cedingbroker', 'App\Policies\CedingBrokerPolicy@viewany');
        Gate::define('view-cedingbroker', 'App\Policies\CedingBrokerPolicy@view');
        Gate::define('create-cedingbroker', 'App\Policies\CedingBrokerPolicy@create');
        Gate::define('update-cedingbroker', 'App\Policies\CedingBrokerPolicy@update');
        Gate::define('delete-cedingbroker', 'App\Policies\CedingBrokerPolicy@delete');

        // ANCHOR FELookup Gates
        Gate::define('viewany-felookup', 'App\Policies\FelookupLocationPolicy@viewany');
        Gate::define('view-felookup', 'App\Policies\FelookupLocationPolicy@view');
        Gate::define('create-felookup', 'App\Policies\FelookupLocationPolicy@create');
        Gate::define('update-felookup', 'App\Policies\FelookupLocationPolicy@update');
        Gate::define('delete-felookup', 'App\Policies\FelookupLocationPolicy@delete');
    }
}
