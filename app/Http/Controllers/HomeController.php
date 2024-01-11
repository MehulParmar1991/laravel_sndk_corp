<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_images;
use App\Models\Product_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller {

    public function index() {
        return view('home');
    }
}
