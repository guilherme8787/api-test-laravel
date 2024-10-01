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

class GetProjectControllerTest extends TestCase
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

    public function testSuccessfulGetProject()
    {
        $data = $this->projectData();

        Projeto::factory()->create(['id' => 1]);

        $this->instance(
            ProjectServiceContract::class,
            Mockery::mock(ProjectServiceContract::class, function (MockInterface $mock) use ($data) {
                $mock->shouldReceive('get')
                    ->once()
                    ->with(1)
                    ->andReturn(new Projeto($data));
            })
        );

        $response = $this->getJson('/api/projects/1');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'cliente_id' => 1,
            'nome' => 'Projeto Solar João',
        ]);
    }

    public function testSuccessfulGetProjectWithNameFilter()
    {
        $fakeName = $this->faker->unique()->words(3, true);
        $data = [
            'id' => 1,
            'nome' => $fakeName
        ];

        Projeto::factory()->create($data);
        Projeto::factory()->create([
            'nome' => 'Projeto Solar João',
            'cliente_id' => 1,
            'localizacao_id' => Localizacao::factory()->create(['uf' => 'RJ'])->id,
            'tipo_instalacao_id' => TipoInstalacao::factory()
        ]);

        $response = $this->getJson('/api/projects/1?nome=' . $fakeName);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'cliente_id' => 1,
            'nome' => $fakeName,
        ]);
        $response->assertJsonMissing([
            'nome' => 'Projeto Solar João',
        ]);
    }

    public function testNotFoundProject()
    {
        $this->instance(
            ProjectServiceContract::class,
            Mockery::mock(ProjectServiceContract::class, function (MockInterface $mock) {
                $mock->shouldReceive('get')
                    ->once()
                    ->with(1)
                    ->andThrow(new NotFoundProjectException('Projeto não encontrado'));
            })
        );

        $response = $this->getJson('/api/projects/1');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'message' => 'Projeto não encontrado',
        ]);
    }

    public function testInternalServerError()
    {
        $this->instance(
            ProjectServiceContract::class,
            Mockery::mock(ProjectServiceContract::class, function (MockInterface $mock) {
                $mock->shouldReceive('get')
                    ->once()
                    ->with(1)
                    ->andThrow(new \Exception('Erro interno do servidor'));
            })
        );

        Log::shouldReceive('error')
            ->once()
            ->withArgs(function ($message, $context) {
                return $message === "message: Erro interno do servidor";
            });

        $response = $this->getJson('/api/projects/1');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertJson([
            'message' => 'Erro interno do servidor'
        ]);
    }
}
