<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{env('APP_NAME')}} {{empty($page_title) ? "" : "- $page_title" }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/admin.css')}}">

    @yield('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin.elements.topNav')
    @include('admin.elements.sidebar')

    @yield('content')

    @include('admin.elements.footer')
</div>

<script src="{{mix('js/admin.min.js')}}"></script>

<script>
    $.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", "{{csrf_token()}}");
            xhr.setRequestHeader("Content-Type", "application/json; charset=utf-8");
        },
        method: 'POST',
        dataType: "json",
        cache: false,
    });

    var activeLink = '{{empty($presetActiveLink) ? request()->url() : $presetActiveLink}}';
    $('.nav-link-is-value').each(function (i, obj) {
        if ($(this).attr('href') === activeLink) {
            $(this).addClass('active');
            if ($(this).parent().parent().hasClass('nav-treeview')) {
                $(this).parent().parent().parent().addClass('menu-open');
                if ($(this).parent().parent().parent().parent().hasClass('nav-treeview')) {
                    $(this).parent().parent().parent().parent().parent().addClass('menu-open');
                }
            }
        }
    });

    $(document).ready(function () {
        $(".validateForm").submit(function (e) {
            $("input[type='submit']", this).val("Processing...").attr('disabled', 'disabled');
            return true;
        });

        $('[data-toggle="tooltip"]').tooltip();
        $('.dropdown-toggle').dropdown();
        $(".select2").select2({ theme: "bootstrap", dropdownCssClass: "text-sm" });
    });
</script>
@include('admin.elements._js_noty')
@yield('js')
</body>
</html>
