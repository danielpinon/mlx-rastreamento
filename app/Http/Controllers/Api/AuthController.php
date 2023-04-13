<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\FaccoesUsersRepository;
use App\Repositories\FaccoesMensagensRepository;
use App\Repositories\LotesRastreamentoRepository;
use App\Http\Controllers\Api\BaseController as BaseController;

class AuthController extends BaseController
{
    private $faccoesMensagensRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FaccoesUsersRepository $faccoesUsersRepository,
        FaccoesMensagensRepository $faccoesMensagensRepository,
        LotesRastreamentoRepository $lotesRastreamentoRepository
    )
    {
        $this->faccoesUsersRepository = $faccoesUsersRepository;
        $this->faccoesMensagensRepository = $faccoesMensagensRepository;
        $this->lotesRastreamentoRepository = $lotesRastreamentoRepository;
    }

    public function signin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken('mlx')->plainTextToken; 
            $success['name'] =  $authUser->name;
   
            return $this->sendResponse($success, 'User signed in');
        }else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['type'] = 1;
        $user = User::create($input);
        $success['token'] =  $user->createToken('mlx')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User created successfully.');
    }

    public function me()
    {
        return $this->sendResponse(auth()->user()->makeHidden(['id','email_verified_at','type','created_at','updated_at']),'Get User.');
    }

    public function sendMsg(Request $request)
    {
        try {
            $faccao = $this->faccoesUsersRepository->findUser(auth()->user()->id);
            if (isset($request['LOTE_IDENTIFY'])) {
                $lote = $this->lotesRastreamentoRepository->findCode($request->LOTE_IDENTIFY);
            }
            $msg = $this->faccoesMensagensRepository->create([
                'FAC_ID' => $faccao->id,
                'FAC_MSG_APP' => $request->MSG,
                'LOTE_ID' => (isset($request['LOTE_IDENTIFY']))?$lote->id:null
            ]);
            return $this->sendResponse(["sucess"=>true],'Send Msg.');
        } catch (\Throwable $th) {
            return $this->sendError('Error Send Msg.', $th);   
        }
        
    }

    public function info()
    {
        $array = [
            // "pastos" => $this->pastosRepository->count(),
            // "periodos" => $this->pastosPeriodoRepository->count(),
            // "fazendas"=>[
            //     "count" => $this->fazendasRepository->count(),
            //     "piquetes" => $this->fazendasPiquetesRepository->count()
            // ]
        ];
        return $this->sendResponse($array,'Get Info.');
    }
}
