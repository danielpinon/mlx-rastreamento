<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SetoresRepository;
use App\Repositories\FaccoesUsersRepository;
use App\Repositories\LotesRastreamentoRepository;
use App\Http\Controllers\Api\BaseController as BaseController;

class loteDeTrabalhoController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SetoresRepository $setoresRepository,
        FaccoesUsersRepository $faccoesUsersRepository,
        LotesRastreamentoRepository $lotesRastreamentoRepository
    )
    {
        $this->setoresRepository = $setoresRepository;
        $this->faccoesUsersRepository = $faccoesUsersRepository;
        $this->lotesRastreamentoRepository = $lotesRastreamentoRepository;
    }

    public function list()
    {
        $user = auth()->user();
        $faccoes = $this->faccoesUsersRepository->findUser($user->id);
        $lotes = $faccoes->lotes->makeHidden(['id','FAC_ID','created_at','updated_at'])->toArray();
        return $this->sendResponse($lotes,'Get list lotes Faccao.');
    }

    public function setoresList()
    {
        $setores = $this->setoresRepository->findWhere(['SETOR_STATUS'=>true,'SETOR_STATUS_EXCLUSIVE_MLX'=>0])->sortBy('SETOR_ORDEM')->makeHidden(['id','SETOR_STATUS','SETOR_STATUS_EXCLUSIVE_MLX','created_at','updated_at'])->toArray();
        return $this->sendResponse($setores,'Get list setores faccao.');
    }

    public function info($token)
    {
        $lote = $this->lotesRastreamentoRepository->findToken($token);
        $array = [
            "lote"=>$lote->makeHidden(['id','FAC_ID','created_at','updated_at'])->toArray(),
            "itens"=>$lote->itens->makeHidden(['id','LOTE_ID','created_at','updated_at'])->toArray()
        ];
        return $this->sendResponse($array,'Get itens lote faccao.');
    }

    public function updateItem(Request $request)
    {
        /**
         * Valida Dados
         */
        if (!isset($request->LOTE_IDENTIFY)) {
            return $this->sendError('Error data LOTE_IDENTIFY not send');
        }
        $lote = $this->lotesRastreamentoRepository->findCode($request->LOTE_IDENTIFY);
        if ($lote == null) {
            return $this->sendError('Error data LOTE_IDENTIFY not found');
        }
        /**
         * Efetua a opera????o
         */
        $setores = $this->setoresRepository->findWhere(['SETOR_STATUS'=>true]);
        $setorAtual = "false";
        $proximoSetor = "false";
        foreach ($setores->sortBy('SETOR_ORDEM')->makeHidden(['id','SETOR_STATUS','created_at','updated_at'])->toArray() as $key => $setor) {
            if ($lote->itens->first()->LOTE_ITEM_STATUS == $setor['SETOR_ORDEM']) {
                $setorAtual = $setor['SETOR_ORDEM'];
            }else {
                if ($setorAtual != "false" && $proximoSetor == "false") {
                    $proximoSetor = $setor['SETOR_ORDEM'];
                }
            }
        }
        // dd($setorAtual, $proximoSetor);
        foreach ($lote->itens as $item) {
            if ($proximoSetor == "false") {
                $item->update([
                    "LOTE_ITEM_STATUS" => $setorAtual
                ]);
            }else{
                $item->update([
                    "LOTE_ITEM_STATUS" => $proximoSetor
                ]);
            }
        }
        
        /**
         * Verifica se todos os itens est??o atualizados
         */
        $lote = $this->lotesRastreamentoRepository->findCode($request->LOTE_IDENTIFY);
        $itens = $lote->itens;
        $itensCount = $itens->count();
        $itensComplete = 0;
        foreach ($itens as $key => $item) {
            if ($item->LOTE_ITEM_STATUS == $setores->sortByDesc('SETOR_ORDEM')->first()->SETOR_ORDEM) {
                $itensComplete++;
            }
        }
        // Ent??o todos os itens est??o completos
        if ($itensCount ==$itensComplete) {
            $lote->update([
                "LOTE_STATUS" => true
            ]);
        }
        
        return $this->sendResponse(["success"=>true],'Updated item.');
    }

    /* Route::get('list', 'loteDeTrabalhoController@list');
            Route::get('{token}/info', 'loteDeTrabalhoController@info');
            Route::get('setores/list', 'loteDeTrabalhoController@setoresList');
            Route::post('update', 'loteDeTrabalhoController@updateItem');
     */
}
