<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

function appendGeneralPermissions(Controller $controller)
{
    $controller->middleware(['permission:list '.Str::plural($controller->resource)], ['only' => ['index', 'show']]);
    $controller->middleware(['permission:add '.Str::plural($controller->resource)], ['only' => ['create', 'store']]);
    $controller->middleware(['permission:edit '.Str::plural($controller->resource)], ['only' => ['edit', 'update']]);
    $controller->middleware(['permission:delete '.Str::plural($controller->resource)], ['only' => ['delete']]);
}
