<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use ModularForms\Controllers\FormController;
use App\Models\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class UserController extends FormController
{

    /**
     * Manage "confirm" OFFLINE user view
     */
    public function confirm_offline_user(): View
    {
        return view('offline.confirm_user', [
            'item' => Auth::user()
        ]);
    }

    /**
     * Manage "update" OFFLINE user
     */
    public function update_offline_user(Request $request): RedirectResponse
    {
        $item = (new User)->find(0);
        $item->fill($request->all());
        if ($item->isDirty()) {
            $item->save();
        }
        return redirect()->route('home');
    }

}
