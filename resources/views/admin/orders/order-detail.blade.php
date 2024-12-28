@extends('admin.layouts.admin')

@section('styles')

@endsection
@section('content')




    <div class="page-body">

        <div class="container-xl">
            <div class="row  row-cards">

                <div class="col-lg-12 col-md-12">

                        <div class="card card-border-radius pt-4 pb-1">
                            <div class="row" style="overflow: hidden">
                                <div class="col-md-6 d-flex">
                                    <div class="custom-left-arrow-div " >
                                        <a style="text-decoration: none; padding:19px; font-size: 25px; color: black;" href="{{route('orders')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                                    </div>
                                    <div><h2 style="margin-top: 3px;">{{$order->order_number}}</h2></div>
                                    <h4 style="margin-top: 4px"><span class="badge bg-warning mx-4">{{ \Illuminate\Support\Str::title($order->financial_status) }}</span></h4>

                                    @if($order->fulfillment_status==null)
                                        <h4 style="margin-top: 4px"><span class="badge bg-danger mx-2">Unfulfilled</span></h4>

                                    @else
                                        <h4 style="margin-top: 4px"><span class="badge bg-primary mx-2">{{ \Illuminate\Support\Str::title($order->fulfillment_status) }}</span></h4>

                                    @endif


                                </div>
                                <div class="col-5 " style="text-align: right">


                                    @if($order->session_order_items)
                                        @if($order->session_order_items->has_session->session_name)
                                       <div>
                                        <span class="badge bg-indigo">{{$order->session_order_items->has_session->session_name}}</span>
                                       </div>
                                           @endif
                                        <span class="badge bg-azure mt-3">
                                            @if($order->session_order_items->has_session->status=='sent_to_iraq')
                                                Received in Iraq
                                            @else
                                                {{ucfirst($order->session_order_items->has_session->status)}}
                                            @endif
                                          </span>
                                    @endif


                                </div>
                                <div class="mx-5  order-details-time">
                                    <div><p>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y ')}} at {{ \Carbon\Carbon::parse($order->created_at)->format('g:i A')}} </p></div>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8" style="padding-right: 0">

                                <div class="card bg-white border-0 mt-3 mb-3 shadow-sm">
                                    <div class="card-body bg-white border-light">
                                        <div class="row">


                                            @foreach($order->line_items as $lineitem)
                                                <div class="col-md-1">
                                                    @if(isset($lineitem->product->featured_image) && $lineitem->product->featured_image!='')
                                                        <img src="{{$lineitem->product->featured_image}}" style="width: 100%">
                                                    @else
                                                        <img src="{{asset('empty.jpg')}}" style="width: 100%">
                                                    @endif
                                                </div>



                                                <div class="col-md-7">
                                                    <strong> {{$lineitem->title}}</strong>
                                                    <br>
                                                    {{$lineitem->variant_title}}
                                                    <br>
                                                    @if($lineitem->sku!=null)
                                                        SKU:{{$lineitem->sku}}
                                                    @endif


                                                </div>
                                                @php
                                                    $lineitem_total=$lineitem->price*$lineitem->quantity;

                                                @endphp


                                                <div class="col-md-2">
                                                   ${{$lineitem->price}} x {{$lineitem->quantity}}

                                                </div>

                                                <div class="col-md-2 text-right">${{$lineitem_total}}</div>
                                                <hr>
                                                <br>
                                            @endforeach


                                        </div>
                                    </div>

                                </div>
                                <div class="card bg-white border-0 mt-3 mb-3 shadow-sm">
                                    <div class="card-body bg-white border-light">
                                        <div class="row">
                                            <div class="col-md-3">Subtotal</div>
                                            <div class="col-md-3">{{$line_items_count}} Items</div>
                                            <div class="col-md-6 text-right">${{$order->total_price}}</div>




                                            <div class="col-md-6 mt-2"><strong>Total</strong></div>
                                            <div class="col-md-6 mt-2 text-right">${{$order->total_price}} </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="card border-light border-0 mt-3  shadow-sm">
                                    <div class="card-header  text-dark">
                                        <h3>Note</h3>
                                    </div>

                                    <div class="card-body bg-white">
                                        @if(isset($order->note))
                                            <p>{{$order->note}}</p>
                                        @else
                                            <p>No Note</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-1">
                                    <div class="card border-light border-0 mt-3  shadow-sm">
                                        <div class="card-header  text-dark">
                                            <h3>SHIPPING ADDRESS</h3>
                                        </div>

                                        <div class="card-body bg-white">
                                            @if(isset($order->shipping_name))
                                                <span>Name : {{$order->shipping_name}}</span>
                                            @else
                                                <span>No Name</span>
                                            @endif
                                            <br>
                                            @if(isset($order->address1))
                                                <span>Address1 : {{$order->address1}}</span>
                                            @else
                                                <span>No Address</span>
                                            @endif
                                            <br>
                                            @if(isset($order->address2))

                                                <span>Address2 : {{$order->address2}}</span>
                                            @else
                                                <span>No Address</span>
                                            @endif
                                            <br>
                                            @if(isset($order->city) && $order->zip)
                                                <span>City & Zip : {{$order->city}} {{$order->zip}}</span>
                                            @else
                                                <span>No Code</span>
                                            @endif
                                            <br>
                                            @if(isset($order->country))
                                                <span>Country : {{$order->country}}</span>
                                            @else
                                                <span>Not Defined</span>
                                            @endif
                                            <br>
                                            @if(isset($order->province))
                                                <span>Province : {{$order->province}}</span>
                                            @else
                                                <span>Not Defined Province</span>
                                            @endif
                                            <br>
                                            @if(isset($order->phone) && $order->phone != '')
                                                <span>Phone : {{$order->phone}}</span>
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

        });
    </script>
@endsection
