<?php

namespace App\Http\Controllers\Admin\Faccoes;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Repositories\FaccoesRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\FaccoesUsersRepository;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        FaccoesRepository $faccoesRepository,
        FaccoesUsersRepository $faccoesUsersRepository
    )
    {
        $this->middleware('auth');
        $this->user = $user;
        $this->faccoesRepository = $faccoesRepository;
        $this->faccoesUsersRepository = $faccoesUsersRepository;
    }

    public function index($token)
    {
        $faccao = $this->faccoesRepository->findToken($token);
        $usersFaccoes = $this->faccoesUsersRepository->findWhere(["FAC_ID" => $faccao->id]);
        return view('pages.faccoes.usuarios', compact('faccao','usersFaccoes'));
    }

    public function create(Request $request, $token)
    {
        $faccao = $this->faccoesRepository->findToken($token);
        /**
         * Valida
         */
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if($validator->fails()){
            return redirect()->back()
            ->with('falha','Verifique os campos e tente novamente')
            ->withInput();
        }
        /**
         * Cria o usuário
         */
        $request['password'] = Hash::make($request['password']);
        $request['type'] = 1; // Tipo crm
        $user = $this->user->create($request->all());
        $this->faccoesUsersRepository->create([
            'USER_ID' => $user->id,
            'FAC_ID' => $faccao->id
        ]);
        return redirect()->back()->with('success','Usuário criado com sucesso!');
    }

    public function update(Request $request, $token, $idUser)
    {
        $user = $this->user->find($idUser);
        $faccao = $this->faccoesRepository->findToken($token);
        $relacionamento = $this->faccoesUsersRepository->findWhere([
            'USER_ID' => $idUser,
            'FAC_ID' => $faccao->id
        ]);
        if ($relacionamento->count() == 0) {
            return redirect()->back()
            ->with('falha','Usuário não pertence a faccao')
            ->withInput();
        }
        if(isset($request->password) && isset($request->password_confirmation)){
            // Se tiver senha
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            if($validator->fails()){
                return redirect()->back()
                ->with('error','Verifique os campos e tente novamente')
                ->withInput();
            }
            $request['password'] = Hash::make($request['password']);
            $user->update($request->all());
        }else{
            // Se não tiver senha
            $request = $request->except(['_token','password','password_confirmation']);
            $user->update($request);
        }
        return redirect()->back()->with('success','Usuário atualizado com sucesso!');
    }


    public function delete($token, $idUser)
    {
        $faccao = $this->faccoesRepository->findToken($token);
        $relacionamento = $this->faccoesUsersRepository->findWhere([
            'USER_ID' => $idUser,
            'FAC_ID' => $faccao->id
        ]);
        if ($relacionamento->count() == 0) {
            return redirect()->back()
            ->with('falha','Usuário não pertence a faccao')
            ->withInput();
        }
        $user = $this->user->find($idUser)->delete();
        return redirect()->back()->with('success','Usuário apagado com sucesso!');
    }
}
