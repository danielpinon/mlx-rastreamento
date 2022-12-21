<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FaccoesRepository;
use App\Repositories\LotesRastreamentoRepository;
use App\Repositories\LotesRastreamentoItemRepository;

class LotesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FaccoesRepository $faccoesRepository,
        LotesRastreamentoRepository $lotesRastreamentoRepository,
        LotesRastreamentoItemRepository $lotesRastreamentoItemRepository
    )
    {
        $this->middleware('auth');
        $this->faccoesRepository = $faccoesRepository;
        $this->lotesRastreamentoRepository = $lotesRastreamentoRepository;
        $this->lotesRastreamentoItemRepository = $lotesRastreamentoItemRepository;
    }

    /**
     * Show the application faccoes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faccoes = $this->faccoesRepository->findWhere(["FAC_STATUS"=>1]);
        $lotes = $this->lotesRastreamentoRepository->all();
        return view('pages.lotes', compact('lotes','faccoes'));
    }


    /**
     * Create the application lote
     * 
     */
    public function create(Request $request)
    {
        $array = $request->toArray();
        $array['LOTE_TOKEN'] = Str::uuid();
        $lote = $this->lotesRastreamentoRepository->create($array);
        for ($i=1; $i <= $request->LOTE_QNT_ITENS; $i++) { 
            $this->lotesRastreamentoItemRepository->create([
                'LOTE_ID' => $lote->id,
                'LOTE_ITEM_IDENTIFY' => "L".str_pad($lote->id, 10 , '0' , STR_PAD_LEFT)."D".date('Ymd')."I".str_pad($i, 4 , '0' , STR_PAD_LEFT)
            ]);
        }
        return redirect()->back()->with('sucesso','Lote Gerado com Sucesso!');
    }

    public function itens($token)
    {
        $lote = $this->lotesRastreamentoRepository->findToken($token);
        return view('pages.lotes.info', compact('lote'));
    }

    public function addItem($token)
    {
        $lote = $this->lotesRastreamentoRepository->findToken($token);
        $itens = $lote->itens;
        $i = explode('I',$itens->sortByDesc('id')->first()->LOTE_ITEM_IDENTIFY)[1] + 1;
        $this->lotesRastreamentoItemRepository->create([
            'LOTE_ID' => $lote->id,
            'LOTE_ITEM_IDENTIFY' => "L".str_pad($lote->id, 10 , '0' , STR_PAD_LEFT)."D".date('Ymd')."I".str_pad($i, 4 , '0' , STR_PAD_LEFT)
        ]);
        $lotes = $this->lotesRastreamentoItemRepository->findWhere(['LOTE_ID' => $lote->id]);
        $lote->update([
            "LOTE_QNT_ITENS" => $lotes->count()
        ]);
        return redirect()->back()->with('sucesso','Item criado no Lote com Sucesso!');
    }

    public function deleteItem($token, $idItem)
    {
        $lote = $this->lotesRastreamentoRepository->findToken($token);
        $item = $this->lotesRastreamentoItemRepository->find($idItem);
        $item->delete();
        $lotes = $this->lotesRastreamentoItemRepository->findWhere(['LOTE_ID' => $lote->id]);
        $lote->update([
            "LOTE_QNT_ITENS" => $lotes->count()
        ]);
        return redirect()->back()->with('sucesso','Item apagado no Lote com Sucesso!');
    }
}
