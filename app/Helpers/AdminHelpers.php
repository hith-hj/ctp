<?php

use App\Models\Category;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use App\Models\Section;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

function localImage($file, $default = '')
{
    if (! empty($file)) {
        return Str::of(Storage::disk('local')->url($file))->replace('storage', 'uploads');
    }

    return $default;
}

function storageImage($file, $default = '')
{
    if (Str::contains($file, 'picsum.photos')) {
        return $file;
    }
    if (! empty($file)) {
        // return str_replace('\\', '/', Storage::disk('public')->url($file));
        return str_replace('\\', '/', asset('storage/'.$file));
    }

    return $default;
}

function getDefaultCurrency()
{
    return Currency::whereRate(1)->first();
}

function secToMin($seconds)
{
    return $seconds / 60;
}

function newStd($array = []): stdClass
{
    $std = new \stdClass();
    foreach ($array as $key => $value) {
        $std->$key = $value;
    }

    return $std;
}

function getRoles()
{
    return Role::all();
}

function getStatusVariables(): array
{
    $active = newStd(['name' => __('admin.active'), 'value' => 1]);
    $inactive = newStd(['name' => __('admin.inactive'), 'value' => 0]);

    return [$active, $inactive];
}

function getOrderStatusClass($status): string
{
    switch ($status) {
        case Order::STATUS_PENDING:
            return 'warning';
        case Order::STATUS_DELIVERED:
            return 'success';
        case Order::STATUS_ONGOING:
            return 'info';
        case Order::STATUS_CANCELLED:
            return 'danger';
        default:
            return '';
    }
}

function getStatusOrder($status)
{
    switch ($status) {
        case Order::STATUS_PENDING:
            return __('order.pending');
        case Order::STATUS_DELIVERED:
            return __('order.delivered');
        case Order::STATUS_ONGOING:
            return __('order.ongoing');
        case Order::STATUS_CANCELLED:
            return __('order.cancelled');
        default:
            return __('admin.empty');
    }
}

function getStatusOrderVariables(): array
{
    $pending = newStd(['name' => __('order.pending'), 'value' => Order::STATUS_PENDING]);
    $delivered = newStd(['name' => __('order.delivered'), 'value' => Order::STATUS_DELIVERED]);
    $ongoing = newStd(['name' => __('order.ongoing'), 'value' => Order::STATUS_ONGOING]);
    $cancelled = newStd(['name' => __('order.cancelled'), 'value' => Order::STATUS_CANCELLED]);

    return [$pending, $delivered, $ongoing, $cancelled];
}

function getBannerModelTypes(): array
{
    $vendor = newStd(['name' => __('admin.vendor'), 'value' => 'App\Models\Admin']);
    $supplier = newStd(['name' => __('admin.supplier'), 'value' => 'App\Models\Admin']);
    $designer = newStd(['name' => __('admin.designer'), 'value' => 'App\Models\User']);
    $product = newStd(['name' => __('admin.product'), 'value' => 'App\Models\Product']);

    return [$vendor, $supplier, $designer, $product];
}

function getCategoryTypesVariables(): array
{
    $vendor = newStd(['name' => __('admin.vendor'), 'value' => 'vendor']);
    $supplier = newStd(['name' => __('admin.supplier'), 'value' => 'supplier']);
    $both = newStd(['name' => __('admin.both'), 'value' => 'both']);

    return [$vendor, $supplier, $both];
}

function getTypesVariables(): array
{
    $text = newStd(['name' => __('admin.text'), 'value' => 'text']);
    $number = newStd(['name' => __('admin.number'), 'value' => 'number']);
    $checkbox = newStd(['name' => __('admin.checkbox'), 'value' => 'checkbox']);
    $color = newStd(['name' => __('admin.color'), 'value' => 'color']);

    return [$text, $number, $checkbox, $color];
}

function getRequiredSelect(): array
{
    $yes = newStd(['id' => 'Yes']);
    $no = newStd(['id' => 'NO']);

    return [$yes, $no];
}

function getCurrentLanguageSymbol()
{
    return Session::get('applocale');
}

function getSections()
{
    return Section::all();
}

function getCategories($id = null)
{
    if ($id != null) {
        return Category::all()->except($id);
    }

    return Category::all();
}

function getParentsCategories($id = null)
{
    if ($id != null) {
        return Category::query()->whereNull('parent_category')->get()->except($id);
    }
    $parentCategories = Category::query()->whereNull('parent_category')->pluck('id')->toArray();

    //    dd(Category::query()->whereNull('parent_category')
    //        ->orWhereIn('parent_category', $parentCategories)->pluck('parent_category')->toArray());
    return Category::query()->whereNull('parent_category')
        ->orWhereIn('parent_category', $parentCategories)->get();
}

function getSubCategories()
{
    return Category::whereNotNull('parent_category')->get();
}

function setting($key, $type)
{
    if (! auth()->user()) {
        return '';
    }
    if ($type == 'rich_text_box') {
        $type = 'richTextBox';
    }
    $setting = Setting::where('key', $key);
    if ($setting) {
        //    dd( $setting->with($type)->get()->first()->$type);
        //    return $setting->with($type)->get()->first()->{$type}->value;
        return $setting->with($type)->get()->first()->type;
    } else {
        return '';
    }
}

function getActiveProducts()
{
    return Product::query()->where('status', 1)->get();
}

function getBannerApplicableName($appliesTo): string
{
    switch ($appliesTo) {
        case 'AppliesToVendors':
            return 'admin';
        case 'AppliesToCategory':
            return 'category';
        case 'AppliesToProducts':
            return 'product';
        default:
            return '';
    }
}

function renderAttributeInput(Attribute $attribute, $oldValue = null)
{

    return '';

}
