<?php

namespace App\Http\Controllers;

use App\Http\Requests\staffRequest;
use App\Http\Resources\staffResource;
use App\Models\staff;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class staffController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', staff::class);

        return staffResource::collection(staff::all());
    }

    public function store(staffRequest $request)
    {
        $this->authorize('create', staff::class);

        return new staffResource(staff::create($request->validated()));
    }

    public function show(staff $staff)
    {
        $this->authorize('view', $staff);

        return new staffResource($staff);
    }

    public function update(staffRequest $request, staff $staff)
    {
        $this->authorize('update', $staff);

        $staff->update($request->validated());

        return new staffResource($staff);
    }

    public function destroy(staff $staff)
    {
        $this->authorize('delete', $staff);

        $staff->delete();

        return response()->json();
    }
}
