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
                        Packages
                    </h2>
                </div>

{{--                <div class="col-md-6">--}}

{{--                    <div class="form-group">--}}
{{--                        <form action="{{route('orders.filter')}}" method="post">--}}
{{--                            @csrf--}}
{{--                            <div class="input-group">--}}


{{--                                <input placeholder="Enter Order Name,Customer Name" type="text" @if (isset($request)) value="{{$request->orders_filter}}" @endif name="orders_filter" id="question_email" autocomplete="off" class="form-control">--}}
{{--                                @if(isset($request))--}}
{{--                                    <a href="{{route('orders')}}" type="button" class="btn btn-secondary clear_filter_data mx-1 mr-1 pl-4 pr-4">Clear</a>--}}
{{--                                @endif--}}
{{--                                <button type="submit" class="btn btn-primary mx-1 mr-1 pl-4 pr-4">Filter</button>--}}

{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}

            </div>
        </div>
    </div>


    <div class="page-body">

        <div class="container-xl">
            <div class="row row-deck row-cards">

                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            @if (count($packages) > 0)
                                <table
                                        class="table table-vcenter card-table">
                                    <thead>
                                    <tr>

                                        <th>Session ID#</th>
                                        <th>Tracking</th>
                                        <th>Status</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($packages as $package)

                                        <tr>
                                            <td><a href="{{route('view_session',$package->session_id)}}"> {{$package->sessions->session_id}}</a></td>
                                            <td>{{$package->tracking_number}}</td>

                                            <td><span class="badge bg-warning">{{$package->status }}</span></td>


                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h3 class="mx-3 my-3">No Package Found</h3>
                            @endif

                            <div class="pagination">
                                {{ $packages->appends(\Illuminate\Support\Facades\Request::except('page'))->links("pagination::bootstrap-4") }}
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
