<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use chillerlan\QRCode\{QRCode, QROptions};
use App\Http\Controllers\Controller;
use App\Repositories\SetoresRepository;
use App\Repositories\FaccoesRepository;
use App\Repositories\LotesRastreamentoRepository;
use App\Repositories\LotesRastreamentoItemRepository;

class RelatoriosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FaccoesRepository $faccoesRepository,
        SetoresRepository $setoresRepository,
        LotesRastreamentoRepository $lotesRastreamentoRepository,
        LotesRastreamentoItemRepository $lotesRastreamentoItemRepository
    )
    {
        $this->middleware('auth');
        $this->setoresRepository = $setoresRepository;
        $this->faccoesRepository = $faccoesRepository;
        $this->lotesRastreamentoRepository = $lotesRastreamentoRepository;
        $this->lotesRastreamentoItemRepository = $lotesRastreamentoItemRepository;
    }


    /**
     * Página Inicial
     */
    public function index()
    {
        $faccoes = $this->faccoesRepository->all();
        return view('pages.relatorios', compact('faccoes'));
    }

    /**
     * Gera Relatório
     */
    public function geraRelatorio(Request $request)
    {
        $lotes = $this->lotesRastreamentoRepository;
        if ($request->FAC_FILTER == "any" || $request->FAC_FILTER == "") {
            $start = Carbon::parse(explode('/',$request->DATE_INIT)[2].'/'.explode('/',$request->DATE_INIT)[1].'/'.explode('/',$request->DATE_INIT)[0]);
            $end = Carbon::parse(explode('/',$request->DATE_END)[2].'/'.explode('/',$request->DATE_END)[1].'/'.explode('/',$request->DATE_END)[0]);
            if ($request->FILTER_REF == "created") {
                $lotes = $lotes->whereDate('created_at','<=',$end)
                ->whereDate('created_at','>=',$start);
            }else if($request->FILTER_REF == "updated"){
                $lotes = $lotes->whereDate('updated_at','<=',$end)
                ->whereDate('updated_at','>=',$start);
            }
            $lotes = $lotes->get();
        }else{
            $faccao = $this->faccoesRepository->findToken($request->FAC_FILTER); 
            $start = Carbon::parse(explode('/',$request->DATE_INIT)[2].'/'.explode('/',$request->DATE_INIT)[1].'/'.explode('/',$request->DATE_INIT)[0]);
            $end = Carbon::parse(explode('/',$request->DATE_END)[2].'/'.explode('/',$request->DATE_END)[1].'/'.explode('/',$request->DATE_END)[0]);
            if ($request->FILTER_REF == "created") {
                $lotes = $lotes->whereDate('created_at','<=',$end)
                ->whereDate('created_at','>=',$start);
            }else if($request->FILTER_REF == "updated"){
                $lotes = $lotes->whereDate('updated_at','<=',$end)
                ->whereDate('updated_at','>=',$start);
            }
            $lotes = $lotes->where("FAC_ID",$faccao->id)->get();
        }
        $setores = $this->setoresRepository->findWhere(['SETOR_STATUS'=>true]);
        // Gera a Página Imprimivel 
        return view('pdf.relatorio', compact('lotes','request','setores'));
        $pdf = Pdf::loadView('pdf.relatorio', compact('lote'));
        $customPaper = array(0,0,170,113);
        $pdf = $pdf->setPaper($customPaper);
        return $pdf->stream();
    }
}
