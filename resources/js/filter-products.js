$(document).ready(function () {

    let subcategories = [];
    let specifications = [];
    let minPrice;
    let maxPrice;
    let page = 1;
    let limit = 10;
    let sort = 'desc';
    let search = '';
console.log("1");
    $(window).on('load', function () {

        let urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get('search') !== null && urlParams.get('search') !== "") {
            search = urlParams.get('search');
        }

        if (urlParams.get('subcategories') !== null) {
            subcategories = urlParams.get('subcategories').trim().split(",");
        }

        if (urlParams.get('category') !== null) {
            let category = urlParams.get('category');
            subcategories.push(category);
        }
        getFilterProducts(minPrice, maxPrice, subcategories, specifications);
    });

    function getSubCategoriesSpecifications(subcategories) {
        let url = $('#categories_specifications_url').data('url');
        console.log(url)
        let specifications = $('#category_specifications');
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                subcategories: subcategories
            },
            success: function (data) {
                specifications.show();
                specifications.html(data);
            }
        });
    }

    function getFilterProducts(
        filterMinPrice = minPrice,
        filterMaxPrice = maxPrice,
        filterSubCategories = subcategories,
        filterSpecifications = specifications,
    ) {
        let urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('search') !== null) {
            search = urlParams.get('search');
        } else {
            search = '';
        }
        console.log("check 22");
        $.ajax({
            url: "/filter_products?page=" + page + "&limit=" + limit + "&sort=" + sort + "",
            type: 'GET',
            data: {
                min_price: filterMinPrice,
                max_price: filterMaxPrice,
                categories: subcategories,
                specifications: filterSpecifications,
                search: search
            },
            success: function (data) {

                let count = itemCount(data.products);
                let productsWrapper = $('#product-wrapper');
                productsWrapper.show();
                productsWrapper.html(data.products);
                $('#products-pagination').html(data.pagination);
            }
        });
    }

    $("#limit").on('change', function (e) {
        e.preventDefault();
        limit = $(this).val();
        getFilterProducts(minPrice, maxPrice, subcategories, specifications);
    });

    $(document).on('click', ".pagination a", function (e) {
        e.preventDefault();
        page = $(this).attr('href').split('page=')[1];

        getFilterProducts(price, subcategories, specifications);

        let body = $("html, body");
        body.stop().animate({
            scrollTop: 0
        }, 700, 'swing');
    });

    function itemCount(data) {
        let html = $.parseHTML(data);
        let itemCount = $(html).data("itemcount");
        $('.products__view__count').text(itemCount + " items")
        return itemCount
    }

    $(".sub_categories").on('click', '.sub_category', function (e) {
        e.preventDefault();
        let sub_category_id = $(this).data('category');
        if (!subcategories.includes(sub_category_id)) {
            subcategories.push(sub_category_id);
        } else {
            subcategories.splice($.inArray(sub_category_id, subcategories), 1);
        }

        if (subcategories.length > 0) {
            console.log("2");

            getSubCategoriesSpecifications(subcategories)
            getFilterProducts(minPrice, maxPrice, subcategories, specifications)
        } else {
            getFilterProducts(minPrice, maxPrice, subcategories, specifications)
        }

    });
    console.log("3");

    $(".attributes").on('change', '.attribute', function (e) {
        e.preventDefault();
        let attribute_id = $(this).data('value');
        if ($(this).is(':checked')) {
            console.log(attribute_id)
        }

    });

    console.log("4");

    $('#filter_price').on('click', function (e) {
        e.preventDefault();

        minPrice = $('input[name="min_price"]').val();
        maxPrice = $('input[name="max_price"]').val();
        getFilterProducts(minPrice, maxPrice, subcategories, specifications);

    });
});
