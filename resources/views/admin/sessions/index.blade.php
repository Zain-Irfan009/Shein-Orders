@extends('admin.layouts.admin')

@section('styles')
 <style>
     .card-header-tabs{
         background: #bcd8f5;
     }

     #ordersTable_length{
         margin-bottom:12px;
     }
     table.dataTable.no-footer{
         /*border-bottom:none;*/
     }
 </style>
@endsection
@section('content')

    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="page-title">
                        Sessions
                    </h2>
                </div>

                <div class="col-md-6 " >

                    <div class="form-group" style="text-align: right">
                   <a href="{{route('create_session')}}" class="btn btn-primary">Create Session</a>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="page-body">

        <div class="container-xl">
            <div class="row row-deck row-cards">

                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                                <li class="nav-item">
                                    <a href="#tabs-home-5" class="nav-link active" data-bs-toggle="tab">Pending Order from SHEIN ({{$pending_sessions_count}})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tabs-profile-5" class="nav-link" data-bs-toggle="tab">Waiting to Purchase ({{$waiting_to_purchase_count}})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tabs-activity-5" class="nav-link" data-bs-toggle="tab">Ordered on SHEIN ({{$ordered_on_sheins_count}})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tabs-activity-6" class="nav-link" data-bs-toggle="tab">Shipped from SHEIN ({{$shipped_from_sheins_count}}</a>
                                </li>

{{--                                <li class="nav-item">--}}
{{--                                    <a href="#tabs-activity-7" class="nav-link" data-bs-toggle="tab">Received in Dubai</a>--}}
{{--                                </li>--}}
                                <li class="nav-item">
                                    <a href="#tabs-activity-8" class="nav-link" data-bs-toggle="tab">Received in Iraq ({{$sent_to_iraq_count}})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tabs-activity-9" class="nav-link" data-bs-toggle="tab">Fulfilled ({{$fulfilled_orders_count}})</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-home-5">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            @if(count($pending_sessions) > 0)
                                            <table id="ordersTable" class="display table">
                                                <thead>
                                                <tr>
                                                    <th>Session Id</th>
                                                    <th>No of items</th>
                                                    <th>Date Created</th>
                                                    <th>Action</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($pending_sessions as $index=> $pending_session)
                                                        <tr>
                                                            <td>#{{++$index}}</td>
                                                            <td>{{$pending_session->no_of_items}}</td>
                                                            <td>{{ $pending_session->created_at->format('d F, Y') }}</td>
                                                            <td style="display: flex">
                                                                <select class="status-dropdown form-control" data-session-id="{{ $pending_session->id }}">
                                                                    <option value="pending" {{ $pending_session->status == 'pending' ? 'selected' : '' }}>Pending Order From Shein</option>
                                                                    <option value="waiting_to_purchase" {{ $pending_session->status == 'waiting_to_purchase' ? 'selected' : '' }}>Waiting to Purchase</option>
                                                                    <option value="ordered_on_shein" {{ $pending_session->status == 'ordered_on_shein' ? 'selected' : '' }}>Ordered on Shein</option>
                                                                    <option value="shipped_from_shein" {{ $pending_session->status == 'shipped_from_shein' ? 'selected' : '' }}>Shipping from Shein</option>
{{--                                                                    <option value="received_in_dubai" {{ $pending_session->status == 'received_in_dubai' ? 'selected' : '' }}>Received in Dubai</option>--}}
                                                                    <option value="sent_to_iraq" {{ $pending_session->status == 'sent_to_iraq' ? 'selected' : '' }}>Received in Iraq</option>
                                                                    <option value="fulfilled" {{ $pending_session->status == 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                                                                </select>

                                                                <div style="display:inline-flex;margin-top:9px;margin-left: 6px">

                                                                <a href="{{ route('view_session', $pending_session->id) }}" class="text-primary" title="View">
                                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                </a>

                                                                <a  data-id="{{$pending_session->id}}" class="text-danger delete_single_btn" title="Delete" >
                                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                                </a>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                @endforeach

                                                </tbody>
                                            </table>

                                            @else
                                                No Record Found
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-profile-5">

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            @if(count($waiting_to_purchase) > 0)
                                            <table id="ordersTable1" class="display table">
                                                <thead>
                                                <tr>
                                                    <th>Session Id</th>
                                                    <th>No of items</th>
                                                    <th>Date Created</th>

                                                    <th>Action</th>

                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($waiting_to_purchase as $index=> $purchase)
                                                    <tr>
                                                        <td>#{{++$index}}</td>
                                                        <td>{{$purchase->no_of_items}}</td>
                                                        <td>{{ $purchase->created_at->format('d F, Y') }}</td>

                                                        <td style="display: flex">
                                                            <select class="status-dropdown form-control" data-session-id="{{ $purchase->id }}">
                                                                <option value="pending" {{ $purchase->status == 'pending' ? 'selected' : '' }}>Pending Order From Shein</option>
                                                                <option value="waiting_to_purchase" {{ $purchase->status == 'waiting_to_purchase' ? 'selected' : '' }}>Waiting to Purchase</option>
                                                                <option value="ordered_on_shein" {{ $purchase->status == 'ordered_on_shein' ? 'selected' : '' }}>Ordered on Shein</option>
                                                                <option value="shipped_from_shein" {{ $purchase->status == 'shipped_from_shein' ? 'selected' : '' }}>Shipping from Shein</option>
{{--                                                                <option value="received_in_dubai" {{ $purchase->status == 'received_in_dubai' ? 'selected' : '' }}>Received in Dubai</option>--}}
                                                                <option value="sent_to_iraq" {{ $purchase->status == 'sent_to_iraq' ? 'selected' : '' }}>Received in Iraq</option>
                                                                <option value="fulfilled" {{ $purchase->status == 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                                                            </select>

                                                            <div style="display:inline-flex;margin-top:9px;margin-left: 6px">

                                                                <a href="{{ route('view_session', $purchase->id) }}" class="text-primary" title="View">
                                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                </a>

                                                                <a  data-id="{{$purchase->id}}" class="text-danger delete_single_btn" title="Delete" >
                                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                                </a>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach


                                                </tbody>
                                            </table>
                                            @else
                                                No Record Found
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="tabs-activity-5">

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            @if(count($ordered_on_sheins) > 0)
                                                <table id="ordersTable2" class="display table">
                                                    <thead>
                                                    <tr>
                                                        <th>Session Id</th>
                                                        <th>No of items</th>
                                                        <th>Date Purchase</th>
                                                        <th>Package NO</th>
                                                        <th>Action</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($ordered_on_sheins as $index=> $ordered_on_shein)
                                                        <tr>
                                                            <td>#{{++$index}}</td>
                                                            <td>{{$ordered_on_shein->no_of_items}}</td>
                                                            <td>{{ $ordered_on_shein->created_at->format('d F, Y') }}</td>
                                                            <td>{{$ordered_on_shein->has_packages_count}}</td>
                                                            <td style="display: flex">
                                                                <select class="status-dropdown form-control" data-session-id="{{ $ordered_on_shein->id }}">
                                                                    <option value="pending" {{ $ordered_on_shein->status == 'pending' ? 'selected' : '' }}>Pending Order From Shein</option>
                                                                    <option value="waiting_to_purchase" {{ $ordered_on_shein->status == 'waiting_to_purchase' ? 'selected' : '' }}>Waiting to Purchase</option>
                                                                    <option value="ordered_on_shein" {{ $ordered_on_shein->status == 'ordered_on_shein' ? 'selected' : '' }}>Ordered on Shein</option>
                                                                    <option value="shipped_from_shein" {{ $ordered_on_shein->status == 'shipped_from_shein' ? 'selected' : '' }}>Shipping from Shein</option>
{{--                                                                    <option value="received_in_dubai" {{ $ordered_on_shein->status == 'received_in_dubai' ? 'selected' : '' }}>Received in Dubai</option>--}}
                                                                    <option value="sent_to_iraq" {{ $ordered_on_shein->status == 'sent_to_iraq' ? 'selected' : '' }}>Received in Iraq</option>
                                                                    <option value="fulfilled" {{ $ordered_on_shein->status == 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                                                                </select>

                                                                <div style="display:inline-flex;margin-top:9px;margin-left: 6px">

                                                                    @if($ordered_on_shein->session_order_no)
                                                                    <a target="_blank" href="https://www.shein.com/user/orders/detail/{{$ordered_on_shein->session_order_no}}" class="text-success" title="Session Link">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                                                                    </a>
                                                                    <a target="_blank" href="https://www.shein.com/user/orders/track/{{$ordered_on_shein->session_order_no}}" class="text-info" title="Tracking Link">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-truck"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" /></svg>
                                                                    </a>
                                                                    @endif
                                                                    <a href="{{ route('view_session', $ordered_on_shein->id) }}" class="text-primary" title="View">
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                    </a>
                                                                    <a  data-id="{{$ordered_on_shein->id}}" class="text-danger delete_single_btn" title="Delete" >
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                                    </a>

                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach


                                                    </tbody>
                                                </table>
                                            @else
                                                No Record Found
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="tabs-activity-6">

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            @if(count($shipped_from_sheins) > 0)
                                                <table id="ordersTable3" class="display table">
                                                    <thead>
                                                    <tr>
                                                        <th>Session Id</th>
                                                        <th>No of items</th>
                                                        <th>Date Created</th>
                                                        <th>Session Link</th>
                                                        <th>tracking Link</th>
                                                        <th>Action</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($shipped_from_sheins as $index=> $shipped_from_shein)
                                                        <tr>
                                                            <td>#{{++$index}}</td>
                                                            <td>{{$shipped_from_shein->no_of_items}}</td>
                                                            <td>{{ $shipped_from_shein->created_at->format('d F, Y') }}</td>
                                                            <td>{{$shipped_from_shein->session_link}}</td>
                                                            <td>{{$shipped_from_shein->tracking_link}}</td>
                                                            <td style="display: flex">
                                                                <select class="status-dropdown form-control" data-session-id="{{ $shipped_from_shein->id }}">
                                                                    <option value="pending" {{ $shipped_from_shein->status == 'pending' ? 'selected' : '' }}>Pending Order From Shein</option>
                                                                    <option value="waiting_to_purchase" {{ $shipped_from_shein->status == 'waiting_to_purchase' ? 'selected' : '' }}>Waiting to Purchase</option>
                                                                    <option value="ordered_on_shein" {{ $shipped_from_shein->status == 'ordered_on_shein' ? 'selected' : '' }}>Ordered on Shein</option>
                                                                    <option value="shipped_from_shein" {{ $shipped_from_shein->status == 'shipped_from_shein' ? 'selected' : '' }}>Shipping from Shein</option>
{{--                                                                    <option value="received_in_dubai" {{ $shipped_from_shein->status == 'received_in_dubai' ? 'selected' : '' }}>Received in Dubai</option>--}}
                                                                    <option value="sent_to_iraq" {{ $shipped_from_shein->status == 'sent_to_iraq' ? 'selected' : '' }}>Received in Iraq</option>
                                                                    <option value="fulfilled" {{ $shipped_from_shein->status == 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                                                                </select>

                                                                <div style="display:inline-flex;margin-top:9px;margin-left: 6px">

                                                                    <a href="{{ route('view_session', $shipped_from_shein->id) }}" class="text-primary" title="View">
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                    </a>

                                                                    <a  data-id="{{$shipped_from_shein->id}}" class="text-danger delete_single_btn" title="Delete" >
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                                    </a>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach


                                                    </tbody>
                                                </table>
                                            @else
                                                No Record Found
                                            @endif
                                        </div>
                                    </div>

                                </div>
{{--                                <div class="tab-pane" id="tabs-activity-7">--}}

{{--                                    <div class="row">--}}
{{--                                        <div class="col-lg-12 col-md-12">--}}
{{--                                            @if(count($received_in_dubai_orders) > 0)--}}
{{--                                                <table id="ordersTable4" class="display table">--}}
{{--                                                    <thead>--}}
{{--                                                    <tr>--}}
{{--                                                        <th>Session Id</th>--}}
{{--                                                        <th>No of items</th>--}}
{{--                                                        <th>Date Created</th>--}}
{{--                                                        <th>Session Link</th>--}}
{{--                                                        <th>tracking Link</th>--}}
{{--                                                        <th>Action</th>--}}

{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <tbody>--}}

{{--                                                    @foreach($received_in_dubai_orders as $index=> $received_in_dubai_order)--}}
{{--                                                        <tr>--}}
{{--                                                            <td>#{{++$index}}</td>--}}
{{--                                                            <td>{{$received_in_dubai_order->no_of_items}}</td>--}}
{{--                                                            <td>{{ $received_in_dubai_order->created_at->format('d F, Y') }}</td>--}}
{{--                                                            <td>{{$received_in_dubai_order->session_link}}</td>--}}
{{--                                                            <td>{{$received_in_dubai_order->tracking_link}}</td>--}}
{{--                                                            <td style="display: flex">--}}
{{--                                                                <select class="status-dropdown form-control" data-session-id="{{ $received_in_dubai_order->id }}">--}}
{{--                                                                    <option value="pending" {{ $received_in_dubai_order->status == 'pending' ? 'selected' : '' }}>Pending Order From Shein</option>--}}
{{--                                                                    <option value="waiting_to_purchase" {{ $received_in_dubai_order->status == 'waiting_to_purchase' ? 'selected' : '' }}>Waiting to Purchase</option>--}}
{{--                                                                    <option value="ordered_on_shein" {{ $received_in_dubai_order->status == 'ordered_on_shein' ? 'selected' : '' }}>Ordered on Shein</option>--}}
{{--                                                                    <option value="shipped_from_shein" {{ $received_in_dubai_order->status == 'shipped_from_shein' ? 'selected' : '' }}>Shipping from Shein</option>--}}
{{--                                                                    <option value="received_in_dubai" {{ $received_in_dubai_order->status == 'received_in_dubai' ? 'selected' : '' }}>Received in Dubai</option>--}}
{{--                                                                    <option value="sent_to_iraq" {{ $received_in_dubai_order->status == 'sent_to_iraq' ? 'selected' : '' }}>Sent to Iraq</option>--}}
{{--                                                                    <option value="fulfilled" {{ $received_in_dubai_order->status == 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>--}}
{{--                                                                </select>--}}

{{--                                                                <div style="display:inline-flex;margin-top:9px;margin-left: 6px">--}}

{{--                                                                    <a href="{{ route('view_session', $received_in_dubai_order->id) }}" class="text-primary" title="View">--}}
{{--                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>--}}
{{--                                                                    </a>--}}

{{--                                                                    <a  data-id="{{$received_in_dubai_order->id}}" class="text-danger delete_single_btn" title="Delete" >--}}
{{--                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>--}}
{{--                                                                    </a>--}}
{{--                                                                </div>--}}
{{--                                                            </td>--}}

{{--                                                        </tr>--}}
{{--                                                    @endforeach--}}


{{--                                                    </tbody>--}}
{{--                                                </table>--}}
{{--                                            @else--}}
{{--                                                No Record Found--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
                                <div class="tab-pane" id="tabs-activity-8">

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            @if(count($sent_to_iraq_orders) > 0)
                                                <table id="ordersTable5" class="display table">
                                                    <thead>
                                                    <tr>
                                                        <th>Session Id</th>
                                                        <th>No of items</th>
                                                        <th>Date Created</th>

                                                        <th>Action</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($sent_to_iraq_orders as $index=> $sent_to_iraq_order)
                                                        <tr>
                                                            <td>#{{++$index}}</td>
                                                            <td>{{$sent_to_iraq_order->no_of_items}}</td>
                                                            <td>{{ $sent_to_iraq_order->created_at->format('d F, Y') }}</td>

                                                            <td style="display: flex">
                                                                <select class="status-dropdown form-control" data-session-id="{{ $sent_to_iraq_order->id }}">
                                                                    <option value="pending" {{ $sent_to_iraq_order->status == 'pending' ? 'selected' : '' }}>Pending Order From Shein</option>
                                                                    <option value="waiting_to_purchase" {{ $sent_to_iraq_order->status == 'waiting_to_purchase' ? 'selected' : '' }}>Waiting to Purchase</option>
                                                                    <option value="ordered_on_shein" {{ $sent_to_iraq_order->status == 'ordered_on_shein' ? 'selected' : '' }}>Ordered on Shein</option>
                                                                    <option value="shipped_from_shein" {{ $sent_to_iraq_order->status == 'shipped_from_shein' ? 'selected' : '' }}>Shipping from Shein</option>
{{--                                                                    <option value="received_in_dubai" {{ $sent_to_iraq_order->status == 'received_in_dubai' ? 'selected' : '' }}>Received in Dubai</option>--}}
                                                                    <option value="sent_to_iraq" {{ $sent_to_iraq_order->status == 'sent_to_iraq' ? 'selected' : '' }}>Received in Iraq</option>
                                                                    <option value="fulfilled" {{ $sent_to_iraq_order->status == 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                                                                </select>

                                                                <div style="display:inline-flex;margin-top:9px;margin-left: 6px">

                                                                    @if($sent_to_iraq_order->session_order_no)
                                                                        <a target="_blank" href="https://www.shein.com/user/orders/detail/{{$sent_to_iraq_order->session_order_no}}" class="text-success" title="Session Link">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                                                                        </a>
                                                                        <a target="_blank" href="https://www.shein.com/user/orders/track/{{$sent_to_iraq_order->session_order_no}}" class="text-info" title="Tracking Link">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-truck"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" /></svg>
                                                                        </a>
                                                                    @endif
                                                                    <a href="{{ route('view_session', $sent_to_iraq_order->id) }}" class="text-primary" title="View">
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                    </a>

                                                                    <a  data-id="{{$sent_to_iraq_order->id}}" class="text-danger delete_single_btn" title="Delete" >
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                                    </a>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach


                                                    </tbody>
                                                </table>
                                            @else
                                                No Record Found
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="tabs-activity-9">

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            @if(count($fulfilled_orders) > 0)
                                                <table id="ordersTable6" class="display table">
                                                    <thead>
                                                    <tr>
                                                        <th>Session Id</th>
                                                        <th>No of items</th>
                                                        <th>Date Created</th>
                                                        <th>Session Link</th>
                                                        <th>tracking Link</th>
                                                        <th>Action</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($fulfilled_orders as $index=> $fulfilled_order)
                                                        <tr>
                                                            <td>#{{++$index}}</td>
                                                            <td>{{$fulfilled_order->no_of_items}}</td>
                                                            <td>{{ $fulfilled_order->created_at->format('d F, Y') }}</td>
                                                            <td>{{$fulfilled_order->session_link}}</td>
                                                            <td>{{$fulfilled_order->tracking_link}}</td>
                                                            <td style="display: flex">
                                                                <select class="status-dropdown form-control" data-session-id="{{ $fulfilled_order->id }}">
                                                                    <option value="pending" {{ $fulfilled_order->status == 'pending' ? 'selected' : '' }}>Pending Order From Shein</option>
                                                                    <option value="waiting_to_purchase" {{ $fulfilled_order->status == 'waiting_to_purchase' ? 'selected' : '' }}>Waiting to Purchase</option>
                                                                    <option value="ordered_on_shein" {{ $fulfilled_order->status == 'ordered_on_shein' ? 'selected' : '' }}>Ordered on Shein</option>
                                                                    <option value="shipped_from_shein" {{ $fulfilled_order->status == 'shipped_from_shein' ? 'selected' : '' }}>Shipping from Shein</option>
{{--                                                                    <option value="received_in_dubai" {{ $fulfilled_order->status == 'received_in_dubai' ? 'selected' : '' }}>Received in Dubai</option>--}}
                                                                    <option value="sent_to_iraq" {{ $fulfilled_order->status == 'sent_to_iraq' ? 'selected' : '' }}>Received in Iraq</option>
                                                                    <option value="fulfilled" {{ $fulfilled_order->status == 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                                                                </select>

                                                                <div style="display:inline-flex;margin-left: 6px;margin-top:9px">

{{--                                                                    <a target="_blank" href="{{route('print_invoice',$fulfilled_order->id)}}" class="text-primary" title="Print">--}}
                                                                    <a target="_blank" href="#" class="text-primary" title="Print">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                                                                    </a>

                                                                    <a href="{{ route('view_session', $fulfilled_order->id) }}" class="text-primary" title="View">
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                    </a>

                                                                    <a  data-id="{{$fulfilled_order->id}}" class="text-danger delete_single_btn" title="Delete" >
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                                    </a>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach


                                                    </tbody>
                                                </table>
                                            @else
                                                No Record Found
                                            @endif
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

    <script>

        $(document).ready(function() {
            $('#ordersTable').DataTable({
                "paging": true,        // Enable pagination
                "searching": true,     // Enable search bar
                "ordering": true,      // Enable sorting
                "info": true,          // Display table info
                "autoWidth": false,    // Prevent auto column width adjustment

            });

            $('#ordersTable1').DataTable({
                "paging": true,        // Enable pagination
                "searching": true,     // Enable search bar
                "ordering": true,      // Enable sorting
                "info": true,          // Display table info
                "autoWidth": false,    // Prevent auto column width adjustment

            });

            $('#ordersTable2').DataTable({
                "paging": true,        // Enable pagination
                "searching": true,     // Enable search bar
                "ordering": true,      // Enable sorting
                "info": true,          // Display table info
                "autoWidth": false,    // Prevent auto column width adjustment

            });
            $('#ordersTable3').DataTable({
                "paging": true,        // Enable pagination
                "searching": true,     // Enable search bar
                "ordering": true,      // Enable sorting
                "info": true,          // Display table info
                "autoWidth": false,    // Prevent auto column width adjustment

            });

            $('#ordersTable4').DataTable({
                "paging": true,        // Enable pagination
                "searching": true,     // Enable search bar
                "ordering": true,      // Enable sorting
                "info": true,          // Display table info
                "autoWidth": false,    // Prevent auto column width adjustment
            });

            $('#ordersTable5').DataTable({
                "paging": true,        // Enable pagination
                "searching": true,     // Enable search bar
                "ordering": true,      // Enable sorting
                "info": true,          // Display table info
                "autoWidth": false,    // Prevent auto column width adjustment
            });

            $('#ordersTable6').DataTable({
                "paging": true,        // Enable pagination
                "searching": true,     // Enable search bar
                "ordering": true,      // Enable sorting
                "info": true,          // Display table info
                "autoWidth": false,    // Prevent auto column width adjustment
            });

            $('.delete_single_btn').click(function(){
                var orderId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete!'
                }).then((result) => {
                    // If confirmed, the link will navigate to the specified route
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('delete_session', '') }}/" + orderId;
                    }
                });

            });

            $('.status-dropdown').change(function () {
                var sessionId = $(this).data('session-id');
                var selectedStatus = $(this).val();

                $.ajax({
                    url: '/update-session-status/' + sessionId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: selectedStatus
                    },
                    success: function (response) {
                        if (response.success) {
                            // Refresh the page to reflect changes
                            location.reload();
                        } else {
                            alert('Failed to update status');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

        });
    </script>
@endsection
