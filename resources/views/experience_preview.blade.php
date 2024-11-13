<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{env('APP_NAME')}}</title>
    <!-- CSS files -->
    <link href="{{asset('')}}dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/demo.min.css" rel="stylesheet"/>
    <link rel="shortcut icon" type="image/png" href="{{asset('')}}static/logo-small.svg"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


</head>
<body class="d-flex flex-column ">
<div class="row g-0 flex-fill">
    {{--<div class="col-12 col-lg-6 col-xl-4 d-none d-lg-block">
        <!-- Photo -->
        <div class="bg-cover h-100 min-vh-100" style="background-image: url({{$booking->image}})">
--}}{{--            <img src="{{$booking->image}}" width="100%" class="d-block mx-auto" alt="">--}}{{--

        </div>
    </div>--}}
    <div class="col-12 col-lg-12 col-xl-12  ">
        <div class="container container-tight my-3 ">
            <div class="card mb-1">
                <div class="card_body m-2">
                    <div class="row align-content-center">
                        <div class="col-auto">
                            <a href="https://{{$booking->shop->name}}/products/{{$booking->product->handle}}" target="_blank">
                            <span class="avatar avatar-xl" style="background-image: url({{$booking->image}})"></span>
                            </a>
                        </div>
                        <div class="col">
                            <h1 class="h1 text-center mb-3">
                                {{$booking->title}}
                            </h1>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-1">
                <div class="card_body m-2">
                    <div class="row align-content-center">
                        <div class="col-auto">
                            Date
                        </div>
                        <div class="col text-end">
                            {{$booking->start}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-1">
                <div class="card_body m-2">
                    <div class="row align-content-center">
                        <div class="col-auto">
                            Time Slot
                        </div>
                        <div class="col text-end">
                            {{$booking->time_slot}}
                        </div>
                    </div>
                </div>
            </div>
            @if($booking->details)
                @foreach(json_decode($booking->details) as $details)
                    @if($details->name !="_date" && $details->name !="_timeslot")
                        @php
                            $title=\Illuminate\Support\Str::title($details->name);
                            $title=str_replace("_","",$title);
                            if($title=="Newprice"){
                                $title="Price";
                            }
                        @endphp
                        <div class="card mb-1">
                            <div class="card_body m-2">
                                <div class="row align-content-center">
                                    <div class="col-auto">
                                        {{$title}}
                                    </div>
                                    <div class="col text-end">
                                        {{$details->value}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                @endforeach
            @endif

            {{--<div class="table-responsive">
                <table class="table card-table table-vcenter">
                    <tbody>
                    <tr>
                        <td class="w-100">
                            Date
                        </td>
                        <td class="text-nowrap text-secondary">
                            {{$booking->start}}
                        </td>
                    </tr>
                    <tr>
                        <td class="w-100">
                            Time Slot
                        </td>
                        <td class="text-nowrap text-secondary">
                            {{$booking->time_slot}}
                        </td>
                    </tr>

                    @if($booking->details)
                    @foreach(json_decode($booking->details) as $details)
                        @if($details->name !="_date" && $details->name !="_timeslot" && $details->name !="_newPrice" )
                            @php
                                $title=\Illuminate\Support\Str::title($details->name);
                                $title=str_replace("_","",$title);
                                if($title=="Newprice"){
                                    $title="Price";
                                }
                            @endphp
                        <tr>
                            <td class="w-100">
                                {{$title}}
                            </td>
                            <td class="text-nowrap text-secondary">
                                {{$details->value}}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    @endif
                    </tbody>
                </table>

            </div>--}}

            <div class="card mb-1">
                <div class="card_body m-2">
                    <h2>Terms & Conditions</h2>
                    <div class="">
                        {!! $setting->term_text !!}
                    </div>
                    @if($booking->status=="scheduled")
                    @if(!$booking->invoice_link)
                        <a href="{{route('experience.confirm',$booking->preview_link)}}">
                            <button type="button" class="btn btn-primary w-100">Confirm Booking</button>
                        </a>
                        @else
                            <a href="{{$booking->invoice_link}}">
                                <button type="button" class="btn btn-primary w-100">Confirm Booking</button>
                            </a>
                    @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="{{asset('')}}dist/js/tabler.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    @if(Session::has('success'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false,
            "positionClass": "toast-bottom-center",

        }
    toastr.success("{{ session('success') }}");
    @endif

        @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false,
            "positionClass": "toast-bottom-center",
        }
    toastr.error("{{ session('error') }}");
    @endif

        @if(Session::has('info'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false,
            "positionClass": "toast-bottom-center",
        }
    toastr.info("{{ session('info') }}");
    @endif

        @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false,
            "positionClass": "toast-bottom-center",
        }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>
</body>
</html>
