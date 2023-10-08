<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class LivroControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/v1/livros');     
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'livros'); // Check the number of livros in the response

        foreach ($livros as $livro) {
            $response->assertJsonFragment([
                'id' => $livro->id,
                'titulo' => $livro->titulo,
                'usuario_publicador_id' => $livro->usuario_publicador_id,
                'indices' => $livro->indices
            ]);
        }
    }

    public function testStore()
    {
        $data = [
            'titulo' => 'New Livro',
            'indices' => [[
                    'titulo' => 'New Indice',
                    'pagina' => 12,
                    'subindices' => [[
                        'titulo' => 'New Subindice',
                        'pagina' => 13,
                        ]
                    ]
                ]
            ],
        ];

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/v1/livros', $data);

        $response->assertStatus(201);
    }

    public function testImportIndicesFromXml()
    {
        $user = User::factory()->create();

        $xmlData = '<indice>
            <item pagina="1" titulo="Secao 1">
                <item pagina="1" titulo="Secao 1.1">
                    <item pagina="1" titulo="Secao 1.1.1" />
                    <item pagina="1" titulo="Secao 1.1.2" />
                </item>
            </item>
        </indice>';

        $response = $this->actingAs($user)->post('/v1/livros/1/importar-indices-xml', $xmlData);

        $response->assertStatus(201);
    }
}
