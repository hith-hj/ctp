    <!-- Modal-->
    <div class="modal fade" id="TreeModal" tabindex="-1" role="dialog" aria-labelledby="TreeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TreeModalLabel"> {{ __('category.View_categories_tree') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $locale = app()->getLocale(); ?>

                    <div id="kt_tree_2" class="tree-demo">
                        @foreach ($categories as $category)
                        <ul>
                            <li
                                data-jstree='{  "icon": "fas fa-boxes text-danger" , "opened" : true ,"selected" : true }'>
                                {{ $category->translate($locale)->{'name'} }}
                                <ul>
                                    @foreach ($category->parentCategory as $subCategory)
                                    <li
                                        data-jstree='{"icon": "fas fa-box-open text-danger", "opened" : true }'>
                                        <a
                                            href="{{ action('App\Http\Controllers\Admin\CategoryController@show', ['category' => $subCategory]) }}">
                                            {{ $subCategory->translate($locale)->{'name'} }}
                                        </a>
                                        <ul>
                                            @foreach ($subCategory->products as $product)
                                            <li
                                                data-jstree='{  "icon": "fa fa-file text-default" }'>
                                                <a
                                                    href="{{ action('App\Http\Controllers\Admin\ProductController@show', ['product' => $product]) }};">
                                                    {{	$product->translate($locale)->{'name'} }}
                                                </a>
                                            </li>
                                            @endforeach

                                        </ul>
                                    </li>
                                    @endforeach
{{--                                    @forelse ($category->products as $product)--}}
{{--                                        <li data-jstree='{  "icon": "fa fa-file text-default" }'>--}}
{{--                                            {{	$product->translate($locale)->{'name'} }}--}}
{{--                                        </li>--}}
{{--                                    @empty--}}
{{--                                        <li></li>--}}
{{--                                    @endforelse--}}
                                </ul>
                            </li>

                        </ul>
                        @endforeach
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">{{ __('category.close') }}</button>
                </div>
            </div>
        </div>
    </div>
