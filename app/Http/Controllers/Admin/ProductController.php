<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Traits\ActionsTrait;
use App\Models\Product;
use App\Repositories\ProductRepository;
use DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $productRepository;

    public $resource = 'product';

    use ActionsTrait;

    public function __construct(ProductRepository $productRepository)
    {
        appendGeneralPermissions($this);
        $this->productRepository = $productRepository;
        view()->share('item', $this->resource);
        view()->share('class', Product::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.crud.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.crud.edit-new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            $product = $this->productRepository->add($request);
            $invo = (new InventoryController())->addInventoryItem($request, $product->id);
            $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));
            if ($request->has('add-new')) {
                return redirect()->route('admin.products.create');
            }

            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            $request->session()->flash('Error', 'something wrong happend try again later');

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product->ranges = DB::table('product_price_ranges')->where('product_id', $product->id)->get() ?? [];
        $categories = $this->productRepository->getCategories();

        return view('admin.product.show', compact('product', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function edit(Product $product)
    {
        return view('admin.crud.edit-new', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->productRepository->update($request, $product);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));
        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->productRepository->delete($product);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));

        return redirect()->route('admin.products.index');
    }

    public function productsAutoComplete(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $models = $this->productRepository->productsAutoComplete($search);

        return response()->json([
            'results' => $models,
        ]);
    }

    public function removeImage(Request $request): string
    {
        $item = Product::query()->find($request->get('id'));
        $images = [];
        foreach ($item->images as $image) {
            if ($image == $request->get('image')) {
                Storage::disk('public')->delete($image);
            } else {
                $images[] = $image;
            }
        }
        $item->images = $images;
        $item->save();

        return 'image removed successfully';
    }

    public function getProducts(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->getProductsDataTable($request);
        $data = [];
        foreach ($products as $product) {
            $imageUrl = $product->featured_image ? storageImage($product->featured_image) : ($product->images ? storageImage($product->images[0]) : '#');
            array_push($data, [
                'id' => $product->id,
                'image' => $this->getImageUrl($imageUrl, $product->id),
                'name' => $product->name,
                'price' => $product->price,
                'sku' => $product->sku,
                'owner' => $product->owner->name,
                'created_at' => Date::parse($product->created_at)->format('Y-m-d'),
                'status' => $product->status,
                'actions' => $this->getItemActions($product, $this->resource),
            ]);
        }

        return response()->json(
            [
                'meta' => [
                    'page' => $products->currentPage(),
                    'pages' => $products->lastPage(),
                    'perpage' => $products->perPage(),
                    'total' => $products->total(),
                    'sort' => $request->get('sort')['sort'] ?? 0,
                    'field' => $request->get('sort')['field'] ?? '',
                ],
                'data' => $data,
            ]
        );
    }

    public function setStatus(Request $request, $id): string
    {
        $className = modelName($request->get('type') ?? 'product');
        $item = $className::find($id);
        $item->status = $request->get('status');
        $item->save();

        return 'Edit Status Successfully';
    }

    public function productPriceRanges(Request $request, Product $product)
    {
        $range = DB::table('product_price_ranges')->insert([
            'product_id' => $product->id,
            'price' => $request->price,
            'range_start' => $request->range_start,
            'range_end' => $request->range_end,
        ]);
        $request->session()->flash('success', 'Range Added');

        return redirect()->back();
    }

    public function deleteProductPriceRange(Request $request)
    {
        $range = DB::table('product_price_ranges')->where('id', $request->range_id)->delete();
        $request->session()->flash('success', 'Range Deleted');

        return redirect()->back();
    }
}
