@extends('admin.layouts.admin')

@section('content')
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
                        Product
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
            <form action="{{route('product.update',$product->id)}}" method="post">
                @csrf
            <div class="row row-cards">
                <div class="col-lg-12 col-md-12">
                    <div class="">
                        <div class="col-md-12 card card-border-radius py-3">
                            <div class="">
                                <div class="col-md-6 d-flex">
                                    <div class="custom-left-arrow-div " >
                                        <a style="text-decoration: none; padding:19px; font-size: 25px; color: black;" href="{{route('products')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="avatar" style="background-image: url({{asset($product->featured_image)}})"></span>
                                        </div>
                                        <div class="col">
                                            <h2 >{{$product->title}}</h2>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-12" style="padding-right: 0">
                            <div class="card bg-white border-0 mt-3 mb-3 shadow-sm">
                                <div class="card-header  text-dark">
                                    <h3>Variants</h3>
                                </div>
                                <div class="card-body bg-white border-light">
                                    <div class="table-responsive" >
                                        <table id="Table"
                                               class="table table-vcenter table-mobile-md card-table">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Quantity</th>
                                            </tr>
                                            </thead>
                                            <tbody id="TableData">
                                            @foreach($product->has_variant as $varinat)
                                                {{--@dd($gallery)--}}
                                                <tr>
                                                    <td data-label="Title" class="text-muted tableColumnActions"  >
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar" style="background-image: url({{asset($varinat->image)}})"></span>
                                                            </div>
                                                            <div class="col">
                                                                {{$varinat->title}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{$varinat->quantity}}
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </div>

            </div>
            </form>
        </div>
    </div>
@endsection
