<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sub_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller {

    //todo: admin login form
    public function login_form() {
        return view('admin.login-form');
    }

    //todo: admin login functionality
    public function login_functionality(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        } else {
            Session::flash('error-message', 'Invalid Email or Password');
            return back();
        }
    }

    public function dashboard() {
        return view('admin.dashboard');
    }

    //todo: admin logout functionality
    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('admin');
        //return redirect()->route('login.form');
    }

    public function categories_deleted() {
        $data['countries'] = Category::get(["name", "id"]);
        return view('admin.categories', $data);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fetchCity(Request $request) {
        $data['sub_categories'] = Sub_category::where("category_id", $request->category_id)
                ->get(["name", "id"]);

        return response()->json($data);
    }
}
