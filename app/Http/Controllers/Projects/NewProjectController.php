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

class NewProjectController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private ProjectServiceContract $projectService)
    {
    }

    public function __invoke(ProjectRequest $request)
    {
        try {
            $data = $request->validated();

            $project = $this->projectService->create($data);

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
