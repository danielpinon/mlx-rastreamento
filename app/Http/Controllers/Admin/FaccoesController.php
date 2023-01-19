<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SetoresRepository;
use App\Repositories\FaccoesRepository;
use App\Repositories\FaccoesUsersRepository;

class FaccoesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FaccoesRepository $faccoesRepository,
        SetoresRepository $setoresRepository,
        FaccoesUsersRepository $faccoesUsersRepository
    )
    {
        $this->middleware('auth');
        $this->setoresRepository = $setoresRepository;
        $this->faccoesRepository = $faccoesRepository;
        $this->faccoesUsersRepository = $faccoesUsersRepository;
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
     * Apagar Facções
     */
    public function delete($token)
    {
        $faccao = $this->faccoesRepository->findToken($token);
        if ($faccao == null) {
            return redirect()->back()->with('falha','Erro ao buscar facção!');
        }
        $users =  $this->faccoesUsersRepository->findWhere([
            'FAC_ID' => $faccao->id
        ]);
        foreach ($users as $key => $relation) {
            # code...
            $relation->user->delete();
        }
        $faccao->delete();
        return redirect()->back()->with('sucesso','Facção apagada com sucesso!');
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
        $setores = $this->setoresRepository->findWhere(['SETOR_STATUS'=>true]);
        return view('pages.faccoes.info', compact('faccao'));
        
    }

}
