<?php

namespace App\Http\Controllers;

use App\Models\MailingList;
use Illuminate\Http\Request;

class MailingListController extends Controller
{
    // Exibir todas as listas
    public function index()
    {
        $lists = MailingList::all();

        if ($lists->isEmpty()) {
            return response()->json([
                'message' => 'Nenhuma lista de e-mail encontrada.'
            ], 200);
        }

        return response()->json($lists, 200);
    }

    // Criar uma nova lista
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            $list = MailingList::create($validatedData);
            return response()->json([
                'message' => "Lista de e-mail '{$list->name}' criada com sucesso.",
                'data' => $list
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar a lista de e-mail.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Exibir uma lista específica
    public function show($id)
    {
        $list = MailingList::find($id);

        if (!$list) {
            return response()->json([
                'message' => 'Lista de e-mail não encontrada.'
            ], 404);
        }

        return response()->json($list, 200);
    }

    // Atualizar uma lista
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $list = MailingList::find($id);

        if (!$list) {
            return response()->json([
                'message' => 'Lista de e-mail não encontrada.'
            ], 404);
        }

        try {
            $list->update($validatedData);
            return response()->json([
                'message' => "Lista de e-mail '{$list->name}' atualizada com sucesso.",
                'data' => $list
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao atualizar a lista de e-mail.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Deletar uma lista
    public function destroy($id)
    {
        $list = MailingList::find($id);

        if (!$list) {
            return response()->json([
                'message' => 'Lista de e-mail não encontrada.'
            ], 404);
        }

        try {
            $list->delete();
            return response()->json([
                'message' => "Lista de e-mail '{$list->name}' excluída com sucesso."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao excluir a lista de e-mail.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function subscribe(Request $request, $id)
    {
        $user = auth()->user();
        $mailingList = MailingList::find($id);

        if (!$mailingList) {
            return response()->json(['message' => 'Lista de e-mail não encontrada.'], 404);
        }

        if ($mailingList->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Você já está inscrito nesta lista.'], 409);
        }

        $mailingList->users()->attach($user->id);

        return response()->json(['message' => 'Inscrição realizada com sucesso.'], 200);
    }
}
