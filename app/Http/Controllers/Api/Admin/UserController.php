<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * GET - Users სია
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::with('roles')->paginate(15));
    }

    /**
     * POST - User-ის შექმნა
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);

        return new UserResource($user->load('roles'));
    }

    /**
     * GET - User-ის დეტალი
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user->load('roles'));
    }

    /**
     * PUT - User-ის განახლება
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        // ვიღებთ მხოლოდ იმ მონაცემებს, რაც გჭირდება (პაროლის გარეშე)
        $data = $request->only(['name', 'email']);

        // ვამოწმებთ, მოვიდა თუ არა პაროლი რექვესთში
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // როლის სინქრონიზაცია
        if ($request->has('role')) {
            $user->syncRoles([$request->role]);
        }

        return new UserResource($user->load('roles'));
    }

    /**
     * DELETE - User-ის წაშლა
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }

    /**
     * PATCH - პაროლის შეცვლა
     */
    public function updatePassword(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);
        $user->update(['password' => Hash::make($request->password)]);
        return response()->json(['success' => true]);
    }
}
