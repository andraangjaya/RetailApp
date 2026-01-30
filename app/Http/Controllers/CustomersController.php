<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CustomersController extends Controller
{
    public function store(Request $request, CustomerService $customerService)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        $customerService->create($validated);

        return response()->json([
            'message' => 'Customer created successfully',
            'data' => $validated
        ], 201);
    }

    public function show(Customer $customer)
    {
        return $customer;
    }

    public function index(){
        return Customer::all();
    }

    public function update(Request $request, Customer $customer, CustomerService $customerService){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        $customer = $customerService->update($validated, $customer);

        return response()->json([
            'message' => 'Customer updated successfully',
            'updated_customer' => $customer
        ], 201);
    }

    public function destroy(Customer $customer){
        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully',
            'customer_id : ' => $customer->id
        ]);
    }

}
