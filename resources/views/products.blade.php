@extends('admin.layouts.admin')

@section('content')
    <style>
        tr.hide-table-padding {
            background: #f8fafc;
        }
        tr.hide-table-padding td {
            padding: 0;
        }
        .expand-button {
            position: relative;
            font-size: 30px;
            font-weight: 600;
            cursor:pointer;
        }

        .accordion-toggle.expand-button:after
        {
            position: absolute;
            left:.75rem;
            top: 50%;
            transform: translate(0, -50%);
            content: '-';
        }
        .accordion-toggle.collapsed.expand-button:after
        {
            content: '+';
        }
    </style>
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Products
                    </h2>
                </div>
                <!-- Page title actions -->
               {{-- <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <a href="#" class="btn btn-white">
                      New view
                    </a>
                  </span>
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-create">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Create new
                        </a>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
    <div class="page-body">

        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body border-bottom py-3">
                        <div class="d-flex">
{{--                            <div class="ms-auto text-muted">--}}
                                    <input type="text" class="form-control  filter-search w-100" aria-label="Search"
                                           name="search" placeholder="Search..."
                                           data-route="#" autocomplete="off"
                                    >
{{--                            </div>--}}
                        </div>
                        </div>
                        <div class="table-responsive" style="min-height: 270px;">
                            <table id="Table" class="table table-vcenter table-mobile-md card-table">
                                <thead>
                                <tr>
                                    <th >#</th>
                                    <th>Title</th>
                                    <th>Variants</th>
                                    <th>Total Quantity</th>
                                    <th class="w-1">Action</th>
                                </tr>
                                </thead>
                                <tbody id="TableData">
                                @forelse($products as $index=> $product)
                                    {{--@dd($gallery)--}}
                                    <tr>
                                        <td class="expand-button accordion-toggle collapsed"
                                            id="accordion{{$product->id}}"
                                            data-bs-toggle="collapse"
                                            data-bs-parent="#accordion{{$product->id}}"
                                            href="#collapse{{$product->id}}"
                                            aria-controls="collapse{{$product->id}}"
                                        ></td>
                                        <td class="text-truncate align-middle ">
                                            <div class="checkbox-container">
                                                <label class="checkbox-label">
                                                    <input type="checkbox"  id="15" data-order_id="{{$product->shopify_id}}" class="singleCheck ">
                                                    <span class="checkbox-custom rectangular"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td data-label="Title" class="text-muted tableColumnActions"  >
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="avatar" style="background-image: url({{asset($product->featured_image)}})"></span>
                                                </div>
                                                <div class="col">
                                                    {{$product->title}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{$product->has_variant->count()}}
                                        </td>
                                        <td>
                                            {{$product->has_variant->sum('quantity')}}
                                        </td>
                                        <td>
                                            <a href="{{route('product.view',$product->id)}}" class="btn btn-primary">View</a>
                                        </td>

                                    </tr>
                                    <tr class="hide-table-padding">

                                        <td colspan="6">
                                            <div id="collapse{{$product->id}}" class="collapse in py-2">
                                                <h4>Variants</h4>
                                                <table class="table table-vcenter table-mobile-md card-table">
                                                    <thead>
                                                    <tr>
                                                        <th >Title</th>
                                                        <th >Quantity</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($product->has_variant as $varinat)

                                                        <tr>
                                                            <td>
                                                                {{$varinat->title}}
                                                            </td>
                                                            <td>
                                                                {{$varinat->quantity}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="20">
                                            <div class="justify-content-center">
                                                <div class="empty">
                                                    <div class="empty-img"><img src="{{asset('')}}static/illustrations/undraw_printing_invoices_5r4r.svg" height="128"  alt="">
                                                    </div>
                                                    <p class="empty-title">No results found</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                @endforelse

                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer d-flex align-items-center  justify-content-between" id="pagination_data">
                            @if($products->currentPage()==1)
                                <p class="m-0 text-muted">Showing <span>@if(count($products)) 1 @else 0 @endif</span> to <span>{{count($products->items())}}</span> of <span>{{$products->total()}}</span> entries</p>
                            @elseif($products->currentPage()==$products->lastPage())
                                <p class="m-0 text-muted">Showing <span>{{(($products->currentPage()-1)*$products->perPage())+1}}</span> to <span>{{$products->total()}}</span> of <span>{{$products->total()}}</span> entries</p>
                            @else
                                <p class="m-0 text-muted">Showing <span>{{(($products->currentPage()-1)*$products->perPage())+1}}</span> to <span>{{(($products->currentPage())*$products->perPage())}}</span> of <span>{{$products->total()}}</span> entries</p>

                            @endif

                            {{$products->links()}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
