<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\Project\Contracts\ProjectServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
                    'message' => $exception->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
