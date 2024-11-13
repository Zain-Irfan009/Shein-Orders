@extends('admin.layouts.admin')

@section('styles')

@endsection
@section('content')




    <div class="page-body">

        <div class="container-xl">

            <form id="sessionForm" action="{{route('save_session')}}" method="POST">
                @csrf
            <div class="row row-deck row-cards">

                <div class="col-md-6">
                    <h2 class="page-title">
                        Create Session
                    </h2>
                </div>
                <div class="col-md-5"></div>
                <div class="col-md-1" >
                    <div class="form-group" style="text-align: right">
                        <button type="submit"  class="btn btn-primary saveButton"  style="display: none;">Save</button>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row">



                        <div class="row">
                            <div class="col-sm-12" style="padding-right: 0">

                                @foreach($orders as $order)

                                    @if(count($order->line_items) > 0)
                                <div class="card bg-white border-0 mt-3 mb-3 shadow-sm">
                                    <div class="card-body bg-white border-light">

                                        <div class="row">
                                            <div class="col-8">
                                                <b>Order Number:</b> {{$order->order_number}}
                                            </div>
                                            <div class="col-4">
{{--                                                <b>Total Price:</b> {{$order->total_price}}--}}
                                            </div>
                                        </div>
                                        <hr>

                                            <div class="row mt-4">
                                                @foreach($order->line_items as $lineitem)
                                                    <div class="col-md-1">
                                                        <!-- Checkbox for selecting line item -->
                                                        <input type="checkbox" name="selected_items[]" value="{{ $lineitem->id }}" class="line-item-checkbox">
                                                    </div>

                                                    <div class="col-md-1">
                                                        @if(isset($lineitem->product->featured_image) && $lineitem->product->featured_image != '')
                                                            <img src="{{ $lineitem->product->featured_image }}" style="width: 100%">
                                                        @else
                                                            <img src="{{ asset('empty.jpg') }}" style="width: 100%">
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <strong>{{ $lineitem->title }}</strong><br>
                                                        {{ $lineitem->variant_title }}<br>
                                                        @if($lineitem->sku != null)
                                                            SKU: {{ $lineitem->sku }}
                                                        @endif
                                                    </div>

                                                    @php
                                                        $lineitem_total = $lineitem->price * $lineitem->quantity;
                                                    @endphp

                                                    <div class="col-md-2">
                                                        ${{ $lineitem->price }} x {{ $lineitem->quantity }}
                                                    </div>

                                                    <div class="col-md-2 text-right"> ${{ $lineitem_total }}</div>
                                                    <hr>
                                                    <br>
                                                @endforeach
                                            </div>



                                    </div>

                                </div>

                                    @endif
                                @endforeach

                            </div>

                        </div>
                    </div>

                </div>
            </div>
            </form>

        </div>


    </div>
@endsection
@section('scripts')

    <script>

        $(document).ready(function() {

            $('.line-item-checkbox').on('change', function() {
                // Show the Save button if any checkbox is checked
                if ($('.line-item-checkbox:checked').length > 0) {
                    $('.saveButton').show();
                } else {
                    $('.saveButton').hide();
                }
            });

            $('#sessionForm').on('submit', function(e) {

                e.preventDefault(); // Prevent the default form submission

                $('body').append('<div class="LockOn"> </div>'); // Append LockOn div to the body

                // Submit the form programmatically
                this.submit();
            });
        });
    </script>
@endsection
