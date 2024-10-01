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

class NewProjectControllerTest extends TestCase
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
            'nome' => 'Projeto Solar',
            'uf' => 'SP',
            'tipo_instalacao' => 'Metálico',
            'equipamentos' => [
                [
                    'equipamento_id' => 1,
                    'quantidade' => 2
                ]
            ]
        ];
    }

    public function testSuccessfullCreateProject()
    {
        $data = $this->mountedProjectReturn();

        Equipamento::factory()->create();
        Cliente::factory()->create();
        TipoInstalacao::factory()->create();
        Localizacao::factory()->create();

        $this->instance(
            ProjectServiceContract::class,
            Mockery::mock(ProjectServiceContract::class, function (MockInterface $mock) use ($data) {
                $mock->shouldReceive('create')
                    ->once()
                    ->with($data)
                    ->andReturn(new Projeto($this->mountedProjectReturn()));
            })
        );

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
                "message" => "Projeto criado com sucesso.",
                "project" => [
                    'cliente_id' => 1,
                    'nome' => 'Projeto Solar',
                ]
            ]
        );
    }

    public function testErroWithClientNotExists()
    {
        $data = $this->mountedProjectReturn();

        Equipamento::factory()->create();
        TipoInstalacao::factory()->create();
        Localizacao::factory()->create();

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'message' => 'O cliente informado não existe.',
            'errors' => [
                'cliente_id' => ['O cliente informado não existe.']
            ]
        ]);
    }

    public function testErrorWithEquipNotExists()
    {
        $data = $this->mountedProjectReturn();

        Cliente::factory()->create();
        TipoInstalacao::factory()->create();
        Localizacao::factory()->create();

        $data['equipamentos'] = [
            [
                'equipamento_id' => $this->faker()->randomDigitNotNull,
                'quantidade' => $this->faker()->randomDigitNotNull
            ]
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'message' => 'O equipamento informado não existe.',
            'errors' => [
                'equipamentos.0.equipamento_id' => ['O equipamento informado não existe.']
            ]
        ]);
    }

    public function testErrorWithCustomerAndEquipNotExists()
    {
        $data = $this->mountedProjectReturn();

        TipoInstalacao::factory()->create();
        Localizacao::factory()->create();

        $data['equipamentos'] = [
            [
                'equipamento_id' => $this->faker()->randomDigitNotNull,
                'quantidade' => $this->faker()->randomDigitNotNull
            ]
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'message' => 'O cliente informado não existe. (and 1 more error)',
            'errors' => [
                'cliente_id' => ['O cliente informado não existe.'],
                'equipamentos.0.equipamento_id' => ['O equipamento informado não existe.']
            ]
        ]);
    }

    public function testErrorWithNotValidInstallationType()
    {
        $data = $this->mountedProjectReturn();

        Cliente::factory()->create();
        Equipamento::factory()->create();
        Localizacao::factory()->create();

        $data['tipo_instalacao'] = 'Tipo Inválido';

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'message' => 'O tipo de instalação deve ser um dos valores permitidos.',
            'errors' => [
                'tipo_instalacao' => ['O tipo de instalação deve ser um dos valores permitidos.']
            ]
        ]);
    }

    public function testErrorWithNotValidLocation()
    {
        $data = $this->mountedProjectReturn();

        Equipamento::factory()->create();
        Cliente::factory()->create();
        TipoInstalacao::factory()->create();
        Localizacao::factory()->create();

        $data['uf'] = 'OK';
        $data['tipo_instalacao'] = self::VALID_INSTALLATION_TYPE;

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'message' => 'O campo UF deve ser um estado brasileiro válido.',
            'errors' => [
                'uf' => ['O campo UF deve ser um estado brasileiro válido.']
            ]
        ]);
    }

    public function testErrorWithValidLocationRequestButNotInDb()
    {
        $data = $this->mountedProjectReturn();

        Equipamento::factory()->create();
        Cliente::factory()->create();
        TipoInstalacao::factory()->valid()->create();
        Localizacao::factory()->create();

        $data['uf'] = 'RJ';
        $data['tipo_instalacao'] = self::VALID_INSTALLATION_TYPE;

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'message' => 'Localização não encontrada.',
        ]);
    }
}
