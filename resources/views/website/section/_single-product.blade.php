<div class="product product-simple text-center">
    <figure class="product-media">
        <a href="{{route('user.products.show',$product)}}">
            <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"
                 src="{{storageImage($product->featured_image)}}"
                 alt="Product" width="330" height="338"/>
        </a>
        <div class="product-action-vertical">
            <a href="#" data-product="{{$product->id}}"
               class="btn-product-icon {{auth('user')->check()? 'btn-wishlist ':''}}  add-to-wishlist
            {{auth('user')->check()?$product->isLikedBy(auth('user')->user()) ? 'w-icon-heart-full' : 'w-icon-heart':'w-icon-heart'}}"
               title="Add to wishlist"></a>
        </div>
        <div class="product-action">
            <a href="#" class="btn-product btn-quickview text-white" data-product="{{$product->id}}"
               title="Quick View">{{__('front.quick_view')}}</a>
        </div>
    </figure>
    <div class="product-details">
        <h4 class="product-name"><a href="{{route('user.products.show',$product)}}">{{$product->name}}</a>
        </h4>
        <div class="product-pa-wrapper">
            <div class="product-price">
                <ins class="new-price">{{$product->price." ". getAppCurrency()->symbol}}</ins>
            </div>
            <div class="product-action">
                <a href="#" data-product="{{$product->id}}"
                   class="{{auth('user')->check()?'btn-cart' :''}} btn-product btn btn-icon-right add-to-cart  btn-link btn-underline">{{__('front.add_cart')}}</a>
            </div>
        </div>
    </div>
</div>

