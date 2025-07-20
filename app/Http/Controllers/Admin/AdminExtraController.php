<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminExtraController extends Controller
{
    public $resource = 'admin';

    public function VendorsAutoComplete(Request $request): JsonResponse
    {

        if ($request->has('role')) {
            $vendors = Admin::role($request->get('role'));
        } else {
            $vendors = Admin::role(['retail']);
        }

        if ($request->has('search')) {
            $vendors->where(function ($query) use ($request) {
                $search = $request->get('search');
                $tokens = convertToSeparatedTokens($search);
                $query
                    ->whereRaw('MATCH(name, email, username) AGAINST(? IN BOOLEAN MODE)', $tokens)
                    ->orWhereHas('translations', function ($query) use ($tokens) {
                        $query
                            ->whereRaw('MATCH(company_name, about) AGAINST(? IN BOOLEAN MODE)', $tokens);
                    });
            });
        }

        $models = $vendors
            ->take(5)
            ->get()->map(function ($result) {
                return [
                    'id' => $result->id,
                    'text' => $result->name.' ('.($result->company_name ?? $result->username).') ('.$result->email.')',
                ];
            });

        return response()->json([
            'results' => $models,
        ]);
    }
}
