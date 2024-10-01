<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\Project\Contracts\ProjectServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Delete(
 *     path="/api/projects/{id}",
 *     summary="Remover um projeto",
 *     description="Remove um projeto específico pelo ID",
 *     tags={"Projetos"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do projeto que deseja remover",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=202,
 *         description="Projeto removido com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Projeto removido com sucesso."),
 *             @OA\Property(property="project", type="object", description="Informações do projeto removido")
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
class DestroyProjectController extends Controller
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
            $project = $this->projectService->delete($id);

            return response()->json(
                [
                    'message' => 'Projeto removido com sucesso.',
                    'project' => $project
                ],
                Response::HTTP_ACCEPTED
            );
        } catch (Exception $exception) {
            Log::error("message: {$exception->getMessage()}", [
                'exception' => $exception
            ]);

            return response()->json(
                [
                    'message' => 'Erro interno do servidor'
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
