<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }


    /**
     * Get All Customer
     * @OA\Get (
     *     path="/api/customer",
     *     tags={"Customer"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *
     *     ),
     *     security={{"api_key":{}}},
     * )
     */
    public function index()
    {
        try {
            return $this->customerService->getAllCustomers();

        }catch (\Exception $e) {
            \Log::error('CustomersController(delete) '.  $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Create Customer
     * @OA\Post (
     *     path="/api/customer",
     *     tags={"Customer"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *
     *                      @OA\Property(
     *                          property="first_name",
     *                          type="text"
     *                      ),
     *                      @OA\Property(
     *                          property="last_name",
     *                          type="text"
     *                      ),
     *                      @OA\Property(
     *                          property="age",
     *                          type="text"
     *                      ),
     *                      @OA\Property(
     *                          property="dob",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="text"
     *                      ),
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      ),
     *     security={{"api_key":{}}},
     * )
     */

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'age' => 'required',
                'dob' => 'required',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {

                return response($validator->messages(), 200);

            } else {

                $data = $request->only(['first_name', 'last_name', 'age', 'dob', 'email']);

                return $this->customerService->storeCustomer($data);

            }

        }catch (\Exception $e){
            \Log::error('CustomersController(store) '.  $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Get Detail Customer
     * @OA\Get (
     *     path="/api/customer/{id}",
     *     tags={"Customer"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *
     *     ),
     *     security={{"api_key":{}}},
     * )
     */
    public function show($customer)
    {
        try {
            return $this->customerService->showCustomer($customer);

        }catch (\Exception $e){
            \Log::error('CustomersController(show) '.  $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update Customer
     * @OA\Put (
     *     path="/api/customer/{id}",
     *     tags={"Customer"},
     *
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="first_name",
     *                    type="text"
     *                   ),
     *                      @OA\Property(
     *                          property="last_name",
     *                          type="text"
     *                      ),
     *                      @OA\Property(
     *                          property="age",
     *                          type="text"
     *                      ),
     *                      @OA\Property(
     *                          property="dob",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="text"
     *                      ),
     *          )
     *      )
     *  ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *
     *      ),
     *     security={{"api_key":{}}},
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'age' => 'required',
                'dob' => 'required',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {

                return response($validator->messages(), 200);

            } else {

            $data = $request->only(['first_name', 'last_name', 'age', 'dob', 'email']);

            return $this->customerService->updateCustomer($id, $data);

            }
        }catch (\Exception $e){
            \Log::error('CustomersController(update) '.  $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update Customer
     * @OA\Delete(
     *     path="/api/customer/{id}",
     *     tags={"Customer"},
     *
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *
     *      ),
     *     security={{"api_key":{}}},
     * )
     */
    public function destroy($id)
    {
        try {
            $this->customerService->deleteCustomer($id);

            return response()->json('success', 200);
        }catch (\Exception $e) {
            \Log::error('CustomersController(delete) '.  $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
