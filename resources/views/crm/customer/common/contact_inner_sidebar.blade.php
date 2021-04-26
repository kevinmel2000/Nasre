<div class="col-md-3">
    <!-- Links Card Starts -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{@$customer->first_contact->first_name}} {{@$customer->first_contact->last_name}}</h3>
        </div>
        <div class="card-body">
            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">

                @if ($route_active == 'show_contact')
                    <a class="nav-link active" href="{{url('/customer/show', @$customer)}}">{{__('Contacts')}}</a>
                @else
                    <a class="nav-link" href="{{url('/customer/show', @$customer)}}">{{__('Contacts')}}</a>
                @endif

                @if ($route_active == 'customer_note')
                    <a class="nav-link active" href="{{url('/customer/'.$customer->id.'/notes')}}">{{__('Notes')}}</a>
                @else
                    <a class="nav-link" href="{{url('/customer/'.$customer->id.'/notes')}}">{{__('Notes')}}</a>
                @endif

                @if ($route_active == 'customer_proposal')
                    <a class="nav-link active" href="{{url('/customer/'.$customer->id.'/proposals')}}">{{__('Proposals')}}</a>
                @else
                    <a class="nav-link" href="{{url('/customer/'.$customer->id.'/proposals')}}">{{__('Proposals')}}</a>
                @endif

                @if ($route_active == 'customer_invoice')
                    <a class="nav-link active" href="{{url('/customer/'.$customer->id.'/invoices')}}">{{__('Invoices')}}</a>
                @else
                    <a class="nav-link" href="{{url('/customer/'.$customer->id.'/invoices')}}">{{__('Invoices')}}</a>
                @endif

                @if ($route_active == 'customer_estimate')
                    <a class="nav-link active" href="{{url('/customer/'.$customer->id.'/estimates')}}">{{__('Estimates')}}</a>
                @else
                    <a class="nav-link" href="{{url('/customer/'.$customer->id.'/estimates')}}">{{__('Estimates')}}</a>
                @endif

                @if ($route_active == 'customer_task')
                    <a class="nav-link active" href="{{url('/customer/'.$customer->id.'/tasks')}}">{{__('Tasks')}}</a>
                @else
                    <a class="nav-link" href="{{url('/customer/'.$customer->id.'/tasks')}}">{{__('Tasks')}}</a>
                @endif

                @if ($route_active == 'customer_media')
                    <a class="nav-link active" href="{{url('/customer/'.$customer->id.'/media')}}">{{__('Media Files')}}</a>
                @else
                    <a class="nav-link" href="{{url('/customer/'.$customer->id.'/media')}}">{{__('Media Files')}}</a>
                @endif

                @if ($route_active == 'customer_reminder')
                    <a class="nav-link active" href="{{url('/customer/'.$customer->id.'/reminder')}}">{{__('Reminders')}}</a>
                @else
                    <a class="nav-link" href="{{url('/customer/'.$customer->id.'/reminder')}}">{{__('Reminders')}}</a>
                @endif
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- Links Card Ends -->

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <h3 class="profile-username text-center">{{ucfirst(@$customer->first_contact->first_name)}} {{ucfirst(@$customer->first_contact->last_name)}}</h3>

            <p class="text-muted text-center"><span class="text text-primary text-bold">{{@$customer->first_contact->title->name}} <br> {{@$customer->first_contact->company_name}}</span></p>

            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>{{__('Win Time')}}</b> <a class="float-right">

                        @if ($customer->success_timestamp != NULL)
                            @if (@$fromLead == True)
                                {{$customer->success_timestamp->toDayDateTimeString()}}
                            @else 
                                @php
                                    $dt = \Carbon\Carbon::create($customer->success_timestamp);
                                @endphp
                                {{$dt->toDayDateTimeString()}}
                            @endif
                        @else
                            {{$customer->created_at->toDayDateTimeString()}}
                        @endif
                    </a>
                </li>
                <li class="list-group-item">
                    <b>{{__('Last Updated')}}</b> <a class="float-right">{{$customer->updated_at->toDayDateTimeString()}}</a>
                </li>
            </ul>
        </div>
    </div>

</div>