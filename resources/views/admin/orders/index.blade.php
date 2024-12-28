@extends('admin.layouts.admin')

@section('styles')

@endsection
@section('content')

    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="page-title">
                        Orders
                    </h2>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <form action="{{route('orders.filter')}}" method="post">
                            @csrf
                            <div class="input-group">


                                <input placeholder="Enter Order Name,Customer Name" type="text" @if (isset($request)) value="{{$request->orders_filter}}" @endif name="orders_filter" id="question_email" autocomplete="off" class="form-control">
                                @if(isset($request))
                                    <a href="{{route('orders')}}" type="button" class="btn btn-secondary clear_filter_data mx-1 mr-1 pl-4 pr-4">Clear</a>
                                @endif
                                <button type="submit" class="btn btn-primary mx-1 mr-1 pl-4 pr-4">Filter</button>

                            </div>
                        </form>
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
                        <div class="table-responsive">
                            @if (count($orders) > 0)
                                <table
                                        class="table table-vcenter card-table">
                                    <thead>
                                    <tr>

                                        <th>Order Num#</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th >Total Price</th>
                                        <th >Payment Status</th>
                                        <th>Fulfillment Status</th>
                                        <th>Session Status</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($orders as $order)

                                        <tr  class="product_detail" data-row_id="#varinat_details_{{$order->id}}">
                                            <td><a href="{{route('order.view',$order->id)}}"> {{$order->order_number}}</a></td>
                                            <td>{{$order->created_at->format('F d')}}</td>
                                            <td class="text-muted" >
                                                {{$order->shipping_name}}
                                            </td>
                                            <td>$ {{$order->total_price}}</td>
                                            <td><span class="badge bg-warning">{{ \Illuminate\Support\Str::title($order->financial_status) }}</span></td>

                                            @if($order->fulfillment_status==null)
                                                <td><span class="badge bg-danger">Unfulfilled</span></td>
                                            @else
                                                <td><span class="badge bg-blue">{{\Illuminate\Support\Str::title($order->fulfillment_status)}}</span></td>
                                            @endif
                                            <td>
                                                @if($order->session_order_items)
                                                    <span class="badge bg-azure">
                                                        @if($order->session_order_items->has_session->status=='sent_to_iraq')
                                                            Received in Iraq
                                                        @else
                                                            {{ucfirst($order->session_order_items->has_session->status)}}
                                                        @endif
                                                    </span>

                                                @endif
                                            </td>
                                            <td>
                                                <a target="_blank" href="https://admin.shopify.com/store/workingstore-1212/orders/{{$order->shopify_id}}" class="text-success" title="Shopify Order Link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                                                </a>
                                            </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h3 class="mx-3 my-3">No Orders Found</h3>
                            @endif

                            <div class="pagination">
                                {{ $orders->appends(\Illuminate\Support\Facades\Request::except('page'))->links("pagination::bootstrap-4") }}
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

        });
    </script>
@endsection
