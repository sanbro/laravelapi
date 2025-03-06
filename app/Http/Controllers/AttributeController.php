<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AttributeController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
        try{
            $attributes = Attribute::all();
            return $this->successResponse($attributes,'Attributes retrieved successfully');
        }catch (Exception $e){
            return $this->errorResponse($e->getMessage(),500);
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
            $request->validate([
                'name' => 'required|string|unique:attributes,name',
                'type' => ['required', Rule::in(['text', 'date', 'number', 'select'])]
            ]);
            $attribute = Attribute::create($request->all());
            return $this->successResponse($attribute, 'Attribute created successfully', 201);
        } catch (ValidationException $e) {
            return $this->failedResponse('Validation failed', $e->errors(), 422);
        } catch (Exception $e) {
            return $this->errorResponse('Something went wrong', 500, );
        }
    }

    /**
     * Summary of show
     * @param \App\Models\Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Attribute $attribute)
    {
        try {
            return $this->successResponse($attribute, 'Attribute retrieved successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Something went wrong', 500);
        }
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Attribute $attribute)
    {
        //
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|unique:attributes,name,' . $attribute->id,
                'type' => ['sometimes', Rule::in(['text', 'date', 'number', 'select'])]
            ]);

            $attribute->update($validated);
            return $this->successResponse($attribute, 'Attribute updated successfully');
        } catch (ValidationException $e) {
            return $this->failedResponse('Validation failed', $e->errors(), 422);
        } catch (Exception $e) {
            return $this->errorResponse('Something Went Wrong', 500, );
        }
    }

    /**
     * Summary of destroy
     * @param \App\Models\Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Attribute $attribute)
    {
        try {
            $attribute->delete();
            return $this->successResponse(null, 'Attribute deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Something went wrong', 500);
        }
    }
}
