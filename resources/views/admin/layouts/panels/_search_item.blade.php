<div class="d-flex align-items-center flex-grow-1 mb-2">
    <div class="symbol symbol-30 bg-transparent flex-shrink-0">
        <img onerror="this.src='{{asset('web/images/no-image.jpg')}}';"  src="{{ $item->image ? storageImage($item->image) : asset('custom/logo-icon.png')}}" alt=""/>
    </div>
    <div class="d-flex flex-column ml-3 mt-2 mb-2">
        <a href="{{ $item->url }}" class="font-weight-bold text-dark text-hover-primary">
            {{ $item->name }}
        </a>
        <span class="font-size-sm font-weight-bold text-muted">
            {{ $item->class }}
        </span>
    </div>
</div>
