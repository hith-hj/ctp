@extends('website.app')
@section('title')
    {{$category->name}}
@endsection
@section('content')
    <!-- Start of Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0">{{$category->name}}</h1>
        </div>
    </div>
    <!-- End of Page Header -->

    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav mb-6">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('user.index')}}">{{__('front.home')}}</a></li>
                <li> - </li>
                <li>{{$category->name}}</li>
            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->
    <!-- Start of Page Content -->
    <div class="page-content">
        @if(count($category->subcategories)>0)
            <div class="container">
                <div class="rowx grid cols-lg-3 cols-md-2 mb-2" data-grid-options="{
                        'layoutMode': 'fitRows'
                    }">
                    @foreach($category->subcategories as $item)
                        @include('website.section._single-category')
                    @endforeach
                </div>
            </div>
        @else
            <div class="row grid cols-lg-3 cols-md-2 m-0 mb-2" data-grid-options="{
                        'layoutMode': 'fitRows'
                    }">
                <div class="w-50 text-center" style="margin: 21px auto; ">
                    <!--<img src="{{asset('web/images/icons/Search engines-bro.png')}}" 
                    onerror="this.src='{{asset('web/images/no-image.jpg')}}';">-->
                    <p class="text-muted">{{__('front.no_category')}}</p>
                </div>
            </div>
            @endif

    </div>
    <!-- End of Page Content -->
@endsection
