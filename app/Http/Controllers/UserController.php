<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Armazena um novo usuário (somente admin pode criar).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Verifica se o usuário autenticado é admin
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Ação permitida apenas para administradores'], 403);
        }

        // Valida os dados de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'in:user,admin', // Valida para aceitar apenas 'user' ou 'admin'
        ]);

        // Cria o novo usuário com o papel fornecido ou 'user' como padrão
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user', // Define o role com 'user' como padrão se não for fornecido
        ]);

        return response()->json([
            'message' => 'Usuário criado com sucesso',
            'user' => $user
        ], 201);
    }


    /**
     * Exibe todos os usuários.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Exibe os detalhes de um usuário específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        return response()->json($user);
    }

    /**
     * Atualiza um usuário específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        // Verifica se o usuário autenticado é admin
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Ação permitida apenas para administradores'], 403);
        }

        // Valida os dados de entrada
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
        ]);

        // Atualiza os dados do usuário
        $user->update($request->only('name', 'email'));

        // Atualiza a senha apenas se for fornecida
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json(['message' => 'Usuário atualizado com sucesso']);
    }

    /**
     * Remove um usuário específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        // Verifica se o usuário autenticado é admin
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Ação permitida apenas para administradores'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'Usuário removido com sucesso'], 200); // Retorna 200 em vez de 204
    }
}
