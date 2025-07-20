<div class="col-lg-3 col-md-6 col-sm-12 pb-1 {{isset($extraClasses) ? $extraClasses : ''}}">
    <div class="card product-item border-0 mb-4">
        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
             @if(!is_null($product->featured_image))
                <img class="img-fluid w-100" style="height:300px!important"
                    src="{{ storageImage($product->featured_image) }}" alt="" >
            @elseif( count($product->images) )
                <img class="img-fluid w-100" style="height:300px!important"
                    src="{{ storageImage( $product->images[0]) }}" alt="" >
            @else
                <img class="img-fluid w-100" style="height:300px!important"
                    src="{{ asset('web/images/no-image.jpg') }}" alt="" >
            @endif
        </div>
        <div class="card-body border-left border-right text-center p-0 py-2">
            <h6 class="text-truncate mb-1">
                {{ $product->name }}
            </h6>
            <div class="d-flex justify-content-center">
                <span>{{__('front.Price')}} : {{$product->price}}</span>
                <span class="text-muted ml-2">
                    <del>{{ $product->price_before_discount }}</del>
                </span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between bg-light border">
            <a href="{{ route('user.products.show', $product) }}" class="btn p-0">
                <i class="fas fa-eye text-primary mr-1"></i>
                {{ __('front.view') }}
            </a>
            @if(isset($addToCart))
	            <a href=""  data-product="{{ $product->id }}"
	                class="btn p-0 {{ auth('user')->check() ? 'btn-cart' : '' }} add-to-cart">
	                <i class="fas fa-shopping-cart text-primary mr-1"></i>
	                {{ __('front.add_cart') }}
	            </a>
            @endif
        </div>
    </div>
</div>
