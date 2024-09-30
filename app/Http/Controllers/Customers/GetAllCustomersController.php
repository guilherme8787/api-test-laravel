<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class GetAllCustomersController extends Controller
{
    /**
     * Class constructor
     */
    public function __construct(private CustomerService $customerService)
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
