<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
