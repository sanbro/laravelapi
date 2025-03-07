<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TimesheetController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $timesheets = Timesheet::all();
            return $this->successResponse($timesheets, 'Timesheets retrieved successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    /**
     * Summary of show
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Timesheet $timesheet)
    {
        try {
            return $this->successResponse($timesheet, 'Timesheet retrieved successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'task_name' => 'required|string|max:255',
                'date' => 'required|date',
                'hours' => 'required|numeric|min:0',
                'user_id' => 'sometimes|exists:users,id',
                'project_id' => 'sometimes|exists:projects,id'
            ]);

            $timesheet = Timesheet::create($validated);
            return $this->successResponse($timesheet, 'Timesheet created successfully', 201);
        } catch (ValidationException $e) {
            return $this->failedResponse('Validation failed', $e->errors(), 422);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Timesheet $timesheet)
    {
        try {
            $validated = $request->validate([
                'task_name' => 'sometimes|string|max:255',
                'date' => 'sometimes|date',
                'hours' => 'sometimes|numeric|min:0',
                'user_id' => 'sometimes|exists:users,id',
                'project_id' => 'sometimes|exists:projects,id'
            ]);

            $timesheet->update($validated);
            return $this->successResponse($timesheet, 'Timesheet updated successfully', 200);
        } catch (ValidationException $e) {
            return $this->failedResponse('Validation failed', $e->errors(), 422);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Summary of destroy
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Timesheet $timesheet)
    {
        try {
            $timesheet->delete();
            return $this->successResponse(null, 'Timesheet deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
