<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Traits\ProductTrait;
use App\Mail\ContactMail;
use App\Models\Banner;
use App\Models\ContactRequest;
use App\Models\Product;
use App\Models\RecentlyView;
use App\Models\Setting;
use App\Repositories\BannerRepository;
use App\Repositories\ProfessionRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends ApiController
{
    use ProductTrait;

    public function recentlyViews(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        $lastViewsIds = RecentlyView::query()->where('user_id', $user->id)->pluck('product_id')->toArray();

        if (! is_array($lastViewsIds)) {
            return $this->respondError(__('api.please_provide_valid_array'));
        }

        $products = Product::whereIn('id', $lastViewsIds)
            ->where('status', 1)
            ->with(['owner', 'attributes', 'reviews', 'tags'])
            ->paginate($limit);

        $productsPage = $this->likedByUser($products, $user)->all();

        return $this->respondSuccess($productsPage, $this->createApiPaginator($products));
    }

    public function professions(Request $request, ProfessionRepository $professionRepository): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $professions = $professionRepository->getProfessions($request)->paginate($limit);

        return $this->respondSuccess($professions->all(), $this->createApiPaginator($professions));
    }

    public function tags(Request $request, TagRepository $tagRepository): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $tags = $tagRepository->getTags($request)->paginate($limit);

        return $this->respondSuccess($tags->all(), $this->createApiPaginator($tags));
    }

    public function contact(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $clientName = $request->get('name');
        $clientEmail = $request->get('email');
        $message = $request->get('message');

        ContactRequest::query()->create([
            'name' => $clientName,
            'email' => $request->get('email'),
            'message' => $message,
        ]);

        $adminName = Setting::query()->where('key', 'admin.name')->first()->text->value;
        $adminEmail = Setting::query()->where('key', 'admin.email')->first()->text->value;

        $data = ['name' => $adminName, 'client_name' => $clientName, 'message' => $message, 'client_email' => $clientEmail];

        // Send Email
        Mail::to([
            'email' => $adminEmail,
        ])->send(new ContactMail($data));

        return $this->respondSuccess();
    }

    public function about(): JsonResponse
    {
        $about = Setting::query()->where('key', 'app.about-us')->first()->richTextBox->value;
        $contentRaw = strip_tags($about);

        return $this->respondSuccess(['about' => $about, 'raw' => $contentRaw]);
    }

    public function terms(): JsonResponse
    {
        $terms = Setting::query()->where('key', 'app.terms-conditions')->first()->richTextBox->value;
        $contentRaw = strip_tags($terms);

        return $this->respondSuccess(['terms' => $terms, 'raw' => $contentRaw]);
    }

    public function privacy(): JsonResponse
    {
        $privacy = Setting::query()->where('key', 'app.privacy-policy')->first()->richTextBox->value;
        $contentRaw = strip_tags($privacy);

        return $this->respondSuccess(['privacy' => $privacy, 'raw' => $contentRaw]);
    }

    public function accessibility(): JsonResponse
    {
        $accessibility = Setting::query()->where('key', 'app.accessibility')->first()->richTextBox->value;
        $contentRaw = strip_tags($accessibility);

        return $this->respondSuccess(['accessibility' => $accessibility, 'raw' => $contentRaw]);
    }

    public function banners(BannerRepository $bannerRepository): JsonResponse
    {
        $banners = $bannerRepository->getBanners()->get();
        $banners->map(function ($banner) {
            $banner->{$banner->model_type_name} = $banner->applicable;

            return $banner;
        });

        return $this->respondSuccess($banners);
    }

    public function randomBanners(): JsonResponse
    {
        return $this->respondSuccess(Banner::query()->inRandomOrder()->first());
    }
}
