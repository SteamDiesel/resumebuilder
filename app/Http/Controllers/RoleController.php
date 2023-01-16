<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    //

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\  $badge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => ['string']
        ]);
        $data = (object) $request->role;

        $role = Role::find($data->id);
        if (Auth::user()->id == $role->user_id) {
            $role->description = $data->description;
            $role->title = $data->title;
            $role->start = $data->start;
            $role->end = $data->end;

            $role->save();
            return response()->json([
                'role' => $role,
                'message' => 'success'
            ], 200);
        }

        return "Failed";
    }
}
