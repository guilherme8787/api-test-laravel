<?php

namespace App\Http\Controllers\Projects;

use App\Exceptions\NotFoundInstallTypeException;
use App\Exceptions\NotFoundLocaleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Services\Project\Contracts\ProjectServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Put(
 *     path="/api/projects",
 *     summary="Atualiza um projeto de energia solar",
 *     description="Atualização de um projeto já existente, incluindo cliente, localização e equipamentos",
 *     tags={"Projetos"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"cliente_id", "nome", "uf", "tipo_instalacao"},
 *             @OA\Property(property="cliente_id", type="integer", example=1, description="ID do cliente associado ao projeto"),
 *             @OA\Property(property="nome", type="string", example="Projeto Solar João", description="Nome do projeto"),
 *             @OA\Property(property="uf", type="string", example="SP", description="Unidade Federativa onde o projeto está localizado"),
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
 *         response=201,
 *         description="Projeto criado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Cliente criado com sucesso."),
 *             @OA\Property(property="project", type="object", description="Detalhes do projeto criado")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Dados inválidos fornecidos",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Os dados fornecidos são inválidos."),
 *             @OA\Property(property="errors", type="object", description="Detalhes dos erros de validação")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Erro interno do servidor.")
 *         )
 *     )
 * )
 */
class UpdateProjectController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private ProjectServiceContract $projectService)
    {
    }

    public function __invoke(ProjectRequest $request, int $id)
    {
        try {
            $data = $request->validated();

            $project = $this->projectService->update($data, $id);

            return response()->json(
                [
                    'message' => 'Projeto criado com sucesso.',
                    'project' => $project
                ],
                Response::HTTP_CREATED
            );
        } catch (ValidationException $validationException) {
            return response()->json(
                [
                    'message' => 'Os dados fornecidos são inválidos.',
                    'errors' => $validationException->errors()
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (NotFoundLocaleException $notFoundLocaleException) {
            return response()->json(
                [
                    'message' => $notFoundLocaleException->getMessage()
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (NotFoundInstallTypeException $notFoundInstallTypeException) {
            return response()->json(
                [
                    'message' => $notFoundInstallTypeException->getMessage()
                ],
                Response::HTTP_NOT_FOUND
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
