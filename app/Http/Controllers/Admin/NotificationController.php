<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PHPUnit\Exception;

class NotificationController extends Controller
{
    private $notificationRepository;

    public $resource = 'notification';

    public function __construct(NotificationRepository $notificationRepository)
    {
        appendGeneralPermissions($this);
        $this->notificationRepository = $notificationRepository;
        view()->share('item', $this->resource);
        view()->share('class', Notification::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $notifications = $this->notificationRepository
            ->getNotifications($request)
            ->paginate(10);

        return view('admin.crud.index', compact('notifications'));
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
    public function store(NotificationRequest $request): RedirectResponse
    {
        try {
            $this->notificationRepository->add($request);
        } catch (Exception $e) {
            $request->session()->flash('error', __('notification.please_check_notification_credentials'));

            return redirect()->route('admin.notifications.index');
        }

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new')) {
            return redirect()->route('admin.notifications.create');
        }

        return redirect()->route('admin.notifications.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\View|View
     */
    public function show(Notification $notification)
    {
        return view('admin.crud.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Notification $notification)
    {
        return view('admin.crud.edit-new', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationRequest $request, Notification $notification): RedirectResponse
    {
        $this->notificationRepository->update($request, $notification);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.notifications.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Notification $notification): RedirectResponse
    {
        $this->notificationRepository->delete($notification);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));

        return redirect()->route('admin.notifications.index');
    }
}
