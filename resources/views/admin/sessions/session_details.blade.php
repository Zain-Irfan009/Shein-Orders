@extends('admin.layouts.admin')

@section('styles')

    <style>

        #ordersTable_length{
            margin-bottom:12px;
        }

        .dataTables_wrapper{
            margin-top:10px;
        }
        .info-box {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px 16px;
            margin-right: 12px;
            display: inline-block;
        }

        .info-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            margin: 0;
        }

        .order-header {
            display: flex;
            align-items: center;
        }

        .card-header-tabs{
            background: #bcd8f5;
        }

        .table-responsive{
            margin-top:10px;
            background: white;
        }

    </style>



@endsection
@section('content')




    <div class="page-body">

        <div class="container-xl">
            <div class="row row-deck row-cards">

                        <div class="col-md-12 card card-border-radius pt-3 pb-1">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="d-flex">
                                        <div class="custom-left-arrow-div">
                                            <a style="text-decoration: none; padding:19px; font-size: 25px; color: black;" href="{{route('sessions')}}">
                                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <h2 style="margin-top: 3px;">{{$session->session_id}}</h2>
                                        </div>
                                    </div>
                                    <div class="mx-5 order-details-time">
                                        <div>
                                            <p><span class="badge bg-danger">{{$session->status}}</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="order-header">
                                        <div class="info-box">
                                            <div class="info-label">Items</div>
                                            <p class="info-value">{{$session->no_of_items}} Items</p>
                                        </div>
                                        <div class="info-box">
                                            <div class="info-label">Date</div>
                                            <p class="info-value">{{ \Carbon\Carbon::parse($session->created_at)->format('F d, Y ')}}</p>
                                        </div>
                                        <div class="info-box">
                                            <div class="info-label">Price</div>
                                            <p class="info-value">${{$session->total_price}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>


            <form method="post" action="{{route('session.detail.update',$session->id)}}">
                @csrf
            <div class="row mt-2" style="text-align: right">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="row row-deck row-cards mt-3 mb-3">

                <div class="col-md-12 card card-border-radius pt-3 pb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <b>Session Order No</b>
                            <input type="text" value="{{$session->session_order_no}}" name="session_order_no" class="form-control mt-1">
                        </div>

                        <div class="col-md-6">
                            <b>Shein Account</b>
                            <input type="text" required value="{{$session->shein_account}}" name="shein_account" class="form-control mt-1">
                        </div>

                    </div>
                </div>
            </div>
            </form>
            <div class="row row-deck row-cards mt-3 mb-3">

                <div class="col-md-12 card card-border-radius pt-3 pb-3">
                    <div class="card">

                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                                <li class="nav-item">
                                    <a href="#tabs-home-5" class="nav-link active" data-bs-toggle="tab">Orders ({{count($orders)}})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tabs-profile-5" class="nav-link" data-bs-toggle="tab">Packages ({{count($packages)}})</a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body" style="background: #F1F5F9">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-home-5">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            @foreach($orders as $order)

                                                @if(count($order->line_items) > 0)
                                                    <div class="card bg-white border-0 mt-3 mb-3 shadow-sm">
                                                        <div class="card-body bg-white border-light">

                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>Order Number:</b> {{$order->order_number}}
                                                                </div>
                                                                <div class="col-4">
{{--                                                                    <b>Total Price:</b> {{$order->total_price}}--}}
                                                                </div>
                                                            </div>
                                                            <hr>

                                                            <div class="row mt-4">
                                                                @foreach($order->line_items as $lineitem)


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

                                                                    <div class="col-md-2 text-right">${{ $lineitem_total }}</div>
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
                                <div class="tab-pane" id="tabs-profile-5">

                                    <div class="row">
                                        <div class="col-12" style="text-align:end">
                                            <a type="button" href="#" data-bs-toggle="modal" data-bs-target="#modal-report" class="btn btn-primary">Create</a>

                                        </div>

                                        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" data-focus="false"   role="dialog" aria-hidden="true">
                                            <form method="post" action="{{route('save_package')}}">
                                                @csrf
                                                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Create Package</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">

                                                            <input type="hidden" value="{{$session->id}}" name="session_id">
                                                            <div class="row">

                                                                <div class="col-lg-12">


                                                                        <b class="form-check-label">
                                                                           Tracking Number
                                                                        </b>
                                                                        <input type="text" class="form-control mt-2" value="" name="tracking_number">

                                                                    <b class="form-check-label mt-2">
                                                                        ZMC Airway bill
                                                                    </b>
                                                                    <input type="text" class="form-control mt-2" value="" name="zmc_airway_bill">
                                                                    <b class="form-check-label mt-2">
                                                                        Status
                                                                    </b>
                                                                    <select class="form-control mt-2" name="status">
                                                                        <option value="With Shein">With Shein</option>
                                                                        <option value="Received in Dubai">Received in Dubai</option>
                                                                        <option value="Send to Iraq">Send to Iraq</option>
                                                                    </select>

                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                                                Cancel
                                                            </a>
                                                            <button  type="submit" class="btn btn-primary ms-auto" >
                                                                Create
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>



                                    <div class="table-responsive">
                                        @if (count($packages) > 0)
                                            <table id="ordersTable"
                                                    class="table table-vcenter card-table">
                                                <thead>
                                                <tr>

                                                    <th>Package Id</th>
                                                    <th>Tracking Number</th>
                                                    <th>ZMC Airway bill</th>
                                                    <th>Status</th>
                                                    <th>Action</th>

                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($packages as $index=> $package)
                                                    <tr>
                                                        <td>#{{++$index}}</td>
                                                        <td>{{$package->tracking_number}}</td>
                                                        <td>{{$package->zmc_airway_bill}}</td>
                                                        <td><span class="badge bg-warning">{{$package->status}}</span></td>
                                                        <td>
                                                            <a data-bs-toggle="modal" data-bs-target="#specific-package{{$package->id}}" class="text-warning" title="Edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                            </a>

                                                            <a  data-id="{{$package->id}}" class="text-danger delete_single_btn" title="Delete" >
                                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <div class="modal modal-blur fade" id="specific-package{{$package->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <form method="post" action="{{route('update_package',$package->id)}}">
                                                            @csrf
                                                            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Update Package</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body">

                                                                        <input type="hidden" value="{{$session->id}}" name="session_id">
                                                                        <div class="row">

                                                                            <div class="col-lg-12">


                                                                                <b class="form-check-label">
                                                                                    Tracking Number
                                                                                </b>
                                                                                <input type="text" class="form-control mt-2" value="{{$package->tracking_number}}" name="tracking_number">

                                                                                <b class="form-check-label mt-2">
                                                                                    ZMC Airway bill
                                                                                </b>
                                                                                <input type="text" class="form-control mt-2" value="{{$package->zmc_airway_bill}}" name="zmc_airway_bill">
                                                                                <b class="form-check-label mt-2">
                                                                                    Status
                                                                                </b>
                                                                                <select class="form-control mt-2" name="status">
                                                                                    <option @if($package->status=='With Shein') selected @endif value="With Shein">With Shein</option>
                                                                                    <option @if($package->status=='Received in Dubai') selected @endif value="Received in Dubai">Received in Dubai</option>
                                                                                    <option @if($package->status=='Send to Iraq') selected @endif value="Send to Iraq">Send to Iraq</option>
                                                                                </select>

                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                                                            Cancel
                                                                        </a>
                                                                        <button  type="submit" class="btn btn-primary ms-auto" >
                                                                            Update
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <h3 class="mx-3 my-3">No Packages Found</h3>
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
                        window.location.href = "{{ route('delete_package', '') }}/" + orderId;
                    }
                });

            });
        });
    </script>
@endsection
