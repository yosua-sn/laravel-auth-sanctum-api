<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validations = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'bio' => 'nullable|max:250',
        ], [
            //your custom messages
            // 'first_name.required' => 'your message'
        ]);

        $user = Auth::user();

        if ($user->profiles) {
            return response()->json([
                'message' => 'Profile already exists.'
            ], 409);
        }

        $profile = $user->profiles()->create($validations);

        return response()->json([
            'message' => 'Your profile creation was successful.',
            'profile' => $profile
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
       return $profile;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        Gate::authorize('update', $profile);

        $validations = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'bio' => 'nullable|max:250',
        ]);

        $profile->update($validations);

        return response()->json([
            'message' => 'Update successfully.'
        ], 200);
    }
}
