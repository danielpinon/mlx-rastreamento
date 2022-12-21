<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FaccoesRepository;
use App\Repositories\LotesRastreamentoRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FaccoesRepository $faccoesRepository,
        LotesRastreamentoRepository $lotesRastreamentoRepository
    )
    {
        $this->middleware('auth');
        $this->faccoesRepository = $faccoesRepository;
        $this->lotesRastreamentoRepository = $lotesRastreamentoRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faccoes = $this->faccoesRepository->findWhere(['FAC_STATUS' => true]);
        $lotes = $this->lotesRastreamentoRepository->all();
        return view('dashboard', compact('faccoes','lotes'));
    }
}
