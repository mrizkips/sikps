<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UserRequest;
use App\Imports\UsersImport;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return view('user.index', [
            'users' => User::with('roles', 'mahasiswa', 'dosen')->get(),
        ]);
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('user.create', [
            'roles' => Role::all(),
        ]);
    }

    public function store(UserRequest $request)
    {
        $userData = $request->safe()->only(['nama', 'username', 'jk', 'email', 'no_hp']);
        $userData['password'] = $request->generateDefaultPassword();

        $user = User::create($userData);

        if ($request->isMahasiswa()) {
            $user->mahasiswa()->create($request->safe()->only(['nama', 'nim', 'jurusan']));
        }

        if ($request->isDosen()) {
            $user->dosen()->create($request->safe()->only(['nama', 'kd_dosen', 'nidn', 'inisial']));
        }

        $user->syncRoles($request->safe()->only('roles'));

        return redirect()->route('users.index')->with([
            'success' => 'Berhasil menambahkan user'
        ]);
    }

    public function edit(User $user)
    {
        return view('user.edit', [
            'user' => $user->load('mahasiswa', 'dosen'),
            'roles' => Role::all(),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->safe()->only(['nama', 'username', 'jk', 'email', 'no_hp']);
        $user->update($data);

        if ($request->isMahasiswa()) {
            Mahasiswa::updateOrCreate(['user_id' => $user->id], $request->safe()->only(['nama', 'nim', 'jurusan']));
        }

        if ($request->isDosen()) {
            Dosen::updateOrCreate(['user_id' => $user->id], $request->safe()->only(['nama', 'kd_dosen', 'nidn', 'inisial']));
        }

        $user->syncRoles($request->safe()->only('roles'));

        return redirect()->route('users.edit', $user)->with([
            'success' => 'Berhasil mengubah user'
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        $data = $request->safe()->only('password');
        $user->update($data);

        return redirect()->route('users.edit', $user)->with([
            'success' => 'Berhasil mengubah password'
        ]);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();

        return redirect('/users')->with([
            'success' => 'Berhasil menghapus user'
        ]);
    }

    public function importDosen(Request $request)
    {
        $this->authorize('create', User::class);

        $this->importValidation($request);

        Excel::import(new UsersImport, $request->file('file'));

        return redirect()->route('users.index')->with([
            'success' => 'Berhasil mengimport data dosen',
        ]);
    }

    public function importValidation(Request $request)
    {
        return $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240'
        ]);
    }
}
