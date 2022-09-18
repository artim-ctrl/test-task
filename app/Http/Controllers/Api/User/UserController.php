<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexUserRequest $request
     * @return UserCollection
     */
    public function index(IndexUserRequest $request): UserCollection
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

        return UserCollection::make($paginate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $requestData = $request->safe();

        $requestData = $requestData->merge(['password' => Hash::make($request->get('password'))]);
        if (! Auth::user()->isAdmin()) {
            $requestData = $requestData->merge(['role' => 'user']);
        }

        $user = User::create($requestData->toArray());

        event(new Registered($user));

        // TODO: хз как отправлять токен правильно
        return UserResource::make($user)->additional([
            'token' => $user->createToken('MyApp')->plainTextToken,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $requestData = $request->safe();

        if ($request->has('email')) {
            $requestData = $requestData->merge(['email_verified_at' => null]);
        }

        $user->update($requestData->toArray());

        return UserResource::make($user);
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

        return response()->json();
    }
}
