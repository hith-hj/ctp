<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Traits\ActionsTrait;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class UserController extends Controller
{
    private $userRepository;

    public $resource = 'user';

    use ActionsTrait;

    public function __construct(UserRepository $userRepository)
    {
        appendGeneralPermissions($this);
        $this->userRepository = $userRepository;
        view()->share('item', $this->resource);
        view()->share('class', User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
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
    public function store(UserRequest $request): RedirectResponse
    {
        $this->userRepository->add($request);

        $request->session()->flash('success', 'user created successfully');

        if ($request->has('add-new')) {
            return redirect()->route('admin.users.create');
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @return Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view('admin.crud.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        return view('admin.crud.edit-new', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->userRepository->update($request, $user);

        $request->session()->flash('success', 'user updated successfully');

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.users.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->userRepository->delete($user);
        $request->session()->flash('success', 'user deleted successfully');

        return redirect()->route('admin.users.index');
    }

    public function usersAutoComplete(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $models = $this->userRepository->usersAutoComplete($search);

        return response()->json([
            'results' => $models,
        ]);
    }

    public function getUsers(Request $request, UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->getUsersDataTable($request);

        $data = [];

        foreach ($users as $user) {
            $imageUrl = $user->avatar ? storageImage($user->avatar) : asset('assets/media/svg/icons/General/User.svg');
            array_push($data, [
                'id' => $user->id,
                'image' => $this->getImageUrl($imageUrl, $user->id),
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'created_at' => Date::parse($user->created_at)->format('Y-m-d'),
                'status' => $user->status,
                'actions' => $this->getItemActions($user, $this->resource),
            ]);
        }

        return response()->json(
            [
                'meta' => [
                    'page' => $users->currentPage(),
                    'pages' => $users->lastPage(),
                    'perpage' => $users->perPage(),
                    'total' => $users->total(),
                    'sort' => $request->get('sort')['sort'] ?? 0,
                    'field' => $request->get('sort')['field'] ?? '',
                ],
                'data' => $data,
            ]
        );
    }

    public function setStatus(Request $request, $id): string
    {
        $className = modelName($request->get('type') ?? 'user');
        $item = $className::find($id);
        $item->status = $request->get('status');
        $item->save();

        return 'Edit Status Successfully';
    }
}
