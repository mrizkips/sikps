<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $this->authorize('update', auth()->user());

        return view('profile.edit');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        $request->user()->save();

        return redirect()->route('profile.edit')->with([
            'success' => 'Berhasil mengubah profil'
        ]);
    }
}
