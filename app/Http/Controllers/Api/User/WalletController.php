<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\WalletResource;
use App\Repositories\User\WalletRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends ApiController
{
    private $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function getWallet(Request $request): JsonResponse
    {
        $user = $this->getUser($request);

        return $this->respondSuccess([
            'wallet' => WalletResource::make($user->wallet),
        ]);
    }

    public function deposit()
    {
    }

    public function withdraw()
    {
    }
}
