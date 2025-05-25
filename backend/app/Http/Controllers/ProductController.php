<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Agrega esta línea

class ProductController extends Controller
{

    public function index()
    {
        return response()->json(Product::all());
    }
}
