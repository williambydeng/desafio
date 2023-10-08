<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Repositories\LivroRepository;

class LivroController extends Controller
{
    protected $livroRepository;

    public function __construct(LivroRepository $livroRepository)
    {
        $this->livroRepository = $livroRepository;
    }

    public function index()
    {
        $livros = $this->livroRepository->all();
        return response()->json($livros);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string',
            'usuario_publicador_id' => 'required|integer',
        ]);

        $livro = $this->livroRepository->create($validatedData);

        return response()->json($livro, 201);
    }

    public function show(Livro $livro)
    {
        return response()->json($livro);
    }

    public function update(Request $request, Livro $livro)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string',
            'usuario_publicador_id' => 'required|integer',
        ]);

        $this->livroRepository->update($validatedData);

        return response()->json($livro);
    }

    public function destroy(Livro $livro)
    {
        $this->livroRepository->delete();

        return response()->json(['message' => 'Livro deleted']);
    }
}
