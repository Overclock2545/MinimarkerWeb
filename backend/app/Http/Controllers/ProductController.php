<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Asegúrate de tener esto bien
        return view('home', ['products' => $products]); // 👈 clave: 'products'
    }
}
