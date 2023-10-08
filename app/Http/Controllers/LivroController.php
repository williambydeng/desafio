<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Repositories\LivroRepository;
use App\Services\IndiceService;
use App\Http\Requests\LivroRequest; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Helpers\XmlParser;

class LivroController extends Controller
{
    protected $repository;

    public function __construct(LivroRepository $livroRepository)
    {
        $this->repository = $livroRepository;
    }

    public function index(Request $request, IndiceService $indiceService)
    {
        $query = $this->repository->query();
        $indiceService->searchLivrosByTituloAndIndice(
            $query,
            $request->input('titulo'),
            $request->input('titulo_do_indice')
        );

        $livros = $query->get()->each->setHidden(['id','usuario_publicador_id']);

        return response()->json($livros);
    }

    public function store(LivroRequest $request, IndiceService $indiceService)
    {
        try {
            DB::beginTransaction();
            $livro = $this->repository->create([
                'titulo' => $request->titulo,
                'usuario_publicador_id' => Auth::id()
            ]);
            
            $indiceService->insertIndices($livro, $request->input('indices'));
            DB::commit();

            return response()->json("Livro salvo com sucesso!", 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json("Falha ao salvar livro", 500);
        }
    }

    public function importIndicesFromXml(Request $request, $id, IndiceService $indiceService)
    {
        $xmlData = $request->getContent();

        try {
            DB::beginTransaction();
            $xml = simplexml_load_string($xmlData);
            $structuredData = XmlParser::xmlToArray($xml);
            $livro = $this->repository->find($id);
       
            $indiceService->insertIndices($livro, $structuredData);
            DB::commit();

            return response()->json("Livro salvo com sucesso!", 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json("Falha ao salvar livro", 500);
        }
    }
}
