<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * UserController constructor
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Display a listing of the resource.
    public function index()
    {
        // Try this one also: auth()->user()->can('permission')
        $this->authorize('list: user');  // used to authorize the specific path -- here list 
        return response()->json($this->userService->list());
    }

    // Display the specified resource.
    public function show(User $user)
    {
        $this->authorize('read: user');
        return response()->json($this->userService->get($user->id));
    }

    // Update the specified resource in storage.
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update: user');
        return response()->json($this->userService->modify($request->validated(), $user->id));
    }

    // Remove the specified resource from storage.
    public function destroy(User $user)
    {
        $this->authorize('delete: user');
        return response()->json($this->userService->delete($user->id));
    }
}
