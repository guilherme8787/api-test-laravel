<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Post(
 *     path="/api/customers",
 *     summary="Criar um novo cliente",
 *     description="Cria um novo cliente e retorna os detalhes do cliente criado",
 *     tags={"Clientes"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"nome", "email", "telefone"},
 *             @OA\Property(property="nome", type="string", example="João Silva", description="Nome do cliente"),
 *             @OA\Property(property="email", type="string", example="joao.silva@example.com", description="E-mail do cliente"),
 *             @OA\Property(property="telefone", type="string", example="(11) 99999-9999", description="Telefone do cliente"),
 *             @OA\Property(property="cpf", type="string", example="123.456.789-00", description="CPF do cliente (opcional)"),
 *             @OA\Property(property="cnpj", type="string", example="12.345.678/0001-99", description="CNPJ do cliente (opcional)")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Cliente criado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Cliente criado com sucesso."),
 *             @OA\Property(property="customer", type="object", description="Detalhes do cliente criado",
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
 *             @OA\Property(property="message", type="string", example="Erro interno do servidor")
 *         )
 *     )
 * )
 */
class NewCustomerController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private CustomerServiceContract $customerService)
    {
    }

    public function __invoke(CustomerRequest $request)
    {
        try {
            $data = $request->validated();
            $customer = $this->customerService->create($data);

            return response()->json(
                [
                    'message' => 'Cliente criado com sucesso.',
                    'customer' => $customer
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
