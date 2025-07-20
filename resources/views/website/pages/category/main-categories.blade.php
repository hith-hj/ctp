@extends('website.app')
@section('title')
    {{__('front.category')}}
@endsection

@section('content')
<div class="container-fluid ">
    <div class="d-flex flex-column align-items-center justify-content-center"
    style="min-height: 300px ;
        background-image:url('{{asset('web/images/makeup.jpg')}}');
        background-size:cover;
        background-position-x: center;
    ">
        <h1 class="font-weight-semi-bold text-white text-uppercase mb-3">
            {{ __('front.categories') }}
        </h1>

    </div>
</div>
<div class="container-fluid mb-5 mt-2">
    <div class="row border-top">
        <div class="col-12">
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="page-content">
                    @if(count(getMainProductCategories())>0)
                        <div class="">
                            {{-- <div class="rowx grid cols-lg-4 cols-md-2 m-0 p-0 mb-10"
                                data-grid-options="{'layoutMode': 'fitRows'}"> --}}
                            <div class="row">
                                @foreach(getMainProductCategories() as $item)
                                    @include('website.section._single-sub-category',['item'=>$item ])
                                @endforeach
                            </div>
                            {{getMainProductCategories()->links('website.pages.pagination')}}
                        </div>
                    @else
                        <div class="row grid cols-lg-3 cols-md-2 mb-2" data-grid-options="{
                        'layoutMode': 'fitRows'
                    }">
                            <div class="w-50 text-center" style="margin: 108px auto; ">
                                <img onerror="this.src='{{asset('assets/images/icons/Search engines-bro.png')}}';"
                                src="{{asset('assets/images/no-product.png')}}" >
                                <p style="margin-top: 21px;font-weight: bold;" class="text-dark">
                                    {{__('front.no_category')}}</p>
                                <a href="{{route('user.index')}}"
                                   class="btn btn-primary btn-rounded btn-icon-right slide-animate"
                                   data-animation-options="{
                                    'name': 'fadeInUpShorter', 'duration': '1s'
                                }">
                                    @if (checkCurrentLang())
                                        <i class="w-icon-long-arrow-left"></i>
                                        {{__('front.home')}}
                                    @else
                                        {{__('front.home')}}
                                        <i class="w-icon-long-arrow-right"></i>
                                    @endif
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
