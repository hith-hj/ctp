<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\ShippingDetails;
use App\Models\User;
use App\Repositories\RequestRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepository;

    private $vendorRequestRepository;

    public function __construct(UserRepository $userRepository, RequestRepository $vendorRequestRepository)
    {
        $this->userRepository = $userRepository;
        $this->vendorRequestRepository = $vendorRequestRepository;
    }

    public function index()
    {
        $user = User::query()->with('orders')->where('id', auth('user')->id())->first();

        return view('website.pages.user.index', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        if ($request->has('old_password') and $request->get('old_password') != null) {
            if (! Hash::check($request->get('old_password'), $user->password)) {
                $request->session()->flash('error', __('front.wrong_password'));

                return redirect()->back();
            } else {
                if ($request->has('password') and $request->get('password') != null) {
                    $user->update(['password' => ($request->get('password'))]);
                    $this->userRepository->updateAccount($request, $user);
                    $request->session()->flash('success', __('front.update_account'));
                    $user->save();
                }
            }
        } else {
            $this->userRepository->updateAccount($request, $user);
            $request->session()->flash('success', __('front.update_account'));
            $user->save();

            return redirect()->back();
        }
    }

    public function becomeVendor()
    {
        return view('website.pages.user.become_vendor');
    }

    public function shippingAddress(Request $request)
    {
        $shippingInfo = ShippingDetails::query()->whereId($request->get('shippingInfo'))->first();
        if (isset($shippingInfo)) {
            $shippingInfo->update($request->all());
            $request->session()->flash('success', __('front.update_ifo'));
        } else {
            ShippingDetails::create($request->all());
            $request->session()->flash('success', __('front.created_info'));
        }

        return redirect()->route('user.user-account');
    }

    public function storeUserDetail(Request $request): RedirectResponse
    {
        $this->vendorRequestRepository->storeVendorDetails($request);
        $request->session()->flash('success', __('front.receive_request'));

        return redirect()->back();
    }
}
