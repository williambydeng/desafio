<?php

namespace App\Services;

use App\Models\Indice;
use App\Models\Livro;
use App\Repositories\IndiceRepository;

class IndiceService
{
    public function insertIndices($livro, $indices)
    {
        foreach ($indices as $indiceData) {

            $indice = $livro->indices()->create($indiceData);

            if (isset($indiceData['subindices']) && is_array($indiceData['subindices'])) {
                $this->insertSubIndices($indice, $indiceData['subindices']);
            }
        }
    }

    public function insertSubIndices($parentIndice, $indices)
    {
        foreach ($indices as $indiceData) {

            $indice = $parentIndice->subindices()->create($indiceData);

            if (isset($indiceData['subindices']) && is_array($indiceData['subindices'])) {
                $this->insertSubIndices($indice, $indiceData['subindices']);
            }
        }
    }

    public function searchLivrosByTituloAndIndice($query, $titulo, $tituloDoIndice)
    {
        $query->with('usuario_publicador', 'indices.subindices');

        if ($titulo) {
            $query->where('titulo', 'like', '%' . $titulo . '%');
        }

        if ($tituloDoIndice) {
            $query->whereHas('indices', function ($subquery) use ($tituloDoIndice) {
                $subquery->where('titulo', 'like', '%' . $tituloDoIndice . '%')
                    ->orWhereHas('subindices', function ($subsubquery) use ($tituloDoIndice) {
                        $subsubquery->where('titulo', 'like', '%' . $tituloDoIndice . '%');
                        //$this->recursiveSubindicesQuery($subsubquery, $tituloDoIndice);
                    });
            });
        }

        return $query->get();
    }

    private function recursiveSubindicesQuery($query, $tituloDoIndice)
    {
        $query->orWhereHas('subindices', function ($subquery) use ($tituloDoIndice) {
            $subquery->where('titulo', 'like', '%' . $tituloDoIndice . '%');
            $this->recursiveSubindicesQuery($subquery, $tituloDoIndice); // Recursive call
        });
    }

}
