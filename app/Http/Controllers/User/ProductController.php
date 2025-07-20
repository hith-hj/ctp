<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    //here  show all products of admin entry
    public function index(Request $request)
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }
        $products = $this->productRepository->getProducts($request)
            ->active()
            ->sorted()
            ->paginate($limit);
        $productBanner = Banner::query()
            ->orderByDesc('created_at')
            ->first();
        $attributes = Attribute::isFilter()->get()->makeVisible('values');

        return view('website.pages.product.index', compact('products', 'attributes', 'productBanner'));
    }

    public function getProductsByMainCategory($slug)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        return view('website.pages.category.sub-category', compact('category'));
    }

    public function filterShopProducts(Request $request): JsonResponse
    {
        $products = $this->productRepository->getProducts($request);

        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $products = $products->orderByDesc('created_at')->paginate($limit);
        $pagination = view('website.pages.products-pagination', compact('products'))->render();

        $html = '';
        foreach ($products as $product) {
            $html .= '<div class="product-wrap"> '.view('website.section._single-product', compact('product')).'</div>';
        }

        return response()->json(['products' => $html, 'pagination' => $pagination]);
    }

    public function getProductDetails($product): JsonResponse
    {
        $product = Product::query()->findOrFail($product);
        $images = [];
        array_push($images, storageImage($product->featured_image));
        foreach ($product->images as $image) {
            array_push($images, storageImage($image));
        }
        $category = $product->category->name;
        $vendorImage = storageImage($product->owner->avatar);

        $data = [
            'product' => $product,
            'images' => $images,
            'category' => $category,
            'brand' => $vendorImage,
        ];

        return response()->json($data);
    }

    //show 1 product only

    public function show(Product $product)
    {
        $listProduct = Product::query()->active()->inRandomOrder()->take(6)->get();

        return view('website.pages.product.show', compact('product', 'listProduct'));
    }
}
