<?php

namespace App\Http\Controllers\Customers;

use App\Exceptions\NotFoundCustomerException;
use App\Http\Controllers\Controller;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *     path="/api/customers/{id}",
 *     summary="Obter detalhes de um cliente",
 *     description="Retorna os detalhes de um cliente específico pelo ID",
 *     tags={"Clientes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do cliente que deseja obter",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Detalhes do cliente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1, description="ID do cliente"),
 *             @OA\Property(property="nome", type="string", example="João Silva", description="Nome do cliente"),
 *             @OA\Property(property="email", type="string", example="joao.silva@example.com", description="E-mail do cliente"),
 *             @OA\Property(property="telefone", type="string", example="(11) 99999-9999", description="Telefone do cliente"),
 *             @OA\Property(property="cpf", type="string", example="123.456.789-00", description="CPF do cliente"),
 *             @OA\Property(property="cnpj", type="string", example="12.345.678/0001-99", description="CNPJ do cliente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Cliente não encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Cliente não encontrado")
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
class GetCustomerController extends Controller
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
            $customer = $this->customerService->find($id);

            return response()->json($customer, Response::HTTP_OK);
        } catch (NotFoundCustomerException $customerException) {
            return response()->json(
                [
                    'message' => $customerException->getMessage()
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
