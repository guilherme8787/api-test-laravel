<?php

namespace App\Http\Controllers\Customers;

use App\Exceptions\NotFoundCustomerException;
use App\Http\Controllers\Controller;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
