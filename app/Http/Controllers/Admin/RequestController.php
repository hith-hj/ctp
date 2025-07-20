<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorRequest;
use App\Repositories\RequestRepository;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    private $requestRepository;

    public $resource = 'request';

    public function __construct(RequestRepository $requestRepository)
    {
        appendGeneralPermissions($this);
        $this->requestRepository = $requestRepository;
        view()->share('item', $this->resource);
        view()->share('class', VendorRequest::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|
     * \Illuminate\Contracts\View\Factory|
     * \Illuminate\Contracts\View\View|
     * \Illuminate\Http\Response
     */
    public function index()
    {
        $vendorRequests = $this->requestRepository->getVendorRequest()->paginate(10);

        return view('admin.crud.index', compact('vendorRequests'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = VendorRequest::query()->with('user')->findOrFail($id);

        return view('admin.request.show', compact('request'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $vendorRequest = VendorRequest::query()->with('user')->findOrFail($id);
        $vendorRequest->delete();
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));

        return redirect()->route('admin.requests.index');
    }
}
