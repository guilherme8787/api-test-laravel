<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\Project\Contracts\ProjectServiceContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *     path="/api/projects",
 *     summary="Listar todos os projetos",
 *     description="Retorna uma lista de projetos, com a possibilidade de aplicar filtros por cliente, localização, tipo de instalação e nome.",
 *     tags={"Projetos"},
 *     @OA\Parameter(
 *         name="cliente_id",
 *         in="query",
 *         description="ID do cliente para filtrar projetos",
 *         required=false,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="uf",
 *         in="query",
 *         description="Unidade Federativa (UF) para filtrar projetos",
 *         required=false,
 *         @OA\Schema(type="string", example="SP")
 *     ),
 *     @OA\Parameter(
 *         name="tipo_instalacao",
 *         in="query",
 *         description="Tipo de instalação para filtrar projetos",
 *         required=false,
 *         @OA\Schema(type="string", example="Laje")
 *     ),
 *     @OA\Parameter(
 *         name="nome",
 *         in="query",
 *         description="Nome do projeto para busca parcial",
 *         required=false,
 *         @OA\Schema(type="string", example="Solar")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de projetos",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1, description="ID do projeto"),
 *                 @OA\Property(property="cliente_id", type="integer", example=1, description="ID do cliente associado"),
 *                 @OA\Property(property="nome", type="string", example="Projeto Solar João", description="Nome do projeto"),
 *                 @OA\Property(property="uf", type="string", example="SP", description="Unidade Federativa do projeto"),
 *                 @OA\Property(property="tipo_instalacao", type="string", example="Laje", description="Tipo de instalação"),
 *                 @OA\Property(
 *                     property="equipamentos",
 *                     type="array",
 *                     @OA\Items(
 *                         @OA\Property(property="equipamento_id", type="integer", example=1, description="ID do equipamento"),
 *                         @OA\Property(property="quantidade", type="integer", example=5, description="Quantidade do equipamento")
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Erro interno do servidor")
 *         )
 *     )
 * )
 */
class GetAllProjectsController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private ProjectServiceContract $projectService)
    {
    }

    public function __invoke(Request $request)
    {
        try {
            $filters = $request->only([
                'cliente_id',
                'uf',
                'tipo_instalacao',
                'nome'
            ]);

            $projects = $this->projectService->getAll($filters);

            return response()->json(
                $projects,
                Response::HTTP_OK
            );
        } catch (Exception $exception) {
            Log::error("message: {$exception->getMessage()}", [
                'exception' => $exception
            ]);

            return response()->json(
                [
                    'message' => $exception->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
