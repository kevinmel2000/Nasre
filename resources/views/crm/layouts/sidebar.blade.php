  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{url('/')}}" class="brand-link">
          <span class="brand-text font-weight-light text-light"><b>{{config('app.name')}}</b></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column
        nav-flat
        " data-widget="treeview" role="menu" data-accordion="false">
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

                  <li class="nav-item 
                  
                  ">
                      <a href="{{url('home')}}" class="nav-link {{@$home}}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              {{__('DASHBOARD')}}
                          </p>
                      </a>
                  </li>


                  
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
                                    <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('STAFF USERS')}}</p>
                                </a>
                            </li>
                            @endcan
                            @can('view-role', User::class)
                                <li class="nav-item">
                                    @if($route_active == 'roles')
                                    @php $manage_roles = 'active'; @endphp
                                    @endif
                                    <a href="{{url('user/role')}}" class="nav-link {{@$manage_roles}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('ROLES')}}</p>
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
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('PERMISSIONS')}}</p>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                  @endcan

                                   {{-- ANCHOR Leads Menu Starts here --}}
                                   @can('viewany-lead', User::class)
                                   @if(@$route_active == 'add_lead' || @$route_active == 'manage_lead' || @$route_active == 'lead_title'
                                   || @$route_active == 'show_lead' || @$route_active == 'lead_source' || @$route_active == 'lead_status'
                                   )
                                       @php
                                           $lead_dd = 'active';
                                           $lead_menu_open = 'menu-open';
                                       @endphp
                                   @else
                                       @php
                                           $lead_menu_open = 'menu-close';
                                       @endphp
                                   @endif
                                   <li class="nav-item has-treeview {{ @$lead_menu_open }}">
                                       <a href="#" class="nav-link {{@$lead_dd}}">
                                           <i class="nav-icon fas fa-user-clock"></i>
                                           <p>
                                            {{__('LEADS')}}
                                               <i class="right fas fa-angle-left"></i>
                                               <span class="badge badge-primary">{{session('total_leads')}}</span>
                                           </p>
                                       </a>
               
                                       <ul class="nav nav-treeview">
               
                                           @can('create-lead', Auth::user())
                                           @if($route_active == 'add_lead')
                                           @php
                                           $add_lead = 'active';
                                           @endphp
                                           @endif
                                           <li class="nav-item">
                                               <a href="{{url('lead/create')}}" class="nav-link {{@$add_lead}}">
                                                   <i class="far fa-folder nav-icon text-secondary"></i>
                                                   <p>{{__('NEW LEAD')}}</p>
                                               </a>
                                           </li>
                                           @endcan
               
                                           @can('view-lead', Auth::user())
                                           @if($route_active == 'manage_lead' || $route_active == 'show_lead')
                                           @php
                                           $manage_lead = 'active';
                                           @endphp
                                           @endif
                                           <li class="nav-item">
                                               <a href="{{url('lead')}}" class="nav-link {{@$manage_lead}}">
                                                   <i class="far fa-folder nav-icon text-secondary"></i>
                                                   <p>{{__('MANAGE LEADS')}}</p>
                                               </a>
                                           </li>
               
               
                                           @if($route_active == 'lead_source')
                                           @php
                                           $lead_source = 'active';
                                           @endphp
                                           @endif
                                           <li class="nav-item">
                                               <a href="{{url('lead/source')}}" class="nav-link {{@$lead_source}}">
                                                   <i class="far fa-folder nav-icon text-secondary"></i>
                                                   <p>{{__('LEAD SOURCES')}}</p>
                                               </a>
                                           </li>
               
                                           @if($route_active == 'lead_status')
                                           @php
                                           $lead_status = 'active';
                                           @endphp
                                           @endif
                                           <li class="nav-item">
                                               <a href="{{url('lead/status')}}" class="nav-link {{@$lead_status}}">
                                                   <i class="far fa-folder nav-icon text-secondary"></i>
                                                   <p>{{__('LEAD STATUSESS')}}</p>
                                               </a>
                                           </li>
                                           @endcan
                                       </ul>
                                   </li>
                                 @endcan

                  {{-- SECTION Product Menu  --}}
                  @can('viewany-product', User::class)
                    @if(@$route_active == 'productCreate' || @$route_active == 'product' || @$route_active ==
                    'productgroup')
                        @php
                        $product_dd = 'active';
                        $product_menu_open = 'menu-open';
                        @endphp
                    @else
                        @php
                        $product_menu_open = 'menu-close';
                        @endphp
                    @endif
                    <li class="nav-item has-treeview {{ @$product_menu_open }}">
                        <a href="#" class="nav-link {{@$product_dd}}">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                {{__('PRODUCTS')}}
                                <i class="right fas fa-angle-left"></i>
                                <span class="badge badge-primary">{{session('total_products')}}</span>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @can('create-product', Auth::user())
                            @if($route_active == 'productCreate')
                            @php
                            $productCreate = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('product/create')}}" class="nav-link {{@$productCreate}}">
                                    <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('NEW PRODUCT')}}</p>
                                </a>
                            </li>
                            @endcan

                            @can('view-product', Auth::user())
                            @if($route_active == 'product')
                            @php
                            $product = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('product/')}}" class="nav-link {{@$product}}">
                                    <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('PRODUCTS')}}</p>
                                </a>
                            </li>
                            @endcan

                            @can('view-product', Auth::user())
                            @if($route_active == 'productgroup')
                            @php
                            $productgroup = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('/product/productgroup')}}" class="nav-link {{@$productgroup}}">
                                    <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('GROUPS')}}</p>
                                </a>
                            </li>

                            @endcan
                        </ul>
                    </li>
                  @endcan

                  @can('viewany-lead', User::class)
                    @if(@$route_active == 'proposal' || @$route_active == 'proposalCreate')
                        @php
                        $proposal_dd = 'active';
                        $proposal_menu_open = 'menu-open';
                        @endphp
                    @else
                        @php
                        $proposal_menu_open = 'menu-close';
                        @endphp
                    @endif
                    <li class="nav-item has-treeview {{ @$proposal_menu_open }}">
                        <a href="#" class="nav-link {{@$proposal_dd}}">
                            <i class="nav-icon fas fa-business-time"></i>
                            <p>
                                {{__('PROPOSALS')}}
                                <i class="right fas fa-angle-left"></i>
                                <span class="badge badge-primary">{{session('total_proposals')}}</span>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            @can('create-lead', Auth::user())
                            @if($route_active == 'proposalCreate')
                            @php
                            $proposalCreate = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('proposal/create')}}" class="nav-link {{@$proposalCreate}}">
                                    <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('NEW PROPOSAL')}}</p>
                                </a>
                            </li>
                            @endcan

                            @can('view-lead', Auth::user())
                            @if($route_active == 'proposal')
                            @php
                            $proposal = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('proposal/')}}" class="nav-link {{@$proposal}}">
                                    <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('PROPOSALS')}}</p>
                                </a>
                            </li>
                            @endcan

                        </ul>
                    </li>
                  @endcan

                  @can('viewany-contact', User::class)
                    @if(@$route_active == 'add_contact' || @$route_active == 'manage_contact' || @$route_active ==
                    'contact_title' || @$route_active == 'show_contact' )
                        @php
                            $contact_dd = 'active';
                            $contact_menu_open = 'menu-open';
                        @endphp
                    @else
                        @php
                            $contact_menu_open = 'menu-close';
                        @endphp
                    @endif
                    <li class="nav-item has-treeview {{ @$contact_menu_open }}">
                        <a href="#" class="nav-link {{@$contact_dd}}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                {{__('CUSTOMERS')}}
                                <i class="right fas fa-angle-left"></i>
                                <span class="badge badge-primary">{{session('total_customers')}}</span>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            @can('create-contact', Auth::user())
                            @if($route_active == 'add_contact')
                            @php
                            $add_contact = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('customer/create')}}" class="nav-link {{@$add_contact}}">
                                    <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('NEW CUSTOMER')}}</p>
                                </a>
                            </li>
                            @endcan

                            @can('view-contact', Auth::user())
                            @if($route_active == 'manage_contact' || $route_active == 'show_contact')
                            @php
                            $manage_contact = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('customer')}}" class="nav-link {{@$manage_contact}}">
                                    <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('CUSTOMERS')}}</p>
                                </a>
                            </li>


                            @if($route_active == 'contact_title')
                            @php
                            $contact_title = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('contact/title')}}" class="nav-link {{@$contact_title}}">
                                    <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('CONTACT TITLES')}}</p>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                  @endcan

                  {{-- SECTION ESTIMATES Menu  --}}
                  @can('viewany-contact', User::class)
                    @if(@$route_active == 'estimate' || @$route_active == 'estimateCreate')
                        @php
                        $estimate_dd = 'active';
                        $estimate_menu_open = 'menu-open';
                        @endphp
                    @else
                        @php
                        $estimate_menu_open = 'menu-close';
                        @endphp
                    @endif
                    <li class="nav-item has-treeview {{ @$estimate_menu_open }}">
                        <a href="#" class="nav-link {{@$estimate_dd}}">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                {{__('ESTIMATES')}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            @can('create-contact', Auth::user())
                                @if($route_active == 'estimateCreate')
                                @php
                                $estimateCreate = 'active';
                                @endphp
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('estimate/create')}}" class="nav-link {{@$estimateCreate}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('NEW ESTIMATE')}}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('view-contact', Auth::user())
                                @if($route_active == 'estimate')
                                @php
                                $estimate = 'active';
                                @endphp
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('estimate/')}}" class="nav-link {{@$estimate}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('ESTIMATES')}}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                  @endcan
                  {{-- !SECTION ESTIMATES menu --}}

                  {{-- SECTION INVOICES Menu  --}}
                  @can('viewany-contact', User::class)
                    @if(@$route_active == 'invoice' || @$route_active == 'invoiceCreate')
                        @php
                        $invoice_dd = 'active';
                        $invoice_menu_open = 'menu-open';
                        @endphp
                    @else
                        @php
                        $invoice_menu_open = 'menu-close';
                        @endphp
                    @endif
                    <li class="nav-item has-treeview {{ @$invoice_menu_open }}">
                        <a href="#" class="nav-link {{@$invoice_dd}}">
                            <i class="nav-icon fas fa-money-check"></i>
                            <p>
                                {{__('INVOICES')}}
                                <i class="right fas fa-angle-left"></i>
                                <span class="badge badge-primary">{{session('total_invoices')}}</span>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            @can('create-contact', Auth::user())
                                @if($route_active == 'invoiceCreate')
                                @php
                                $invoiceCreate = 'active';
                                @endphp
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('invoice/create')}}" class="nav-link {{@$invoiceCreate}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('NEW INVOICE')}}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('view-contact', Auth::user())
                                @if($route_active == 'invoice')
                                @php
                                $invoice = 'active';
                                @endphp
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('invoice/')}}" class="nav-link {{@$invoice}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('INVOICES')}}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                  @endcan

                  @can('viewany-lead', User::class)
                    @if(@$route_active == 'task')
                    @php
                    $task_dd = 'active';
                    $task_menu_open = 'menu-open';
                    @endphp
                    @else
                    @php
                    $task_menu_open = 'menu-close';
                    @endphp
                    @endif
                    <li class="nav-item has-treeview {{ @$task_menu_open }}">
                        <a href="{{url('task/')}}"  class="nav-link {{@$task_dd}}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                {{__('TASKS')}}
                            </p>
                        </a>
                    </li>
                  @endcan

                    @can('viewany-lead', User::class)
                        @if(@$route_active == 'media')
                            @php
                            $media_dd = 'active';
                            $media_menu_open = 'menu-open';
                            @endphp
                        @else
                            @php
                            $media_menu_open = 'menu-close';
                            @endphp
                        @endif
                        <li class="nav-item has-treeview {{ @$media_menu_open }}">
                            <a href="{{url('media/')}}"  class="nav-link {{@$media_dd}}">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p>
                                    {{__('MEDIA FILES')}}
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('viewany-lead', User::class)
                        @if(@$route_active == 'reminder')
                            @php
                            $reminder_dd = 'active';
                            $reminder_menu_open = 'menu-open';
                            @endphp
                        @else
                            @php
                            $reminder_menu_open = 'menu-close';
                            @endphp
                        @endif
                        <li class="nav-item has-treeview {{ @$reminder_menu_open }}">
                            <a href="{{url('reminder/')}}"  class="nav-link {{@$reminder_dd}}">
                                <i class="nav-icon fas fa-business-time"></i>
                                <p>{{__('REMINDERS')}}</p>
                            </a>
                        </li>
                    @endcan


                @can('viewany-office', User::class)
                    @if(
                    @$route_active == 'taxrate' || 
                    @$route_active == 'currency' || 
                    @$route_active == 'paymentmode' || 
                    @$route_active == 'tech_setting' || 
                    @$route_active == 'general_setting'
                    )
                        @php
                        $finance_dd = 'active';
                        $finance_menu_open = 'menu-open';
                        @endphp
                    @else
                        @php
                        $finance_menu_open = 'menu-close';
                        @endphp
                    @endif
                    <li class="nav-item has-treeview {{ @$finance_menu_open }}">
                        <a href="#" class="nav-link {{@$finance_dd}}">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                {{__('OFFICE SETTINGS')}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            @can('view-office', Auth::user())
                                @if($route_active == 'taxrate')
                                @php
                                $taxrate = 'active';
                                @endphp
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('/office/taxrate')}}" class="nav-link {{@$taxrate}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('TAX RATES')}}</p>
                                    </a>
                                </li>
                            
                                @if($route_active == 'currency')
                                @php
                                $currency = 'active';
                                @endphp
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('/office/currency')}}" class="nav-link {{@$currency}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('CURRENCIES')}}</p>
                                    </a>
                                </li>

                                @if($route_active == 'paymentmode')
                                    @php
                                        $paymentmode = 'active';
                                    @endphp
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('/office/paymentmode')}}" class="nav-link {{@$paymentmode}}">
                                            <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('PAYMENT MODES')}}</p>
                                    </a>
                                </li>

                                @if($route_active == 'general_setting')
                                @php
                                    $general_settings = 'active';
                                @endphp
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('/office/general_setting')}}" class="nav-link {{@$general_settings}}">
                                            <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('GENERAL SETTINGS')}}</p>
                                    </a>
                                </li>
                                
                                @if($route_active == 'tech_setting')
                                @php
                                    $tech_settings = 'active';
                                @endphp
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('/office/tech_setting')}}" class="nav-link {{@$tech_settings}}">
                                            <i class="far fa-folder nav-icon text-secondary"></i>
                                        <p>{{__('SMTP SETTINGS')}}</p>
                                    </a>
                                </li>

                            @endcan

                            
                            
                        </ul>
                    </li>
                @endcan

                @can('viewany-office', User::class)
                    @if(
                    @$route_active == 'Web to Lead Form' 
                    || @$route_active == 'Fields' 
                    || @$route_active == 'Create Form' 
                    )
                        @php
                        $finance_dd = 'active';
                        $finance_menu_open = 'menu-open';
                        @endphp
                    @else
                        @php
                        $finance_menu_open = 'menu-close';
                        @endphp
                    @endif
                    <li class="nav-item has-treeview {{ @$finance_menu_open }}">
                        <a href="#" class="nav-link {{@$finance_dd}}">
                            <i class="nav-icon fas fa-network-wired"></i>
                            <p>
                                {{__('WEB TO LEAD FORMS')}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            @if($route_active == 'Fields')
                            @php
                                $formfield = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('/office/formfield')}}" class="nav-link {{@$formfield}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('FORM FIELDS')}}</p>
                                </a>
                            </li>


                            @if($route_active == 'Create Form')
                            @php
                                $create_form = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('/office/create_form')}}" class="nav-link {{@$create_form}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('CREATE FORM')}}</p>
                                </a>
                            </li>

                            @if($route_active == 'Web to Lead Form')
                            @php
                                $web_form = 'active';
                            @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{url('/office/web_forms')}}" class="nav-link {{@$web_form}}">
                                        <i class="far fa-folder nav-icon text-secondary"></i>
                                    <p>{{__('FORMS')}}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
              </ul>
          </nav>
      </div>
  </aside>
