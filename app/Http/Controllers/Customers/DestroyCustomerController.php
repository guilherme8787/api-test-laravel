<?php

namespace App\Http\Controllers\Customers;

use App\Exceptions\NotFoundCustomerException;
use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerService;
use Exception;
use Illuminate\Http\Response;

class DestroyCustomerController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private CustomerService $customerService)
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
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return response()->json(
                [
                    'message' => $exception->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
