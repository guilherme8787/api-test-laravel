<?php

namespace App\Http\Controllers\Projects;

use App\Exceptions\NotFoundProjectException;
use App\Http\Controllers\Controller;
use App\Services\Project\Contracts\ProjectServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *     path="/api/projects/{id}",
 *     summary="Obter detalhes de um projeto específico",
 *     description="Retorna os detalhes de um projeto pelo seu ID",
 *     tags={"Projetos"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do projeto que deseja obter",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Detalhes do projeto",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID do projeto"),
 *             @OA\Property(property="cliente_id", type="integer", example=1, description="ID do cliente associado"),
 *             @OA\Property(property="nome", type="string", example="Projeto Solar João", description="Nome do projeto"),
 *             @OA\Property(property="uf", type="string", example="SP", description="Unidade Federativa do projeto"),
 *             @OA\Property(property="tipo_instalacao", type="string", example="Laje", description="Tipo de instalação"),
 *             @OA\Property(
 *                 property="equipamentos",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="equipamento_id", type="integer", example=1, description="ID do equipamento"),
 *                     @OA\Property(property="quantidade", type="integer", example=5, description="Quantidade do equipamento")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Projeto não encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Projeto não encontrado")
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
class GetProjectController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private ProjectServiceContract $projectService)
    {
    }

    public function __invoke(int $id)
    {
        try {
            $project = $this->projectService->get($id);

            return response()->json(
                $project,
                Response::HTTP_OK
            );
        } catch (NotFoundProjectException $notFoundProjectException) {
            return response()->json(
                [
                    'message' => $notFoundProjectException->getMessage()
                ],
                Response::HTTP_NOT_FOUND
            );
        }catch (Exception $exception) {
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
