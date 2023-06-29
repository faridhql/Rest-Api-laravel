<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::select('IdMenu', 'Name', 'Price', 'Image')->get();

        return response()->json([
            'data' => $menus,
        ]);
    }
}
