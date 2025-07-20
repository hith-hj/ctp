

<!-- Start of Shop Content -->
<div class="shop-content row gutter-lg mb-10">
    <!-- Start of Sidebar, Shop Sidebar -->
<aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">
    <!-- Start of Sidebar Overlay -->
    <div class="sidebar-overlay"></div>
    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>

    <!-- Start of Sidebar Content -->
    <div class="sidebar-content scrollable">
        <!-- Start of Sticky Sidebar -->
        <div class="sticky-sidebar">
            <div class="filter-actions">
                <label class="filter-line">{{__('front.filter')}} </label>
                <a href="#" class="btn btn-dark btn-link filter-clean">{{__('front.clean_all')}}</a>
            </div>
            <!-- Start of Collapsible widget -->
            <div class="widget widget-collapsible">
                <h3 class="widget-title collapsed"><label>{{__('front.all_category')}}</label></h3>
                <ul class="widget-body filter-items search-ul">
                    @foreach(getMainProductCategories() as $category)
                        <div class="widget widget-collapsible">
                            <h5 class="widget-title text-primary collapsed" style="font-size: 1.1rem;">
                                <label class="sub-category">{{$category->name}}</label>
                            </h5>
                            <ul class="widget-body widget-list filter-items sub_categories item-check mt-1">
                                @if(count($category->parentCategory) > 0)
                                    @foreach($category->parentCategory as $item)
                                        <li><a href="#" data-category="{{$item->id}}" class="sub_category">{{$item->name}}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endforeach
                </ul>
            </div>
            <!-- End of Collapsible Widget -->

            <div class="widget widget-collapsible">
                <h3 class="widget-title collapsed"><span>{{__('front.price')}}</span></h3>
                <div class="widget-body">
                    <form class="price-range">
                        <input type="number" name="min_price" class="min_price text-center"
                               placeholder="{{getAppCurrency()->code. ' ' . __('front.min')}}"><span class="delimiter">-</span>
                        <input type="number" name="max_price" class="max_price text-center"
                               placeholder="{{getAppCurrency()->code. ' ' . __('front.max')}}">
                        <a id="filter_price" class="btn btn-primary btn-rounded">{{__('front.go')}}</a>
                    </form>
                </div>
            </div>
            <!-- Start of Collapsible widget -->

            <!-- End of Collapsible Widget -->

            <!-- Start of Collapsible widget -->

            <!-- End of Collapsible Widget -->
        </div>
        <!-- End of Sidebar Content -->
    </div>
    <!-- End of Sidebar Content -->

</aside>
