<?php

namespace App\Repositories;

use App\Models\Indice;

class IndiceRepository extends BaseRepository
{
    public function __construct(Indice $model)
    {
        parent::__construct($model);
    }
}
