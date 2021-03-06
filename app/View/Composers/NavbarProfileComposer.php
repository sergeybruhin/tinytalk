<?php

namespace App\View\Composers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NavbarProfileComposer
{

    /**
     * @var Profile|null
     */
    protected ?Profile $selectedProfile = null;

    /**
     * NavbarComposer constructor.
     */
    public function __construct(Request $request)
    {
        if ($request->session()->has('profile_id')) {
            $this->selectedProfile = Profile::find($request->session()->get('profile_id'));
        }

    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('selectedProfile', $this->selectedProfile);
    }
}
