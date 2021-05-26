<style>
    #myBtn {
      display: none;
      position: fixed;
      bottom: 20px;
      left: 30px;
      z-index: 99;
      font-size: 14px;
      border: none;
      outline: none;
      background-color: white;
      color: darkblue;
      cursor: pointer;
      padding: 10px;
      border-radius: 4px;
    }
    
    #myBtn:hover {
      background-color: #555;
    }
    </style>
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
          <!-- Brand Logo -->
          <a href="{{url('/')}}" class="brand-link">
              <span class="brand-text font-weight-light text-light"><b>{{config('app.name')}}</b></span>
          </a>
    
          <!-- Sidebar -->
          <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                    {{-- ANCHOR Dashboard Starts here --}}
                    @if($route_active == 'home')
                        @php
                            $home = 'active';
                            $home_menu_open = 'menu-open';
                        @endphp
                    @else
                        @php
                            $home_menu_open = '';
                        @endphp
                    @endif
    
                    <li class="nav-item">
                        <a href="{{url('home')}}" class="nav-link {{@$home}}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                {{__('DASHBOARD')}}
                            </p>
                        </a>
                    </li>
    
    
                    {{-- roles --}}
                    @can('viewany-role', User::class)
                        {{-- ANCHOR Users Menu Starts here --}}
                        @if( $route_active == 'users' || $route_active == 'roles' || $route_active == 'permissions' )
                            @php
                                $users = 'active';
                                $users_menu_open = 'menu-open';
                            @endphp
                        @else
                            @php
                                $users_menu_open = '';
                            @endphp
                        @endif
    
                        <li class="nav-item has-treeview {{@$users_menu_open }}">
                        
                            <a href="#" class="nav-link {{@$users}}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    
                                    <i class="right fas fa-angle-left"></i>
                                    {{__('STAFF MAMAGEMENT')}}
                                    <span class="badge badge-primary">{{session('total_users')}}</span>
                                </p>
                            </a>
                            
                            <ul class="nav nav-treeview">
                                @can('view-user', User::class)
                                <li class="nav-item">
                                    @if($route_active == 'users')
                                        @php $manage_users = 'active'; @endphp
                                    @endif
                                    <a href="{{url('user')}}" class="nav-link {{@$manage_users}}">
                                        <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                        <p style="font-size: 90%;margin-left:2%;">{{__('STAFF USERS')}}</p>
                                    </a>
                                </li>
                                @endcan
                                @can('view-role', User::class)
                                    <li class="nav-item">
                                        @if($route_active == 'roles')
                                        @php $manage_roles = 'active'; @endphp
                                        @endif
                                        <a href="{{url('user/role')}}" class="nav-link {{@$manage_roles}}">
                                            <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                            <p style="font-size: 90%;margin-left:2%;">{{__('ROLES')}}</p>
                                        </a>
                                    </li>
                                @endcan      
                                {{-- Only Admin can access --}}
                                @if (Auth::user()->role_id == '1')  
                                    <li class="nav-item">
                                        @if($route_active == 'permissions')
                                        @php $manage_permissions = 'active'; @endphp
                                        @endif
                                        <a href="{{url('user/role/permissions')}}" class="nav-link {{@$manage_permissions}}">
                                            <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                            <p style="font-size: 90%;margin-left:2%;">{{__('PERMISSIONS')}}</p>
                                        </a>
                                    </li>
                                @endif
    
                            </ul>
                        </li>
                    @endcan
    
                    
                
                    
    
                        {{-- @can('viewany-country', User::class) --}}
                            @if(
                                @$route_active == 'Country Master' 
                                || @$route_active == 'State Master' 
                                || @$route_active == 'City Master' 
                                || @$route_active == 'Currency Master' 
                                || @$route_active == 'Currency Exchange Master' 
                                || @$route_active == 'Fire & Engineering Lookup Location' 
                                || @$route_active == 'Marine - Lookup Ship' 
                                || @$route_active == 'Golf Field Hole' 
                                || @$route_active == 'KOC Master' 
                                || @$route_active == 'Ceding / Broker' 
                                || @$route_active == 'COB Master' 
                                || @$route_active == 'Occupation Master' 
                                || @$route_active == 'Earthquake Zone' 
                                || @$route_active == 'Flood Zone Master' 
                                || @$route_active == 'Country Master' 
                                || @$route_active == 'State Master' 
                                || @$route_active == 'City Master' 
                                || @$route_active == 'Ship Type Master' 
                                || @$route_active == 'Classification Master' 
                                || @$route_active == 'Construction Master' 
                                || @$route_active == 'Company Type Master' 
                                || @$route_active == 'Property Type Master' 
                                || @$route_active == 'Condition Needed Master' 
                                || @$route_active == 'Interest Insured Master' 
                                || @$route_active == 'Extend Coverage Master' 
                                || @$route_active == 'Deductible Type Master' 
                                || @$route_active == 'Ship Port Master' 
                                || @$route_active == 'Route Form Master' 
                                || @$route_active == 'Prefix Insured Master' 
                            )
                                @php
                                $master_dd = 'active';
                                $master_menu_open = 'menu-open';
                                @endphp
                            @else
                                @php
                                $master_menu_open = 'menu-close';
                                @endphp
                            @endif
                            <li class="nav-item has-treeview {{ @$master_menu_open }}">
                                <a href="#" class="nav-link {{@$master_dd}}">
                                    <i class="nav-icon fas fa-laptop"></i>
                                    <p>
                                        {{__('MASTER')}}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
    
                                <ul class="nav nav-treeview">
                                    @can('create-cedingbroker', User::class) 
                                        @if($route_active == 'Ceding / Broker')
                                            @php
                                                $cedingform = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$cedingform}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('CEDING/BROKER FORM')}}</p>
                                            </a>
                                        </li>
                                     @endcan 
    

                                    @can('create-cause_of_loss', User::class)
                                        @if($route_active == 'Cause Of Loss')
                                            @php
                                                $causeofloss = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$causeofloss}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('CAUSE OF LOSS FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    

                                    @can('create-cob', User::class)
                                        @if($route_active == 'COB Master')
                                            @php
                                                $cob_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$cob_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('COB FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-company_type', User::class)
                                        @if($route_active == 'Company Type Master')
                                            @php
                                                $ctform = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$ctform}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('COMPANY TYPE FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-condition_needed', User::class)
                                        @if($route_active == 'Condition Needed Master')
                                            @php
                                                $cdn_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$cdn_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('CONDITION NEEDED FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-currency', User::class)
                                        @if($route_active == 'Currency Master')
                                            @php
                                                $crc_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$crc_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('CURRENCY FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-exchange', User::class)
                                        @if($route_active == 'Currency Exchange Master')
                                            @php
                                                $exchange_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$exchange_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('CURRENCY EXCHANGE')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-deductible', User::class)
                                        @if($route_active == 'Deductible Type Master')
                                            @php
                                                $dt_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$dt_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('DEDUCTIBLE TYPE FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-eqz', User::class)
                                        @if($route_active == 'Earthquake Zone')
                                            @php
                                                $earthquakezone_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$earthquakezone_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('EARTHQUAKE ZONE FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-extend_coverage', User::class)
                                        @if($route_active == 'Extend Coverage Master')
                                            @php
                                                $ec_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$ec_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('EXTEND COVERAGE FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-fz', User::class)
                                        @if($route_active == 'Flood Zone Master')
                                            @php
                                                $flood_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$flood_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('FLOOD ZONE FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-gfh', User::class)
                                            @if($route_active == 'Golf Field Hole')
                                                {{-- @php
                                                    $gfh_form = 'active';
                                                @endphp --}}
                                            @endif
                                            <li class="nav-item">
                                                <a href="" class="nav-link {{@$gfh_form}}">
                                                        <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                    <p style="font-size: 90%;margin-left:2%;">{{__('GOLF FIELD HOLE')}}</p>
                                                </a>
                                            </li>
                                    @endcan
    
                                    @can('create-interest_insured', User::class)
                                        @if($route_active == 'Interest Insured Master')
                                            @php
                                                $ii_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$ii_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('INTEREST INSURED FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-koc', User::class)
                                            @if($route_active == 'KOC Master')
                                                @php
                                                    $koc_form = 'active';
                                                @endphp
                                            @endif
                                            <li class="nav-item">
                                                <a href="" class="nav-link {{@$koc_form}}">
                                                        <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                    <p style="font-size: 90%;margin-left:2%;">{{__('KIND OF CONTRACT')}}</p>
                                                </a>
                                            </li>
                                    @endcan
    
                                    @can('create-location_master', User::class)
                                    @if(
                                        @$route_active == 'Country Master' 
                                        || @$route_active == 'State Master' 
                                        || @$route_active == 'City Master' 
                                        )
                                        @php
                                            $location_dd = 'active';
                                            $location_menu_open = 'menu-open';
                                        @endphp
                                    @else
                                        @php
                                            $location_menu_open = 'menu-close';
                                        @endphp
                                    @endif
                                    <li class="nav-item has-treeview {{ @$location_menu_open }}">
                                        <a href="#" class="nav-link {{@$location_dd}}" >
                                            <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                            <p style="font-size: 90%;margin-left:2%;" >
                                                {{__('LOCATION')}}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
    
                                        <ul class="nav nav-treeview">
                                            @can('create-country', User::class)
                                                @if($route_active == 'Country Master')
                                                    @php
                                                        $countryform = 'active';
                                                    @endphp
                                                @endif
                                                <li class="nav-item">
                                                    <a href="" class="nav-link {{@$countryform}}">
                                                        <i class="far fa-folder nav-icon text-secondary" style="margin-left:14%;"></i>
                                                        <p style="font-size: 80%;margin-left:2%;">{{__('COUNTRY FORM')}}</p>
                                                    </a>
                                                </li>
                                            @endcan
                                                
                                            @can('create-state', User::class)
                                                @if($route_active == 'State Master')
                                                    @php
                                                        $state_form = 'active';
                                                    @endphp
                                                @endif
                                                <li class="nav-item">
                                                    <a href="" class="nav-link {{@$state_form}}">
                                                            <i class="far fa-folder nav-icon text-secondary" style="margin-left:14%;"></i>
                                                        <p style="font-size: 80%;margin-left:2%;">{{__('PROVINCE FORM')}}</p>
                                                    </a>
                                                </li>
                                            @endcan
                
                                            @can('viewany-city', User::class)
                                                @if($route_active == 'City Master')
                                                    @php
                                                        $city_form = 'active';
                                                    @endphp
                                                @endif
                                                <li class="nav-item">
                                                    <a href="" class="nav-link {{@$city_form}}">
                                                            <i class="far fa-folder nav-icon text-secondary" style="margin-left:14%;"></i>
                                                        <p style="font-size: 80%;margin-left:2%;">{{__('CITY FORM')}}</p>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcan
    
                                    @can('create-felookup', User::class)
                                        @if($route_active == 'Fire & Engineering Lookup Location')
                                            @php
                                                $felookuplocationform = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$felookuplocationform}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('LOOKUP LOCATION')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-marinelookup', User::class)
                                        @if($route_active == 'Marine - Lookup Ship')
                                            @php
                                                $marinelookupform = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$marinelookupform}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('MARINE - LOOKUP FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-marine_master', User::class)
                                    @if(
                                        @$route_active == 'Ship Type Master' 
                                        || @$route_active == 'Classification Master' 
                                        || @$route_active == 'Construction Master' 
                                        )
                                            @php
                                            $marine_dd = 'active';
                                            $marine_menu_open = 'menu-open';
                                            @endphp
                                    @else
                                        @php
                                            $location_menu_open = 'menu-close';
                                        @endphp
                                    @endif
                                    <li class="nav-item has-treeview {{ @$marine_menu_open }}">
                                        <a href="#" class="nav-link {{@$marine_dd}}">
                                            <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                            <p style="font-size: 90%;margin-left:2%;">
                                                {{__('MARINE MASTER')}}
                                                <i class="right fas fa-angle-left" ></i>
                                            </p>
                                        </a>
        
                                        <ul class="nav nav-treeview">
                                            @can('create-shiptype', User::class)
                                                @if($route_active == 'Ship Type Master')
                                                    @php
                                                        $shiptypeform = 'active';
                                                    @endphp
                                                @endif
                                                <li class="nav-item">
                                                    <a href="" class="nav-link {{@$shiptypeform}}">
                                                            <i class="far fa-folder nav-icon text-secondary" style="margin-left:14%;"></i>
                                                        <p style="font-size: 80%;margin-left:2%;">{{__('SHIP TYPE FORM')}}</p>
                                                    </a>
                                                </li>
                                            @endcan
                                                
                                            @can('create-classification', User::class)
                                                @if($route_active == 'Classification Master')
                                                    @php
                                                        $classification_form = 'active';
                                                    @endphp
                                                @endif
                                                <li class="nav-item">
                                                    <a href="" class="nav-link {{@$classification_form}}">
                                                            <i class="far fa-folder nav-icon text-secondary" style="margin-left:14%;"></i>
                                                        <p style="font-size: 80%;margin-left:2%;">{{__('CLASSIFICATION FORM')}}</p>
                                                    </a>
                                                </li>
                                            @endcan
                
                                            @can('create-construction', User::class)
                                                @if($route_active == 'Construction Master')
                                                    @php
                                                        $construction_form = 'active';
                                                    @endphp
                                                @endif
                                                <li class="nav-item">
                                                    <a href="" class="nav-link {{@$construction_form}}">
                                                            <i class="far fa-folder nav-icon text-secondary" style="margin-left:14%;"></i>
                                                        <p style="font-size: 80%;margin-left:2%;">{{__('CONSTRUCTION FORM')}}</p>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcan

                                    @can('create-prefix_insured', User::class)
                                        @if($route_active == 'Prefix Insured Master')
                                            @php
                                                $masterprefix = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$masterprefix}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('PREFIX INSURED MASTER DATA')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
    
                                    @can('create-occupation', User::class)
                                        @if($route_active == 'Occupation Master')
                                            @php
                                                $ocp_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$ocp_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('OCCUPATION FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-property_type', User::class)
                                        @if($route_active == 'Property Type Master')
                                            @php
                                                $property_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$property_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('PROPERTY TYPE FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('create-nature_of_loss', User::class)
                                        @if($route_active == 'Nature Of Loss')
                                            @php
                                                $natureofloss = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$natureofloss}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('NATURE OF LOSS FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-route', User::class)
                                        @if($route_active == 'Route Form Master')
                                            @php
                                                $rf_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$rf_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('ROUTE FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan
    
                                    @can('create-ship_port', User::class)
                                        @if($route_active == 'Ship Port Master')
                                            @php
                                                $sp_form = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$sp_form}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('SHIP PORT FORM')}}</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('create-surveyor', User::class)
                                        @if($route_active == 'Surveyor')
                                            @php
                                                $surveyor = 'active';
                                            @endphp
                                        @endif
                                        <li class="nav-item">
                                            <a href="" class="nav-link {{@$surveyor}}">
                                                    <i class="far fa-folder nav-icon text-secondary" style="margin-left:8%;"></i>
                                                <p style="font-size: 90%;margin-left:2%;">{{__('SURVEYOR')}}</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        {{-- @endcan --}}
                    
    
                </ul>
    
                <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up" aria-hidden="true" ></i><span style="font-family:Source Sans Pro;font-weight: bold;"> TOP</span></button>
    
            </nav>
          </div>
      </aside>
      <script>
        //Get the button
        var mybutton = document.getElementById("myBtn");
        
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};
        
        function scrollFunction() {
          if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
          } else {
            mybutton.style.display = "none";
          }
        }
        
        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
          document.body.scrollTop = 0;
          document.documentElement.scrollTop = 0;
        }
    </script>