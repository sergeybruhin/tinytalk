<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $user = User::find(Auth::user()->id);
        $profiles = Profile::where('user_id', Auth::user()->id)->get();
        return view('admin.resources.profiles')
            ->with(compact('profiles'))
            ->with(compact('user'));
    }

    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $user = User::find(Auth::user()->id);
        $profile = Profile::findOrFail($id);
        return view('admin.pages.profile.master')
            ->with(compact('profile'))
            ->with(compact('user'));
    }
}
