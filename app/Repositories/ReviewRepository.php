<?php

namespace App\Repositories;

use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReviewRepository
{
    public function add(Request $request)
    {
        $review = Review::query()->updateOrCreate([
            'user_id' => $request->get('user_id'),
            'service_id' => $request->get('service_id'),
        ], [
            'user_id' => $request->get('user_id'),
            'service_id' => $request->get('service_id'),
            'review' => $request->get('review'),
            'review_content' => $request->get('review_content'),
        ]);
        $review->save();
    }

    public function delete(Review $review)
    {
        $review->delete();
    }

    public function getReviews(Request $request): Builder
    {
        $reviews = Review::query();

        if ($search = $request->get('search')) {
            $tokens = convertToSeparatedTokens($search);
            $reviews->whereRaw('MATCH(review_content) AGAINST(? IN BOOLEAN MODE)', $tokens);
        }

        return $reviews->orderBy('sort_order');
    }

    public function getReviewsDataTable(Request $request): LengthAwarePaginator
    {
        $reviews = Review::query();

        $admin = auth()->user();
        if (! $admin->hasRole('Admin')) {
            $reviews = $admin->reviews();
        }

        if (isset($request->get('query')['search']) != null) {
            $tokens = convertToSeparatedTokens($request->get('query')['search']);
            $reviews->whereRaw('MATCH(review_content) AGAINST(? IN BOOLEAN MODE)', $tokens);
        }

        if (isset($request->get('query')['from_date']) != null) {
            $reviews->where('created_at', '>=', $request->get('query')['from_date']);
        }

        if (isset($request->get('query')['to_date']) != null) {
            $reviews->where('created_at', '<=', Carbon::parse($request->get('query')['to_date'])->endOfDay());
        }

        $reviews = $reviews->orderBy($request->get('sort')['field'] ?? 'review', $request->get('sort')['sort'] ?? 'asc')
            ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);

        return $reviews;
    }
}
