<base href="">
<meta charset="utf-8" />
<title>{{ config('app.title') ?? 'Clicl To Pick' }} | Dashboard</title>
<meta name="description" content="Beuaty Products" />
<!--<meta name="Cache-control" content="max-age=2592000"/>-->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<!--begin::Fonts-->
{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> --}}

@if (session()->get('lang') == 'ar' or app()->getLocale() == 'ar')
    <link href="{{ asset('assets/css/rtl/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <!--<link href="{{ asset('assets/css/rtl/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />-->
    <!--<link rel="preload" href="{{ asset('assets/css/rtl/style.bundle.rtl.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">-->
    <!--<noscript><link rel="stylesheet" href="{{ asset('assets/css/rtl/style.bundle.rtl.css') }}"></noscript>-->
@else
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
@endif



    <!--<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
    
    {{-- <link href="{{ asset('assets/css/rtl/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" /> --}}

    {{-- <link href="{{ asset('assets/css/rtl/prismjs.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />  --}}

    {{-- <link href="{{ asset('assets/css/rtl/fullcalendar.bundle.rtl.css') }}" rel="stylesheet" type="text/css" /> --}}

    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/plugins/custom/dropify/dist/css/dropify.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    
    <link href="{{asset('icons/icon.png')}}" rel="icon">
    
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<style>
    @if(app()->getLocale() == 'ar')
    html{
        direction:rtl !important;
    }
    @endif
    .error {
        color: #F64E60 !important;
        font-size: 0.85rem !important;
        font-weight: 400 !important;
    }
</style>