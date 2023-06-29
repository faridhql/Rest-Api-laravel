<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;         
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idmenu' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $customerId = Auth::id();

        $menuIds = $request->input('idmenu');
        $quantities = $request->input('quantity');

        if (!is_array($menuIds)) {
            $menuIds = [$menuIds];
            $quantities = [$quantities];
        }

        $order = Order::create([
            'IdCustomer' => $customerId,
            'Payment' => 0,
            'SubTotal' => 0,
        ]);

        $subtotal = 0;

        foreach ($menuIds as $index => $menuId) {
            $quantity = $quantities[$index];

            // Mencari menu berdasarkan ID
            $menu = Menu::find($menuId);

            if (!$menu) {
                return response()->json(['message' => 'Menu not found'], 404);
            }

            $price = $menu->Price;
            $subtotal += $price * $quantity;

            DetailOrder::create([
                'IdOrder' => $order->IdOrder,
                'IdMenu' => $menuId,
                'Quantity' => $quantity,
                'Price' => $price,
            ]);
        }

        // Mengupdate subtotal order
        $order->update(['SubTotal' => $subtotal]);

        return response()->json(['message' => 'Order created successfully', 'total_price' => $subtotal], 201);
    }

    public function getOrder($orderId = null)
    {
        $customerId = Auth::id();

        if ($orderId === null) {
            $orders = Order::where('IdCustomer', $customerId)->with('details.menu')->get();

            return response()->json(['data' => $orders]);
        }

        $order = Order::where('IdOrder', $orderId)->where('IdCustomer', $customerId)->with('details.menu')->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['data' => $order]);
    }


    public function destroy($orderId)
    {
        $customerId = Auth::id();

        $order = Order::where('IdOrder', $orderId)->where('IdCustomer', $customerId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);


    }
}
