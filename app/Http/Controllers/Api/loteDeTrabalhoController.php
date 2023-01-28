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
        if ($user->type != 0) {
            $faccoes = $this->faccoesUsersRepository->findUser($user->id);
            $lotes = $faccoes->lotes->makeHidden(['id','FAC_ID','created_at','updated_at'])->toArray();
        }else{
            $lotes = $this->lotesRastreamentoRepository->all()->makeHidden(['id','FAC_ID','created_at','updated_at'])->toArray();
        }
        return $this->sendResponse($lotes,'Get list lotes Faccao.');
    }

    public function setoresList()
    {
        $user = auth()->user();
        if ($user->type != 0) {
            $setores = $this->setoresRepository->findWhere(['SETOR_STATUS'=>true,'SETOR_STATUS_EXCLUSIVE_MLX'=>0])->sortBy('SETOR_ORDEM')->makeHidden(['id','SETOR_STATUS','SETOR_STATUS_EXCLUSIVE_MLX','created_at','updated_at'])->toArray();
        }else{
            $setores = $this->setoresRepository->findWhere(['SETOR_STATUS'=>true])->sortBy('SETOR_ORDEM')->makeHidden(['id','SETOR_STATUS','SETOR_STATUS_EXCLUSIVE_MLX','created_at','updated_at'])->toArray();
        }
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
         * Efetua a operação
         */
        $setores = $this->setoresRepository->findWhere(['SETOR_STATUS'=>true]);
        $setorAtual = "false";
        $setorAtualExclusive = false;
        $proximoSetor = "false";
        foreach ($setores->sortBy('SETOR_ORDEM')->makeHidden(['id','SETOR_STATUS','created_at','updated_at'])->toArray() as $key => $setor) {
            if (($lote->itens->first()->LOTE_ITEM_STATUS + 1) == $setor['SETOR_ORDEM']) {
                $setorAtual = $setor['SETOR_ORDEM'] - 1;
                $setorAtualExclusive = ($setor['SETOR_STATUS_EXCLUSIVE_MLX'])?1:0;
            }else {
                if ($setorAtual != "false" && $proximoSetor == "false") {
                    $proximoSetor = $setor['SETOR_ORDEM'] - 1;
                }
            }
        }
        // Valida se é exclusiva (Se for difente está correto)
        if ($setorAtualExclusive != auth()->user()->type) {
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
            if ($proximoSetor == "false") {
                $lote->update([
                    "LOTE_STATUS" => $setorAtual
                ]);
            }else{
                $lote->update([
                    "LOTE_STATUS" => $proximoSetor
                ]);
            }
            
        }
        return $this->sendResponse(["success"=>true],'Updated item.');
    }

    /* Route::get('list', 'loteDeTrabalhoController@list');
            Route::get('{token}/info', 'loteDeTrabalhoController@info');
            Route::get('setores/list', 'loteDeTrabalhoController@setoresList');
            Route::post('update', 'loteDeTrabalhoController@updateItem');
     */
}
