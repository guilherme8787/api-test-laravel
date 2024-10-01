<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Equipamento;
use App\Models\Localizacao;
use App\Models\Projeto;
use App\Models\TipoInstalacao;
use App\Services\Project\Contracts\ProjectServiceContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UpdateProjectControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var string
     */
    private const VALID_INSTALLATION_TYPE = 'Fibrocimento (Madeira)';

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function mountedProjectReturn(): array
    {
        return [
            'cliente_id' => 1,
            'nome' => 'Projeto Solar Atualizado',
            'uf' => 'SP',
            'tipo_instalacao' => self::VALID_INSTALLATION_TYPE,
            'equipamentos' => [
                [
                    'equipamento_id' => Equipamento::factory()->create()->id,
                    'quantidade' => 2
                ]
            ]
        ];
    }

    public function testSuccessfulUpdateProject()
    {
        $data = $this->mountedProjectReturn();
        $clientId = Cliente::factory()->create()->id;
        $fakeName = $this->faker->unique()->words(3, true);
        $data['cliente_id'] = $clientId;
        $projectData = [
            'cliente_id' => $clientId,
            'nome' => $fakeName
        ];

        $project = Projeto::factory($projectData)->create();

        $response = $this->putJson('/api/projects/' . $project->id, $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'message' => 'Projeto atualizado com sucesso.',
            'project' => [
                'cliente_id' => $clientId,
                'nome' => 'Projeto Solar Atualizado',
            ]
        ]);
    }

    public function testSuccessfulUpdateProjectEquips()
    {
        $data = $this->mountedProjectReturn();
        $clientId = Cliente::factory()->create()->id;
        $fakeName = $this->faker->unique()->words(3, true);
        $data['cliente_id'] = $clientId;
        $projectData = [
            'cliente_id' => $clientId,
            'nome' => $fakeName
        ];

        $project = Projeto::factory($projectData)->create();

        $response = $this->putJson('/api/projects/' . $project->id, $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'message' => 'Projeto atualizado com sucesso.',
            'project' => [
                'cliente_id' => $clientId,
                'nome' => 'Projeto Solar Atualizado',
            ]
        ]);

        $this->assertDatabaseHas('projeto_equipamento', [
            'projeto_id' => $project->id,
            'equipamento_id' => $data['equipamentos'][0]['equipamento_id'],
            'quantidade' => $data['equipamentos'][0]['quantidade']
        ]);
    }

    public function testErrorWithClientNotExistsOnUpdate()
    {
        $data = $this->mountedProjectReturn();

        $response = $this->putJson('/api/projects/1', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'message' => 'O cliente informado não existe.',
            'errors' => [
                'cliente_id' => ['O cliente informado não existe.']
            ]
        ]);
    }

    public function testErrorWithProjectNotExists()
    {
        $data = $this->mountedProjectReturn();

        Cliente::factory()->create(['id' => 1]);
        TipoInstalacao::factory()->valid()->create();
        Localizacao::factory()->create(['uf' => 'SP']);

        $response = $this->putJson('/api/projects/999', $data);

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertJson([
            'message' => 'Projeto não encontrado',
        ]);
    }
}
