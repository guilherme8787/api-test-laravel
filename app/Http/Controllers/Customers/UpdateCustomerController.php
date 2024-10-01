<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCustomerRequest;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UpdateCustomerController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private CustomerServiceContract $customerService)
    {
    }

    public function __invoke(UpdateCustomerRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $customer = $this->customerService->update($data, $id);

            return response()->json(
                [
                    'message' => 'Cliente atualizado com sucesso.',
                    'customer' => $customer
                ],
                Response::HTTP_ACCEPTED
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
