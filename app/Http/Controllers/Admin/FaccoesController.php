<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FaccoesRepository;

class FaccoesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FaccoesRepository $faccoesRepository
    )
    {
        $this->middleware('auth');
        $this->faccoesRepository = $faccoesRepository;
    }

    /**
     * Show the application faccoes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faccoes = $this->faccoesRepository->all();
        return view('pages.faccoes', compact('faccoes'));
    }

    /**
     * Create the application faccoes
     * 
     */
    public function create(Request $request)
    {
        $array = $request->toArray();
        $array['FAC_STATUS'] = (isset($array['FAC_STATUS']))?1:0;
        $array['FAC_TOKEN'] = Str::uuid();
        $this->faccoesRepository->create($array);
        return redirect()->back()->with('sucesso','Facção Criada com sucesso!');
    }

    /**
     * Info the application faccoes
     */
    public function info($token)
    {
        $faccao = $this->faccoesRepository->findToken($token);
        if ($faccao == null) {
            return redirect()->back()->with('falha','Erro ao buscar facção!');
        }
        return view('pages.faccoes.info', compact('faccao'));
        
    }

}
