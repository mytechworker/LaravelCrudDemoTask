<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $employees = Employee::all()->toArray();
            return array_reverse($employees);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the employees'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'job_title' => 'required|string|max:255',
                'salary' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            ]);

            $input = $request->all();

            Employee::create($input);

            return response()->json(['success' => 'Employee created successfully']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the employee'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $employeeId
     * @return \Illuminate\Http\Response
     */
    public function edit($employeeId)
    {
        $employee = Employee::find($employeeId);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $employeeId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($employeeId, Request $request)
    {
        try {
            $employee = Employee::find($employeeId);

            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'job_title' => 'required|string|max:255',
                'salary' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            ]);

            $input = $request->all();
            $employee->update($input);
            return response()->json(['success' => 'Employee update successfully']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the employee'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $employeeId
     * @return \Illuminate\Http\Response
     */
    public function delete($employeeId)
    {
        try {
            $employee = Employee::find($employeeId);

            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $employee->delete();
            return response()->json(['success' => 'Employee deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete employee'], 500);
        }
    }
}
