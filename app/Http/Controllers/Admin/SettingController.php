<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingController extends Controller
{
    private $settingRepository;

    public $resource = 'setting';

    public function __construct(SettingRepository $settingRepository)
    {
        appendGeneralPermissions($this);
        $this->settingRepository = $settingRepository;
        view()->share('item', $this->resource);
        view()->share('class', Setting::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // $settings = $this->settingRepository->getSettings();
        $admin_settings = $this->getAdminSetting();

        // return view('admin.crud.index', compact('settings'));
        return view('admin.setting.index', compact('admin_settings'));
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
    public function store(SettingRequest $request): RedirectResponse
    {

        $this->settingRepository->add($request);

        $request->session()->flash('success', 'setting created successfully');

        if ($request->has('site-settings')) {
            return back();
        }

        if ($request->has('add-new')) {
            return redirect()->route('admin.settings.create');
        }

        return redirect()->route('admin.settings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting): Setting
    {
        return $setting;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(Setting $setting)
    {
        return view('admin.crud.edit-new', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request, Setting $setting): RedirectResponse
    {
        $this->settingRepository->update($request, $setting);

        $request->session()->flash('success', 'setting updated successfully');

        if ($request->has('site-settings')) {
            return back();
        }

        if ($request->has('add-new')) {
            return redirect()->back();
        }

        return redirect()->route('admin.settings.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Setting $setting): RedirectResponse
    {
        $this->settingRepository->delete($setting);
        $request->session()->flash('success', 'setting deleted successfully');

        return redirect()->route('admin.settings.index');
    }

    //THis is the new setting

    public function addAdminSetting(Request $request)
    {
        $validated = $request->validate([
            'setting_key' => ['required', 'string', 'unique:admin_setting,setting_key'],
            'setting_value' => ['required'],
        ], [
            'setting_key.unique' => 'Setting is already exists',
            'setting_value.url' => 'Value must be valid url',
        ]);

        $store = DB::table('admin_setting')->updateOrInsert([
            'admin_id' => auth()->user()->id,
            'setting_key' => strtolower(str_replace(' ', '_', $validated['setting_key'])),
            'setting_value' => $validated['setting_value'],
        ]);

        return back()->with('message', 'Setting Added succesfuly');
    }

    public function getAdminSetting()
    {
        return DB::table('admin_setting')->get();
    }

    public function EditAdminSetting(Request $request, $id)
    {
        $query = DB::table('admin_setting')->where('id', $id);
        $setting = $query->first();
        // dd($request->all(),$id,$setting);
        if (! $setting || ! array_key_exists($setting->setting_key, $request->all())) {
            return back()->with('error', 'Not found');
        }
        $query->update(['setting_value' => $request->get($setting->setting_key)]);

        return back()->with('success', 'Setting Updated');
    }

    public function deleteAdminSetting($id)
    {
        DB::table('admin_setting')->where('id', $id)->delete();

        return back()->with('message', 'Setting Deleted');
    }
}
