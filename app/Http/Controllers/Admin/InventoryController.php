<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = DB::table('inventory')->get();
        foreach ($inventory as $item) {
            $item->product = Product::find($item->product_id);
        }

        return view('admin.inventory.index', [
            'inventory' => $inventory ?? [],
        ]);
    }

    public function addInventoryItem($request, $id)
    {
        $quantity = $request->quantity ?? 1;
        $query = DB::table('inventory')->where('product_id', $id);
        if ($query->exists()) {
            $query->update(['quantity' => $query->first()->quantity + $quantity]);
        } else {
            DB::table('inventory')->insert([
                'product_id' => $id,
                'quantity' => $quantity,
                'status' => 1,
            ]);
        }

    }

    public function addInventoryItemQuantity(Request $request, $id)
    {
        $quantity = $request->get('quantity_'.$id);
        if (! isset($quantity) || $quantity < 2) {
            return redirect()->back();
        }
        $item = DB::table('inventory')->where('id', $id);
        if ($item->exists()) {
            $item->update(['quantity' => $item->first()->quantity + $quantity]);
        }

        return redirect()->back();
    }

    public function deleteInventoryItem(Request $request, $id)
    {
        $item = DB::table('inventory')->where('id', $id);
        if ($item->first()) {
            $item->delete();
        }

        return redirect()->back();
    }
}
