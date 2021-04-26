  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{url('/')}}" class="brand-link">
          <img src="{{asset('storage/adminfiles/'.session('logo_file'))}}" alt="{{config('app.name')}} Logo"
              class="brand-image">
          <span class="brand-text font-weight-light text-light"><b>{{config('app.name')}}</b></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column  nav-flat " data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

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
                      <a href="{{url('client/home')}}" class="nav-link {{@$home}}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              DASHBOARD
                          </p>
                      </a>

                  </li>

                  {{-- SECTION Proposals Menu  --}}
                    @if(@$route_active == 'proposal')
                        @php
                        $proposal_dd = 'active';
                        @endphp
                    @else
                        @php
                        $proposal_dd = '';
                        @endphp
                    @endif
                    <li class="nav-item">
                        <a href="{{url('client/proposals')}}" class="nav-link {{@$proposal_dd}}">
                            <i class="nav-icon fas fa-business-time"></i>
                            <p>
                                PROPOSALS
                                <span class="badge badge-primary">{{session('customer_proposals')}}</span>
                            </p>
                        </a>
                    </li>
                  {{-- !SECTION Proposals menu --}}

                {{-- SECTION Invoices Menu  --}}
                    @if(@$route_active == 'invoice')
                        @php
                        $invoice_dd = 'active';
                        @endphp
                    @else
                        @php
                        $invoice_dd = '';
                        @endphp
                    @endif
                    <li class="nav-item">
                        <a href="{{url('client/invoices')}}" class="nav-link {{@$invoice_dd}}">
                            <i class="nav-icon fas fa-money-check"></i>
                            <p>
                                INVOICES
                                <span class="badge badge-primary">{{session('customer_invoices')}}</span>
                            </p>
                        </a>
                    </li>
                {{-- !SECTION Invoices menu --}}

                {{-- SECTION Estimates Menu  --}}
                    @if(@$route_active == 'estimate')
                        @php
                        $estimate_dd = 'active';
                        @endphp
                    @else
                        @php
                        $estimate_dd = '';
                        @endphp
                    @endif
                    <li class="nav-item">
                        <a href="{{url('client/estimates')}}" class="nav-link {{@$estimate_dd}}">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                ESTIMATES
                                <span class="badge badge-primary">{{session('total_estimates')}}</span>
                            </p>
                        </a>
                    </li>
                {{-- !SECTION Estimates menu --}}

                {{-- SECTION Media Menu  --}}
                    @if(@$route_active == 'media')
                        @php
                        $media_dd = 'active';
                        @endphp
                    @else
                        @php
                        $media_dd = '';
                        @endphp
                    @endif
                    <li class="nav-item">
                        <a href="{{url('client/media')}}" class="nav-link {{@$media_dd}}">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                MEDIA FILES
                                <span class="badge badge-primary">{{session('total_media')}}</span>
                            </p>
                        </a>
                    </li>
                {{-- !SECTION Media menu --}}   

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
