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
        // Lead::class => 'App\Policies\LeadPolicy',
        // Product::class => 'App\Policies\ProductPolicy',
        // Project::class => 'App\Policies\ProjectPolicy',
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
        // Gate::define('viewany-office', 'App\Policies\OfficePolicy@viewany');
        // Gate::define('view-office', 'App\Policies\OfficePolicy@view');
        // Gate::define('create-office', 'App\Policies\OfficePolicy@create');
        // Gate::define('update-office', 'App\Policies\OfficePolicy@update');
        // Gate::define('delete-office', 'App\Policies\OfficePolicy@delete');

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
        // Gate::define('viewany-lead', 'App\Policies\LeadPolicy@viewany');
        // Gate::define('view-lead', 'App\Policies\LeadPolicy@view');
        // Gate::define('create-lead', 'App\Policies\LeadPolicy@create');
        // Gate::define('update-lead', 'App\Policies\LeadPolicy@update');
        // Gate::define('delete-lead', 'App\Policies\LeadPolicy@delete');

        // ANCHOR Product Gates
        // Gate::define('viewany-product', 'App\Policies\ProductPolicy@viewany');
        // Gate::define('view-product', 'App\Policies\ProductPolicy@view');
        // Gate::define('create-product', 'App\Policies\ProductPolicy@create');
        // Gate::define('update-product', 'App\Policies\ProductPolicy@update');
        // Gate::define('delete-product', 'App\Policies\ProductPolicy@delete');
                
        // ANCHOR Project Gates
        // Gate::define('viewany-project', 'App\Policies\ProjectPolicy@viewany');
        // Gate::define('view-project', 'App\Policies\ProjectPolicy@view');
        // Gate::define('create-project', 'App\Policies\ProjectPolicy@create');
        // Gate::define('update-project', 'App\Policies\ProjectPolicy@update');
        // Gate::define('delete-project', 'App\Policies\ProjectPolicy@delete');

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

        // ANCHOR City Gates
        Gate::define('viewany-city', 'App\Policies\CityPolicy@viewany');
        Gate::define('view-city', 'App\Policies\CityPolicy@view');
        Gate::define('create-city', 'App\Policies\CityPolicy@create');
        Gate::define('update-city', 'App\Policies\CityPolicy@update');
        Gate::define('delete-city', 'App\Policies\CityPolicy@delete');

        // ANCHOR State Gates
        Gate::define('viewany-state', 'App\Policies\StatePolicy@viewany');
        Gate::define('view-state', 'App\Policies\StatePolicy@view');
        Gate::define('create-state', 'App\Policies\StatePolicy@create');
        Gate::define('update-state', 'App\Policies\StatePolicy@update');
        Gate::define('delete-state', 'App\Policies\StatePolicy@delete');

        // ANCHOR Eqrthquake Zone Gates
        Gate::define('viewany-eqz', 'App\Policies\EQZPolicy@viewany');
        Gate::define('view-eqz', 'App\Policies\FelookupLocationPolicy@view');
        Gate::define('create-eqz', 'App\Policies\FelookupLocationPolicy@create');
        Gate::define('update-eqz', 'App\Policies\FelookupLocationPolicy@update');
        Gate::define('delete-eqz', 'App\Policies\FelookupLocationPolicy@delete');

        // ANCHOR Flood Zone Gates
        Gate::define('viewany-fz', 'App\Policies\FZPolicy@viewany');
        Gate::define('view-fz', 'App\Policies\FZPolicy@view');
        Gate::define('create-fz', 'App\Policies\FZPolicy@create');
        Gate::define('update-fz', 'App\Policies\FZPolicy@update');
        Gate::define('delete-fz', 'App\Policies\FZPolicy@delete');

        // ANCHOR Ship Type Gates
        Gate::define('viewany-shiptype', 'App\Policies\ShipTypePolicy@viewany');
        Gate::define('view-shiptype', 'App\Policies\ShipTypePolicy@view');
        Gate::define('create-shiptype', 'App\Policies\ShipTypePolicy@create');
        Gate::define('update-shiptype', 'App\Policies\ShipTypePolicy@update');
        Gate::define('delete-shiptype', 'App\Policies\ShipTypePolicy@delete');

        // ANCHOR Classification Gates
        Gate::define('viewany-classification', 'App\Policies\ClassificationPolicy@viewany');
        Gate::define('view-classification', 'App\Policies\ClassificationPolicy@view');
        Gate::define('create-classification', 'App\Policies\ClassificationPolicy@create');
        Gate::define('update-classification', 'App\Policies\ClassificationPolicy@update');
        Gate::define('delete-classification', 'App\Policies\ClassificationPolicy@delete');

        // ANCHOR Construction Gates
        Gate::define('viewany-construction', 'App\Policies\ConstructionPolicy@viewany');
        Gate::define('view-construction', 'App\Policies\ConstructionPolicy@view');
        Gate::define('create-construction', 'App\Policies\ConstructionPolicy@create');
        Gate::define('update-construction', 'App\Policies\ConstructionPolicy@update');
        Gate::define('delete-construction', 'App\Policies\ConstructionPolicy@delete');

        // ANCHOR Marine Lookup Gates
        Gate::define('viewany-marinelookup', 'App\Policies\MarineLookupPolicy@viewany');
        Gate::define('view-marinelookup', 'App\Policies\MarineLookupPolicy@view');
        Gate::define('create-marinelookup', 'App\Policies\MarineLookupPolicy@create');
        Gate::define('update-marinelookup', 'App\Policies\MarineLookupPolicy@update');
        Gate::define('delete-marinelookup', 'App\Policies\MarineLookupPolicy@delete');

        // ANCHOR Property Type Gates
        Gate::define('viewany-property_type', 'App\Policies\PropertyTypePolicy@viewany');
        Gate::define('view-property_type', 'App\Policies\PropertyTypePolicy@view');
        Gate::define('create-property_type', 'App\Policies\PropertyTypePolicy@create');
        Gate::define('update-property_type', 'App\Policies\PropertyTypePolicy@update');
        Gate::define('delete-property_type', 'App\Policies\PropertyTypePolicy@delete');

        // ANCHOR Property Type Gates
        Gate::define('viewany-condition_needed', 'App\Policies\ConditionNeededPolicy@viewany');
        Gate::define('view-condition_needed', 'App\Policies\ConditionNeededPolicy@view');
        Gate::define('create-condition_needed', 'App\Policies\ConditionNeededPolicy@create');
        Gate::define('update-condition_needed', 'App\Policies\ConditionNeededPolicy@update');
        Gate::define('delete-condition_needed', 'App\Policies\ConditionNeededPolicy@delete');

        // ANCHOR FE Slip Gates
        Gate::define('viewany-fe_slip', 'App\Policies\FeSlipPolicy@viewany');
        Gate::define('view-fe_slip', 'App\Policies\FeSlipPolicy@view');
        Gate::define('create-fe_slip', 'App\Policies\FeSlipPolicy@create');
        Gate::define('update-fe_slip', 'App\Policies\FeSlipPolicy@update');
        Gate::define('delete-fe_slip', 'App\Policies\FeSlipPolicy@delete');
    }
}
