<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Delete(
 *     path="/api/customers/{id}",
 *     summary="Remover um cliente",
 *     description="Remove um cliente específico pelo ID",
 *     tags={"Clientes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do cliente que deseja remover",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=202,
 *         description="Cliente removido com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Cliente removido com sucesso."),
 *             @OA\Property(property="customer", type="object", description="Informações do cliente removido")
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
class DestroyCustomerController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private CustomerServiceContract $customerService)
    {
    }

    public function __invoke(int $id)
    {
        try {
            $customer = $this->customerService->delete($id);

            return response()->json(
                [
                    'message' => 'Cliente removido com sucesso.',
                    'customer' => $customer
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
