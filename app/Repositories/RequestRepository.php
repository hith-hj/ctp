<?php

namespace App\Repositories;

use App\Models\VendorRequest;
use Illuminate\Http\Request;

class RequestRepository
{
    public function storeVendorDetails(Request $request): VendorRequest
    {
        $userRequest = new VendorRequest($request->all());
        $userRequest->save();

        return $userRequest;
    }

    public function getVendorRequest()
    {
        $request = VendorRequest::with('user');

        return $request->orderByDesc('created_at');
    }
}
