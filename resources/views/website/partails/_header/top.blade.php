<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

<div class="container-fluid">
    <div class="row bg-primary py-1 mb-1">
        <div class="col-lg-12 text-center text-lg-center">
            <div class="d-inline-flex align-items-center">
                <a class="text-white px-2" target="_blank" href="{{getSetting('facebook') ?? 'https://www.facebook.com/' }}">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-white px-2" target="_blank" href="{{getSetting('x') ?? 'https://www.x.com/' }}">
                    <i class="fab fa-x-twitter"></i>
                </a>
                <a class="text-white px-2" target="_blank" href="{{getSetting('tiktok') ?? 'https://www.tiktok.com/' }}">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a class="text-white px-2" target="_blank" href="{{getSetting('instagram') ?? 'https://www.instagram.com/' }}">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-white px-2" target="_blank" href="{{ getSetting('whatsapp') ?? 'https://wa.me/'.getSetting('phone')}}">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a class="text-white pl-2" target="_blank" href="{{ getSetting('telegram') ?? 'https://t.me/'.getSetting('phone')}}">
                    <i class="fab fa-telegram"></i>
                </a>

                <div class="ml-3 mr-1 text-white">|</div>

                @if (checkCurrentLang() or app()->getLocale() == 'ar')
                    <a href="{{ route('change-lang', ['lang' => 'en']) }}"
                        class="btn btn-icon btn-sm btn-clean btn-text-white-75">
                        <span class="svg-icon svg-icon-xl text-white">
                            {{-- <i class="fa fa-language"> EN</i>  --}}
                            <i class="fa"> EN</i>
                        </span>
                    </a>
                @else
                    <a href="{{ route('change-lang', ['lang' => 'ar']) }}"
                        class="btn btn-icon btn-sm btn-clean btn-text-white-75">
                        <span class="svg-icon svg-icon-xl text-white">
                            {{-- <i class="fa fa-language"> AR</i>  --}}
                            <i class="fa"> AR</i>
                        </span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

