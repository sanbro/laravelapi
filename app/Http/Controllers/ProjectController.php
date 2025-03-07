<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Project::with('attributes.attribute');
            if ($filters = $request->input('filters')) {
                foreach ($filters as $key => $value) {
                    if (in_array($key, ['name', 'status'])) {
                        $query->where($key, 'LIKE', "%$value%");
                    } else {
                        $attribute = Attribute::where('name', $key)->first();
                        if ($attribute) {
                            $query->whereHas('attributes', function ($q) use ($attribute, $value) {
                                $q->where('attribute_id', $attribute->id)
                                    ->where('value', 'LIKE', "%{$value}%");
                            });
                        }
                    }
                }
            }

            $reponse =  $query->paginate(10);
            return $this->successResponse($reponse, 'Projects retrieved successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    /**
     * Summary of show
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Project $project)
    {
        try {
            $project->with('attributes.attribute');
            return $this->successResponse($project, 'Project retrieved successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Something went wrong', 500);
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
                'name' => 'required|string|unique:projects,name',
                'status' => 'sometimes|string|in:active,completed,on_hold',
                'attributes' => 'sometimes|array',
                'attributes.*.id' => 'required|numeric|exists:attributes,id',
                'attributes.*.value' => 'required|string'
            ]);

            $project = Project::create($request->only(['name', 'status']));

            foreach ($request->input('attributes') as $attribute) {
                $project->attributes()->create([
                    'attribute_id' => $attribute['id'],
                    'value' => $attribute['value']
                ]);
            }

            return $this->successResponse($project, 'Project created successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Project $project)
    {
        try {
            $request->validate([
                'name' => 'sometimes|string|unique:projects,name,' . $project->id,
                'status' => 'sometimes|string|in:active,completed,on_hold',
                'attributes' => 'sometimes|array',
                'attributes.*.id' => 'required|numeric|exists:attributes,id',
                'attributes.*.value' => 'required|string'
            ]);

            // Update project details
            $project->update($request->only(['name', 'status']));

            if ($request->has('attributes')) {
                // $project->attributes()->delete(); // Remove old attributes

                foreach ($request->input('attributes') as $attribute) {
                    $project->attributes()->updateOrCreate(
                        ['attribute_id' => $attribute['id'], 'entity_id' => $project->id],
                        ['attribute_id' => $attribute['id'], 'value' => $attribute['value']]
                    );
                }
            }

            return $this->successResponse($project, 'Project updated successfully');
        } catch (ValidationException $e) {
            return $this->failedResponse('Validation failed', $e->errors(), 422);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Summary of destroy
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return $this->successResponse(null, 'Project deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
