<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *     path="/api/customers",
 *     summary="Listar todos os clientes",
 *     description="Retorna uma lista de todos os clientes cadastrados",
 *     tags={"Clientes"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de clientes",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1, description="ID do cliente"),
 *                 @OA\Property(property="nome", type="string", example="João Silva", description="Nome do cliente"),
 *                 @OA\Property(property="email", type="string", example="joao.silva@example.com", description="E-mail do cliente"),
 *                 @OA\Property(property="telefone", type="string", example="(11) 99999-9999", description="Telefone do cliente"),
 *                 @OA\Property(property="cpf", type="string", example="123.456.789-00", description="CPF do cliente"),
 *                 @OA\Property(property="cnpj", type="string", example="12.345.678/0001-99", description="CNPJ do cliente")
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
class GetAllCustomersController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private CustomerServiceContract $customerService)
    {
    }

    public function __invoke()
    {
        try {
            $customers = $this->customerService->all();

            return response()->json($customers, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error("message: {$e->getMessage()}", [
                'exception' => $e
            ]);

            return response()->json(
                [
                    'message' => $e->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
