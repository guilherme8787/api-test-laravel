<?php

namespace App\Http\Controllers\Projects;

use App\Exceptions\NotFoundProjectException;
use App\Http\Controllers\Controller;
use App\Services\Project\Contracts\ProjectServiceContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
