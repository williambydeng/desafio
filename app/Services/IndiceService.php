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

            
            // Check if there are subindices and recursively insert them
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
}
