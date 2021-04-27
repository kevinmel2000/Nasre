@extends('crm.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            @include('crm.customer.common.contact_inner_sidebar')
            <div class="col-md-9">
                <div class="card card-secondary">
                    <div class="card-header bg-gray">
                        <span class="float-left">{{__('Manage Proposals')}}</span>
                        @php
                            $relation = 'Customer';
                        @endphp
                        <a class="card-title bg-primary pl-2 pr-2 rounded float-right" href="{{url('proposal/create/'.$relation.'/'.$customer->id)}}" id="addNewNote" >{{__('New Proposal')}}</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="proposalsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Subject')}}</th>
                                    <th>{{__('To')}}</th>
                                    <th>{{__('Proposal Date')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Assigned To')}}</th>
                                    <th>{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$proposals as $proposal)
                                <tr>
                                    <td>{{@$proposal->id}}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#viewProposal{{@$proposal->id}}">
                                            {{@$proposal->subject}}
                                        </a>

                                        <div class="modal fade" id="viewProposal{{@$proposal->id}}" tabindex="-1"
                                            role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-danger">#{{@$proposal->id}} |
                                                            {{__('Proposal')}} - {{@$proposal->subject}} </h5>

                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Relation')}}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        value="{{@$proposal->relation}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Customer/Lead')}}</label>
                                                                    @if (@$proposal->relation == 'Customer')
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        value="{{@$proposal->customer->username}}"
                                                                        readonly>
                                                                    @else
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        value="{{@$proposal->lead->first_name}} {{@$proposal->lead->last_name}}"
                                                                        readonly>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Proposal Start Date')}}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        value="{{@$proposal->proposal_date}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Proposal End Date')}}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        value="{{@$proposal->open_till_date}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Status')}}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        value="{{@$proposal->status}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Currency')}}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        value="{{@$proposal->currency->name}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Assigned To')}}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        value="{{@$proposal->user->name}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Mail To')}}</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        value="{{@$proposal->mail_to}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">{{__('Message')}}</label>
                                                                    <textarea class="form-control form-control-sm"
                                                                        readonly>{{@$proposal->message}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table">
                                                                    <thead>
                                                                        <th>#</th>
                                                                        <th>{{__('Product')}}</th>
                                                                        <th>{{__('Price')}}</th>
                                                                        <th>{{__('Qty')}}</th>
                                                                        <th>{{__('Tax')}}</th>
                                                                        <th>{{__('Amount')}}</th>
                                                                        <th>{{__('Created At')}}</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach(@$proposal->proposalProducts as
                                                                        $product)
                                                                        <tr>
                                                                            <td>{{@$product->id}}</td>
                                                                            <td>{{@$product->product_name}}</td>
                                                                            <td>{{@$proposal->currency->symbol}}
                                                                                {{@$product->product_price}}</td>
                                                                            <td>{{@$product->product_qty}}</td>
                                                                            <td>{{@$product->product_tax}} %</td>
                                                                            <td>{{@$proposal->currency->symbol}}
                                                                                {{@$product->product_amount}}</td>
                                                                            <td>{{@$product->created_at}}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td>{{__('Sub Total')}}</td>
                                                                            <td>{{@$proposal->currency->symbol}}
                                                                                {{@$proposal->sub_total}}</td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td>{{__('Discount')}}</td>
                                                                            <td>{{@$proposal->total_discount_percentage}}%
                                                                            </td>
                                                                            <td>{{@$proposal->currency->symbol}}
                                                                                {{@$proposal->discountTotal}}</td>
                                                                            <td>{{@$proposal->discount_type}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td>{{__('Adjustments')}}</td>
                                                                            <td>{{@$proposal->currency->symbol}}
                                                                                {{@$proposal->adjustments}}</td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="4" class="font-bold">{{__('Total
                                                                                Amount = Sub Total - Discount +
                                                                                Adjustments')}} </td>
                                                                            <td>{{__('Total Amount')}}</td>
                                                                            <td>{{@$proposal->currency->symbol}}
                                                                                {{@$proposal->totalAmount}}</td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{__('Close')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- View Proposal Modal Ends --}}

                                    </td>
                                    <td>
                                        @if ($proposal->relation == 'Lead')
                                        <span class="badge badge-warning">{{@$proposal->relation}}</span>
                                        {{ @$proposal->lead->first_name }} {{ @$proposal->lead->last_name }} |
                                        {{ @$proposal->lead->email }}
                                        @else
                                        <span class="badge badge-success">{{@$proposal->relation}}</span>
                                        {{@$proposal->customer->username}}
                                        @endif
                                    </td>
                                    <td>{{@$proposal->proposal_date}}</td>
                                    <td>{{ucfirst(@$proposal->status)}}</td>
                                    <td>{{@$proposal->currency->name}} {{@$proposal->totalAmount}}</td>
                                    <td>{{@$proposal->user->name}}</td>
                                    <td>
                                        <span>
                                            @can('update-lead', User::class)
                                            <a class="pr-2" href="{{url('/proposal/edit', $proposal)}}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan

                                            @can('delete-lead', User::class)
                                            <span id="delbtn{{@$proposal->id}}"></span>
                                            <form id="delete-proposal-{{@$proposal->id}}"
                                                action="{{ url('proposal/destroy', $proposal) }}" method="POST"
                                                >
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            @endcan
                                        </span>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Subject')}}</th>
                                    <th>{{__('To')}}</th>
                                    <th>{{__('Proposal Date')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Assigned To')}}</th>
                                    <th>{{__('Actions')}}</th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>


{{-- ANCHOR MODAL VIEW proposal --}}


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>

{{-- MODAL VIEW proposal ENDS --}}

{{-- SECTION Add Currency modal Starts Here --}}
<div class="modal fade" id="addproposal" tabindex="-1" role="dialog" aria-labelledby="addproposalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addproposalLabel">{{__('Add proposal')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('office/currency/store')}}" method="POST">
                    @csrf


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-info">{{__('Add')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
{{-- !SECTION ADD Currency modal ends here --}}

@endsection

@section('scripts')
@include('crm.customer.proposal_js')
@endsection
