<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    private $currencyRepository;

    public $resource = 'currency';

    public function __construct(CurrencyRepository $currencyRepository)
    {
        appendGeneralPermissions($this);
        $this->currencyRepository = $currencyRepository;
        view()->share('item', $this->resource);
        view()->share('class', Currency::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $currencies = $this->currencyRepository->getCurrencies($request, true);
        if ($request->has('request_rates')) {
            $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));
        }

        unset($request['request_rates']);

        return view('admin.crud.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.crud.edit-new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request): RedirectResponse
    {
        try {
            $this->currencyRepository->add($request);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new')) {
            return redirect()->route('admin.currencies.create');
        }

        return redirect()->route('admin.currencies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency): \Illuminate\Contracts\View\View
    {
        return view('admin.crud.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Currency $currency)
    {
        return view('admin.crud.edit-new', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, Currency $currency): RedirectResponse
    {
        try {
            $this->currencyRepository->update($request, $currency);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        $request->session()->put('appcurrency', getMainCurrency()->code);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.currencies.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Currency $currency): RedirectResponse
    {
        if ($currency->is_default == true) {
            return back()->with('error', 'Main currency can\'t be deleted');
        }
        $this->currencyRepository->delete($currency);
        $request->session()->put('appcurrency', getMainCurrency()->code ?? 'USD');
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));

        return redirect()->route('admin.currencies.index');

    }
}
