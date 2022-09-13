<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ResourceTrait;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResourceTrait;

    /**
     * Display a listing of the resource.
     *
     * @param IndexUserRequest $request
     * @return JsonResponse
     */
    public function index(IndexUserRequest $request): JsonResponse
    {
        $query = User::query();
        if ($request->has('search.name')) {
            $query->where('name', 'like', '%' . $request->input('search.name') . '%');
        }

        if ($request->has('search.email')) {
            $query->where('email', $request->input('search.email'));
        }

        if ($request->has('search.role')) {
            $query->where('role', $request->input('search.role'));
        }

        $paginate = $query->paginate($request->input('limit'));

        return response()->json([
            'status' => 'success',
            'data' => $paginate->all(),
            'meta' => $this->getPaginationInfo($paginate),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $requestData = $request->safe();

        $requestData->merge(['password' => Hash::make($request->get('password'))]);
        if (! Auth::user()->isAdmin()) {
            $requestData = $requestData->merge(['role' => 'user']);
        }

        $user = User::create($requestData->toArray());

        $requestData = $requestData->merge(['token' => $user->createToken('MyApp')->plainTextToken]);

        event(new Registered($user));

        return response()->json([
            'status' => 'success',
            'data' => $requestData->toArray(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $requestData = $request->safe();

        if ($request->has('email')) {
            $requestData = $requestData->merge(['email_verified_at' => null]);
        }

        $user->update($requestData->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
