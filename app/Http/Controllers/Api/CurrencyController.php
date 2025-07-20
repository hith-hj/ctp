<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyController extends ApiController
{
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $request->request->add(['status' => 1]);

        $categories = $this->currencyRepository
            ->getCurrencies($request);

        return $this->respondSuccess($categories->all(), $this->createApiPaginator($categories));
    }
}
