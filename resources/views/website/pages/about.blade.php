@extends('website.app')
@section('title')
    {{__('front.about')}}
@endsection

@section('content')
    <div class="container-fluid ">
        <div class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 300px ;
            background-image:url('{{asset('web/img/pink-bg.png')}}');
            background-size:contain;
            background-position-x: center;
        ">
            <h1 class="font-weight-semi-bold text-white text-uppercase mb-3">
                {{ __('front.about_us') }}
            </h1>

        </div>
    </div>
    <div class="container-fluid mb-5">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="w-100 mt-2"><h3>{{ __('front.about_us') }}</h3></div>
            <div class="row" >
                <div class="col-12" style="word-wrap:break-word;">
                    @if(app()->getLocale() == 'ar' && getSetting('ar_about') != null && !empty(getSetting('ar_about')) )
                        {{getSetting('ar_about')}}
                    @else
                        {{getSetting('en_about')}}
                    @endif
                </div>
            </div>
            <div class="w-100 mt-2"><h3>{{ __('front.vision') }} </h3></div>
            <div class="row">
                <div class="col-12" style="word-wrap: break-word">
                    @if(app()->getLocale() == 'ar' && getSetting('ar_vision') != null && !empty(getSetting('ar_vision')))
                        {{ getSetting('ar_vision') }}
                    @else
                        {{ getSetting('en_vision') }}
                    @endif
                </div>
            </div>
            <div class="w-100 mt-2"><h3>{{ __('front.mission') }} </h3></div>
            <div class="row" >
                <div class="col-12" style="word-wrap: break-word ">
                    @if(app()->getLocale() == 'ar' && getSetting('ar_mission') != null && !empty(getSetting('ar_mission')))
                        {{ getSetting('ar_mission') }}
                    @else
                        {{ getSetting('en_mission') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

</html>
