<div class="grid-item {{$item->name}} rounded-circle" >
    <article class="post post-mask overlay-zoom br-sm mx-1">
        <!--<figure class="post-media">-->
        <!--    <a href="{{route('user.products.index', ['category'=>$item->id])}}">-->
        <!--        <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"-->
        <!--             src="{{storageImage($item->image)}}"-->
        <!--             style="height:200px; width:200px" alt="blog">-->
        <!--    </a>-->
        <!--</figure>-->
        <div class="post-details">
            <div class="post-details-visible">
                <div class="post-cats">
                    <a href="{{route('user.products.index', ['category'=>$item->id])}}">
                        {{$item->name}}
                    </a>
                </div>
            </div>
        </div>
    </article>
</div>
