<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Traits\ActionsTrait;
use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    private $adminRepository;

    public $resource = 'admin';

    use ActionsTrait;

    public function __construct(AdminRepository $adminRepository)
    {
        appendGeneralPermissions($this);
        $this->adminRepository = $adminRepository;
        view()->share('item', $this->resource);
        view()->share('class', Admin::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        return view('admin.crud.index');
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
    public function store(AdminRequest $request): RedirectResponse
    {
        $this->adminRepository->add($request);

        $request->session()->flash('success', 'admin created successfully');

        if ($request->has('add-new')) {
            return redirect()->route('admin.admins.create');
        }

        return redirect()->route('admin.admins.index');
    }

    /**
     * Display the specified resource.
     *
     * @return Factory|\Illuminate\Contracts\View\View
     */
    public function show(Admin $admin)
    {
        return view('admin.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Admin $admin)
    {
        return view('admin.crud.edit-new', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, Admin $admin): RedirectResponse
    {
        $this->adminRepository->update($request, $admin);

        $request->session()->flash('success', 'admin updated successfully');

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.admins.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Admin $admin): RedirectResponse
    {
        $this->adminRepository->delete($admin);
        $request->session()->flash('success', 'admin deleted successfully');

        return redirect()->route('admin.admins.index');
    }

    public function getAdmins(Request $request, AdminRepository $adminRepository): JsonResponse
    {
        $admins = $adminRepository->getAdminsDataTable($request);

        $data = [];

        foreach ($admins as $admin) {
            $imageUrl = $admin->avatar ? storageImage($admin->avatar) : asset('assets/media/svg/icons/General/User.svg');
            array_push($data, [
                'id' => $admin->id,
                'image' => $this->getImageUrl($imageUrl, $admin->id),
                'name' => $admin->name.' ('.($admin->company_name ?? $admin->username).')',
                'email' => $admin->email,
                'role' => $admin->roles()->first() ? $admin->roles()->first()->name : '',
                'created_at' => Date::parse($admin->created_at)->format('Y-m-d'),
                'status' => $admin->status,
                'actions' => $this->getItemActions($admin, $this->resource),
            ]);
        }

        return response()->json(
            [
                'meta' => [
                    'page' => $admins->currentPage(),
                    'pages' => $admins->lastPage(),
                    'perpage' => $admins->perPage(),
                    'total' => $admins->total(),
                    'sort' => $request->get('sort')['sort'] ?? 0,
                    'field' => $request->get('sort')['field'] ?? '',
                ],
                'data' => $data,
            ]
        );
    }

    public function setStatus(Request $request, $id): string
    {
        $className = modelName($request->get('type') ?? 'admin');
        $item = $className::find($id);
        if ($request->type != 'user') {
            $item->update(['status' => $request->get('status')]);

            return 'Edit Status Successfully';
        }
        if ($item->status == 0) {
            $item->update(['status' => 1, 'email_verified_at' => now()]);

            return 'User is Activated';
        } else {
            $item->update(['status' => 0, 'email_verified_at' => null]);

            return 'User is Deactivated';
        }
    }

    public function changePasswordForm()
    {
        return view('admin.admin.changePassword');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with('error', __('admin.passwordInvalid'));
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', __('admin.passwordChanged'));
    }
}
