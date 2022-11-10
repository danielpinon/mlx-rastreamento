<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LotesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
    )
    {
        $this->middleware('auth');
    }

    /**
     * Show the application faccoes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        dd("True");
        $faccoes = $this->faccoesRepository->all();
        return view('pages.faccoes', compact('faccoes'));
    }
}
