@extends('website.app')
@section('title')
    {{ __('front.products') }}
@endsection
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid ">
        <div class="d-flex flex-column align-items-center justify-content-center" 
        style="min-height: 300px ;
            background-image:url('{{asset('web/img/pink-bg.png')}}');
            background-size:contain;
            background-position-x: center;
        ">
            <h1 class="font-weight-semi-bold text-white text-uppercase mb-3">
                {{ __('front.Our_Shop') }}
            </h1>
            <div class="d-inline-flex text-white">
                <p class="m-0">
                    <a class="text-white" href="/">
                        {{ __('front.home') }}
                    </a>
                </p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">
                    <a class="text-white" href="#">
                        {{ __('front.shop') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row pb-3">
            <div class="col-lg-3 col-md-12 pb-1">
                {{-- header --}}
                <div class="border-bottom mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="text-muted">
                            Search, Filter, Sort
                        </h6>
                        <a href="/products" class="">
                            <button class="btn btn-light btn-sm text-primary rounded">
                                <i class="fa fa-refresh"></i>
                                {{__('front.Reset')}}
                            </button>
                        </a>
                    </div>
                </div>
                {{-- search --}}
                <div class="border-bottom mb-4">
                    <form action="/products" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="search"
                                placeholder="{{ __('front.search_by_name') }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-transparent text-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- price range --}}
                <div class="border-bottom mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="font-weight-semi-bold ">Price range</h6>
                        <button type="submit" class="text-primary btn btn-light btn-sm rounded"
                            form="#productPriceRange">
                            <i class="fa fa-search"></i>
                            {{__('front.Search')}}
                        </button>
                    </div>
                    <form method="get" action="/products" id="productPriceRange">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent text-primary">
                                    <i class="fa fa-dollar-sign"></i>
                                </span>
                            </div>
                            <input type="number" min="1" class="form-control form-control-sm"
                            name="min_price"
                            placeholder="{{ __('front.From') }}" value="{{old('min_price')}}">
                        </div>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent text-primary">
                                    <i class="fa fa-dollar-sign"></i>
                                </span>
                            </div>
                            <input type="number" min="1" class="form-control form-control-sm"
                            name="max_price"
                                placeholder="{{ __('front.To') }}" value="{{old('max_price')}}">
                        </div>
                    </form>
                </div>
                {{-- sorter --}}
                <div class="border-bottom mb-4">
                    <h6 class="font-weight-semi-bold ">Sort By :</h6>
                    <div class="">
                        <a class="dropdown-item p-0" href="?sort_by[price]=asc">
                            {{__('front.Price')}}: {{__('front.Lth')}}
                        </a>
                        <a class="dropdown-item p-0" href="?sort_by[price]=desc">
                            {{__('front.Price')}}: {{__('front.Htl')}}
                        </a>
                        <a class="dropdown-item p-0" href="?sort_by[created_at]=asc">
                            {{__('front.Date')}}: {{__('front.Otn')}}
                        </a>
                        <a class="dropdown-item p-0" href="?sort_by[created_at]=desc">
                            {{__('front.Date')}}: {{__('front.Nto')}}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <div class="row">
                    @forelse ($products as $product)
                        @include('website.section.product._product',[
                            'product'=>$product,
                            'extraClasses' => 'col-lg-4',
                            'addToCart'=>true
                        ])
                    @empty
                        <div class="card-header border p-0 w-100">
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">No products Yet</h6>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        {{$products->links()}}
    </div>
@endsection

