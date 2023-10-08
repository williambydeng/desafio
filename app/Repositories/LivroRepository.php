<?php

namespace App\Repositories;

use App\Models\Livro;

class LivroRepository extends BaseRepository
{
    public function __construct(Livro $model)
    {
        parent::__construct($model);
    }
}
