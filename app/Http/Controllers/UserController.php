<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->where('type',0)->get()]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('sucesso','Usuário apagado com sucesso!');
    }

    public function registro(Request $request)
    {
        /**
         * Validador de informações
         */
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        /**
         * Cadastra usuário
         */

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            "subtype" => $request["subtype"]
        ]);
        return redirect()->back()->with('sucesso','Usuário cadastrado com sucesso!');
    }

    public function update(Request $request)
    {
        if($request->password == null){
            $user = User::find($request->id);
            $user->update([
                "name" => $request["name"],
                "email" => $request["email"],
                "subtype" => $request["subtype"]
            ]);
            $user->save();
            return redirect()->back()->with('sucesso','Usuário atualizado com sucesso!');
        }else{
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('falha', 'Erro ao atualizar usuário!')->withInput();
            }
            $user = User::find($request->id);
            $user->update([
                "name" => $request["name"],
                "email" => $request["email"],
                "password" => Hash::make($request['password']),
                "subtype" => $request["subtype"]
            ]);
            $user->save();
            return redirect()->back()->with('sucesso','Usuário atualizado com sucesso!');
        }
    }
}
