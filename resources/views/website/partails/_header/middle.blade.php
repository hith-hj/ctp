<div class="container-fluid">
	<div class="row align-items-center py-1 " id="sticky_nav">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="{{ route('user.index') }}" class="text-decoration-none">
                <div class="d-flex">
                    <img src="{{asset('icons/icon.png')}}" alt="logo" width="40px" height="40px" />
                    <span style=" font-size: 30px; color: #000;letter-spacing: -2px;margin-left:2px; ">
                        Click To Pick
                    </span>
                </div>
            </a>
        </div>
        <div class="col-lg-6 col-9 text-left">
            <form method="get" action="{{ route('user.products.index') }}" class="mb-0">
                <div class="input-group">
                    <input type="text" class="form-control from-control-sm rounded" name="search" id="search"
                        value="{{ request('search') }}" placeholder="{{__("front.Search")}}...">
                    <div class="input-group-append">
                        <button class="input-group-text bg-white text-primary btn-light" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-3 {{app()->getLocale() == 'ar' ? 'text-left':'text-right'}}">
            <div class="mr-3">
                <a href="{{ route('cart') }}" >
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cartItemsCount" class="badge">
                        {{ getCountCartItems() > 0 ? getCountCartItems() : '' }}
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .sticky{
        position: fixed;
        top: 0%;
        width:100vw;
        background-color: #ffe0ff;
        z-index: 10;
    }
</style>
<!-- Topbar End -->
<script>
    window.onscroll = function() {fixNav()};

    let nav = document.getElementById('sticky_nav')

    let sticky = nav.offsetTop

    function fixNav(){
        if (window.pageYOffset >= sticky) {
            nav.classList.add("sticky")
        } else {
            nav.classList.remove("sticky");
        }
    }
</script>
