<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd('asdasdasd');
        $data = app('firebase.firestore')
        ->database()
            ->collection('users')
            ->documents();

        if ($data->isEmpty()) {
            return collect();
        }

        $categories = collect($data->rows());
        dd($categories);
        return view('home');
    }
}
