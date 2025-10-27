<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Anggota;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // 2. Validasi tambahan untuk data anggota
        $request->validate([
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
        ]);

        // 3. Simpan atau Perbarui data anggota
        // 'updateOrCreate' akan mencari anggota dengan user_id ini,
        // jika tidak ada, akan membuat data baru.
        Anggota::updateOrCreate(
            ['user_id' => $request->user()->id], // Kunci untuk mencari
            [
                'nama' => $request->user()->name, // Ambil nama dari data user
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'tanggal_daftar' => now() // Set tanggal daftar jika ini data baru
            ]
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
