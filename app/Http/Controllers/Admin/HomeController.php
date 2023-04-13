<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FaccoesRepository;
use App\Repositories\FaccoesMensagensRepository;
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
        FaccoesMensagensRepository $faccoesMensagensRepository,
        LotesRastreamentoRepository $lotesRastreamentoRepository
    )
    {
        $this->middleware('auth');
        $this->faccoesRepository = $faccoesRepository;
        $this->faccoesMensagensRepository = $faccoesMensagensRepository;
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
        $msgs = $this->faccoesMensagensRepository->findWhere(['FAC_MSG_READ' => false]);
        return view('dashboard', compact('faccoes','lotes','msgs'));
    }

    /**
     * Marca como lido mensagem
     */
    public function markRead($id)
    {
        $msg = $this->faccoesMensagensRepository->find($id);
        $msg->update(["FAC_MSG_READ" => true]);
        return redirect()->back()->with('sucesso','Mensagem marcado como lido!');
    }
}
