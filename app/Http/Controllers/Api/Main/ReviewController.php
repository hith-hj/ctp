<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\ReviewRequest;
use App\Http\Traits\ReviewTrait;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends ApiController
{
    use ReviewTrait;

    public function review(ReviewRequest $request): JsonResponse
    {
        $user = $this->getUser($request);

        Review::query()->create([
            'service_id' => $request->get('service_id'),
            'user_id' => $user->id,
            'review' => $request->get('review'),
            'review_content' => $request->get('review_content'),
        ]);

        return $this->respondSuccess(__('api.added_successfully'));
    }

    public function reviews(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $user = $this->getUser($request);

        $reviewList = Review::query()
            ->where('user_id', $user->id)
            ->paginate($limit);

        return $this->respondSuccess($reviewList->all(), $this->createApiPaginator($reviewList));
    }
}
