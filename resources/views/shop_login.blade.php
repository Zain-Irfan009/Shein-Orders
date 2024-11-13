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


</head>
<body class="antialiased border-top-wide border-primary d-flex flex-column">
<div class="page page-center">
    <div class="container-tight py-4">
        <div class="text-center mb-4">
{{--            <a href="/"><img src="{{asset('')}}static/launch.png" height="36" alt=""></a>--}}
            <h1>{{env('APP_NAME')}}</h1>
        </div>
        <form class="card " method="get" action="{{ route('home') }}" autocomplete="off">
            {{--            @csrf--}}
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Enter your shop domain to Login or Install this app.</h2>
                <div class="mb-3">
                    <input id="shop" type="text" class="form-control @error('shop') is-invalid @enderror" name="shop" value="{{ old('shop') }}"
                           placeholder="example.myshopify.com"    required  autofocus>

                    @error('shop')
                    {{ $message }}
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </div>
            </div>

        </form>

    </div>
</div>
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="{{asset('')}}dist/js/tabler.min.js"></script>
</body>
</html>
