<?php

namespace Tests\Feature;

use App\Exceptions\NotFoundProjectException;
use App\Models\Localizacao;
use App\Models\Projeto;
use App\Models\TipoInstalacao;
use App\Services\Project\Contracts\ProjectServiceContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class DestroyProjectControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function projectData(): array
    {
        return [
            'cliente_id' => 1,
            'nome' => 'Projeto Solar João',
            'uf' => 'SP',
            'tipo_instalacao' => 'Fibrocimento (Madeira)',
            'equipamentos' => [
                [
                    'equipamento_id' => 1,
                    'quantidade' => 2
                ]
            ]
        ];
    }

    public function testSuccessfulDestroyProject()
    {
        $project = Projeto::factory()->create(['id' => 1]);

        $response = $this->deleteJson('/api/projects/' . $project->id);

        $response->assertStatus(Response::HTTP_ACCEPTED);
        $response->assertJson([
            'message' => 'Projeto removido com sucesso.',
        ]);
    }

    public function testErrorInTryingDestroyProject()
    {
        $response = $this->deleteJson('/api/projects/1');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertJson([
            'message' => 'Erro interno do servidor',
        ]);
    }
}
