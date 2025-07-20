<div class="product product-cart">
    <div class="product-detail">
        <a href="{{route('user.products.show' , $item->product->id)}}" class="product-name">
       {{$item->product->name}}</a>
        <div class="price-box">
            <span class="product-quantity">{{$item->qty}}</span>
            <span class="product-price">{{$item->price." ". getAppCurrency()->symbol}}</span>
        </div>
    </div>
    <figure class="product-media">
        <a href="{{route('user.products.show' , $item->product->id)}}">
            <img src="{{storageImage($item->product->featured_image)}}" alt="product" style="height: 84px; width: 94px" />
        </a>
    </figure>
    <button class="btn btn-link btn-close">
        <i class="fas fa-times"></i>
    </button>
</div>
