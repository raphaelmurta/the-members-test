<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

/** @package App\Http\Controllers */
class TopicController extends Controller
{
    // Exibir todos os tópicos
    public function index()
    {
        $topics = Topic::all();

        if ($topics->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum tópico encontrado.'
            ], 200);
        }

        return response()->json($topics, 200);
    }

    // Criar um novo tópico
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        try {
            $topic = Topic::create($validatedData);
            return response()->json([
                'message' => "Tópico '{$topic->title}' criado com sucesso.",
                'data' => $topic
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar o tópico.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Exibir um tópico específico
    public function show($id)
    {
        $topic = Topic::find($id);

        if (!$topic) {
            return response()->json([
                'message' => 'Tópico não encontrado.'
            ], 404);
        }

        return response()->json($topic, 200);
    }

    // Atualizar um tópico
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
        ]);

        $topic = Topic::find($id);

        if (!$topic) {
            return response()->json([
                'message' => 'Tópico não encontrado.'
            ], 404);
        }

        try {
            $topic->update($validatedData);
            return response()->json([
                'message' => "Tópico '{$topic->title}' atualizado com sucesso.",
                'data' => $topic
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao atualizar o tópico.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Deletar um tópico
    public function destroy($id)
    {
        $topic = Topic::find($id);

        if (!$topic) {
            return response()->json([
                'message' => 'Tópico não encontrado.'
            ], 404);
        }

        try {
            $topic->delete();
            return response()->json([
                'message' => "Tópico '{$topic->title}' excluído com sucesso."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao excluir o tópico.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
