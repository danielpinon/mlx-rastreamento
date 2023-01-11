<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SetoresRepository;

class SetoresController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SetoresRepository $setoresRepository
    )
    {
        $this->middleware('auth');
        $this->setoresRepository = $setoresRepository;
    }

    /**
     * Show the application faccoes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $setores = $this->setoresRepository->all();
        return view('pages.setores', compact('setores'));
    }
    
    /**
     * Apagar Setor
     */
    public function delete($id)
    {
        $setor = $this->setoresRepository->find($id);
        $setor->delete();
        $setores = $this->setoresRepository->all();
        $order = 1;
        foreach ($setores->sortBy('SETOR_ORDEM') as $key => $setor) {
            $setor->update([
                "SETOR_ORDEM" => $order
            ]);
            $order++;
        }

        return redirect()->back()->with('sucesso','Lote apagado com Sucesso!');
    }

    /**
     * Create the application faccoes
     * 
     */
    public function create(Request $request)
    {
        $array = $request->toArray();
        $array['SETOR_STATUS'] = (isset($array['SETOR_STATUS']))?1:0;
        $array['SETOR_STATUS_EXCLUSIVE_MLX'] = (isset($array['SETOR_STATUS_EXCLUSIVE_MLX']))?1:0;
        $array['SETOR_TOKEN'] = Str::uuid();
        $ultimoSetor = $this->setoresRepository->orderBy('id','desc')->get()->first();
        if ($ultimoSetor == null) {
            $array['SETOR_ORDEM'] = 1;
        }else {
            $array['SETOR_ORDEM'] = $ultimoSetor->SETOR_ORDEM + 1;
        }
        $this->setoresRepository->create($array);
        return redirect()->back()->with('sucesso','Setor Criado com sucesso!');
    }


    /**
     * Organiza faccoes
     */
    public function reorganiza(Request $request)
    {
        foreach ($request->lista as $key => $id) {
            $this->setoresRepository->update([
                "SETOR_ORDEM" => $key + 1 
            ],$id);
        }
    }
}
