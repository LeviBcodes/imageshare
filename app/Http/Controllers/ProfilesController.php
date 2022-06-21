<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile.index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
        $this->authorize('update', $user->profile);

        return view('profile.edit', compact('user',));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Profile $profile)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'location' => 'required',
            'profile_image' => '',
            'background_image' => '',
            'about' => 'required',
            'linkedin_url' => 'required|url',
            'twitter_url' => 'required|url',
        ]);

        if (request('profile_image')) {
            $imagePath = request('profile_image')->store('profile', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $pImageArray = ['profile_image' => $imagePath];
        }

        if(request('background_image')) {
            $bgImagePath = request('background_image')->store('profile', 'public');
            $bgImage = Image::make(public_path("storage/{$bgImagePath}"))->fit(1000, 2000);
            $bgImage->save();

            $bgImageArray = ['background_image' => $bgImagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $pImageArray ?? [],
            $bgImageArray ?? [],
        ));

        return redirect("/profile/{$user->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user->profile);
        $user->profile->delete();

        return redirect('/')->with('success', 'Profile deleted');
    }
}
