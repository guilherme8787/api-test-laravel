<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
