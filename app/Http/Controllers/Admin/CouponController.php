<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Repositories\CouponRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CouponController extends Controller
{
    private $couponRepository;

    public $resource = 'coupon';

    public function __construct(CouponRepository $couponRepository)
    {
        appendGeneralPermissions($this);
        $this->couponRepository = $couponRepository;
        view()->share('item', $this->resource);
        view()->share('class', Coupon::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $coupons = $this->couponRepository
            ->getcoupons($request)
            ->paginate(10);

        $categories = $this->couponRepository->getCoupons($request);

        return view('admin.crud.index', compact('coupons', 'categories'));
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
    public function store(CouponRequest $request): RedirectResponse
    {
        $this->couponRepository->add($request);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new')) {
            return redirect()->route('admin.coupons.create');
        }

        return redirect()->route('admin.coupons.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon): View
    {
        return view('admin.crud.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View|Response
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.crud.edit-new', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $this->couponRepository->update($request, $coupon);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $this->couponRepository->delete($coupon);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));

        return redirect()->route('admin.coupons.index');
    }

    public function removeImage(Request $request): string
    {
        $item = Coupon::query()->find($request->get('id'));
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
}
