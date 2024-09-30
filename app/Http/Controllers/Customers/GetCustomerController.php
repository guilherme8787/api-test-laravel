<?php

namespace App\Http\Controllers\Customers;

use App\Exceptions\NotFoundCustomerException;
use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerService;
use Exception;
use Illuminate\Http\Response;

class GetCustomerController extends Controller
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
            $customer = $this->customerService->find($id);

            return response()->json($customer, Response::HTTP_CREATED);
        } catch (NotFoundCustomerException $customerException) {
            return response()->json(
                [
                    'message' => $customerException->getMessage()
                ],
                Response::HTTP_NOT_FOUND
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
