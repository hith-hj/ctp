{{-- <div class="col-lg-2 col-md-6 grid-itemx {{$item->name}} " >
    <article class="post post-mask overlay-zoom border m-1 p-1">
        <figure class="post-media">
            <a href="{{route('user.product-main-category',$item->slug)}}">
                <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"
                     src="{{storageImage($item->image)}}"
                     style="height:200px;width: 200px" alt="blog">
            </a>
        </figure>
        <div class="post-details">
            <div class="post-details-visible">
                <div class="post-cats">
                    <a href="{{route('user.product-main-category',$item->slug)}}">
                        {{$item->name}}
                    </a>
                </div>
            </div>
        </div>
    </article>
</div> --}}

<div class="col-lg-3 col-md-6 my-1">
    <div class="cat-item d-flex flex-column border p-1">
        <a href="{{ route('user.product-main-category', $item->slug) }}"
            class="cat-imgx position-relative overflow-hidden">
            @if(!is_null($item->image))
               <img class="img-fluid w-100" src="{{ asset($item->image) }}"
                    style="height: 120px" onerror="this.src='{{storageImage($item->image)}}'">
            @endif
            <span class="font-weight-semi-bold m-0">{{ $item->name }}</span>
        </a>
    </div>
</div>
