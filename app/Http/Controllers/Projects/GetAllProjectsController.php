<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\Project\Contracts\ProjectServiceContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
