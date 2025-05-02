<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    // Konstruktor tidak menggunakan middleware tambahan
    public function __construct()
    {
        // Kosong, jika memang tidak ingin pakai middleware
    }

    /**
     * Menampilkan daftar user dengan pagination dan fitur pencarian.
     */
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('user.index', compact('users', 'search'));
    }

    /**
     * Menghapus user.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->is_admin) {
            return redirect()->route('user.index')->with('error', 'You do not have permission to delete a user.');
        }

        // Cegah hapus super admin
        if ($user->id === 1) {
            return redirect()->route('user.index')->with('danger', 'Cannot delete the super admin.');
        }

        // Cegah admin hapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('user.index')->with('danger', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Menjadikan user sebagai admin.
     */
    public function makeAdmin(User $user): RedirectResponse
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('user.index')->with('error', 'You do not have permission to perform this action.');
        }

        $user->is_admin = true;
        $user->timestamps = false;
        $user->save();

        return back()->with('success', 'User berhasil dijadikan admin.');
    }

    /**
     * Menghapus status admin dari user.
     */
    public function removeAdmin(User $user): RedirectResponse
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('user.index')->with('error', 'You do not have permission to perform this action.');
        }

        // Cegah cabut admin dari diri sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot remove admin status from yourself.');
        }

        // Cegah cabut admin dari super admin
        if ($user->id === 1) {
            return back()->with('error', 'You cannot remove admin status from the super admin.');
        }

        $user->is_admin = false;
        $user->timestamps = false;
        $user->save();

        return back()->with('success', 'Status admin user berhasil dihapus.');
    }
}
