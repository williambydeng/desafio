<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indice;
use App\Repositories\IndiceRepository;

class IndiceController extends Controller
{
    protected $indiceRepository;
    
    public function __construct(IndiceRepository $indiceRepository)
    {
        $this->indiceRepository = $indiceRepository;
    }

    public function index()
    {
        $indices = $this->indiceRepository->all();
        return response()->json($indices);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string',
            'pagina' => 'required|integer',
            'livro_id' => 'required|integer',
            'indice_pai_id' => 'nullable|integer',
        ]);

        $indice = $this->indiceRepository->create($validatedData);

        return response()->json($indice, 201);
    }

    public function show(Indice $indice)
    {
        return response()->json($indice);
    }

    public function update(Request $request, Indice $indice)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string',
            'pagina' => 'required|integer',
            'livro_id' => 'required|integer',
            'indice_pai_id' => 'nullable|integer',
        ]);

        $this->indiceRepository->update($validatedData);

        return response()->json($indice);
    }

    public function destroy(Indice $indice)
    {
        $this->indiceRepository->delete();

        return response()->json(['message' => 'Indice deleted']);
    }
}
