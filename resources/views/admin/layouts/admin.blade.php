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
    <link rel="stylesheet" href="https://richtexteditor.com/richtexteditor/rte_theme_default.css" />
    <link rel="shortcut icon" type="image/png" href="{{asset('')}}static/logo-small.svg"/>
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        /*.navbar-dark .navbar-nav .active>.nav-link,
        .navbar-dark .navbar-nav .active>.nav-link .nav-link-icon,
        .navbar-dark .navbar-nav .nav-link.active,
        .navbar-dark .navbar-nav .nav-link.show,
        .navbar-dark .navbar-nav .show>.nav-link {
            color: #fff;
            fill: #fff;
        }*/


        .LockOn {
            display: block;
            visibility: visible;
            position: absolute;
            z-index: 999;
            top: 0px;
            left: 0px;
            width: 105%;
            height: 105%;
            background-color:white;
            vertical-align:bottom;
            padding-top: 20%;
            filter: alpha(opacity=75);
            opacity: 0.75;
            font-size:large;
            color:blue;
            font-style:italic;
            font-weight:400;
            background-image: url("{{asset('public/loading.gif')}}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css">
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css">

    @yield('styles')

</head>
<body class="antialiased">
<div class="wrapper">
    @include('admin.layouts.sidenav')
    @include('admin.layouts.header')

    <div class="page-wrapper">


        @yield('content')

        @include('admin.layouts.footer')
    </div>
</div>
<!-- Libs JS -->
<script src="{{asset('')}}dist/libs/apexcharts/dist/apexcharts.min.js"></script>
{{--<script src="{{asset('')}}dist/libs/nouislider/distribute/nouislider.min.js"></script>--}}
<script src="{{asset('')}}dist/libs/litepicker/dist/litepicker.js"></script>
{{--<script src="{{asset('')}}dist/libs/choices.js/public/assets/scripts/choices.js"></script>--}}
<!-- Tabler Core -->
<script src="{{asset('')}}dist/js/tabler.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>



<script type="text/javascript" src="https://richtexteditor.com/richtexteditor/rte.js"></script>
<script type="text/javascript" src='https://richtexteditor.com/richtexteditor/plugins/all_plugins.js'></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    @if(Session::has('success'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false,
            "positionClass": "toast-top-right",

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
            "positionClass": "toast-top-right",
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


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
{{--<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/super-build/ckeditor.js"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.0/jscolor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js"></script>





<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('scripts')

<script>

    $(document).ready(function () {
        $('.summernote').summernote();
        $('.logout-App').on('click', function (event) {
            event.preventDefault();
            $('#logoutForm').submit();
        });
        $('body').on('keyup','.filter-search',function () {
            var search=$(this).val();
            $.ajax({
                url: $(this).data('route'),
                method: 'GET',
                data:{
                    search : $(this).val(),
                },
                success:function (response){
                    // console.log(response);
                    $('#Table').find('#TableData').empty();
                    $('#Table').find('#TableData').append($(response).find('#TableData').html());
                    $('#pagination_data').empty();
                    $('#pagination_data').append($(response).find('#pagination_data').html());
                }
            });
        });
        $('body').on('click','#checkAll',function() {
            // $('input:checkbox').not(this).prop('checked', this.checked);
            if (this.checked) {
                // alert('checked')
                $(".singleCheck").each(function() {
                    this.checked=true;
                });
                $('.actionbox').show();
                $('.space').hide();

            } else {
                // alert('not checked')
                $(".singleCheck").each(function() {
                    this.checked=false;
                    $('.actionbox').hide();
                    $('.space').show();

                });
            }
            selectedOrders();
        });
        $('body').on('click','.singleCheck',function () {
            // alert('clicked');
            //     console.log($('.singleCheck:checked').length)
            selectedOrders();

            if($('.singleCheck:checked').length > 0){
                $('.actionbox').show();
                $('.space').hide();

            }
            else{
                $('.actionbox').hide();
                $('.space').show();

            }
            if ($(this).is(":checked")) {
                var isAllChecked = 0;

                $(".singleCheck").each(function() {
                    if (!this.checked)
                        isAllChecked = 1;
                });

                if (isAllChecked === 0) {
                    $("#checkAll").prop("checked", true);
                }
            }
            else {
                $("#checkAll").prop("checked", false);
            }
        });
        function selectedOrders(){
            var orders_array =[];
            $(".singleCheck").each(function() {
                if (this.checked)
                {
                    // console.log($(this).data('order_id'));

                    orders_array.push($(this).data('order_id'));
                }

            });
            if($('#checkAll:checked').length > 0){
                $('#orders_array').val(['all']);
            }else{
                $('#orders_array').val(orders_array);
            }

            // console.log($('#orders_array').val());
        }
    });
</script>
</body>
</html>
