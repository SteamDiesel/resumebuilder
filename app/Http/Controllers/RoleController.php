<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Paragraph;
use App\Models\Role;
use Carbon\Carbon;
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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'id' => ['integer']
        ]);
        $user_id = Auth::id();
        //  check that the employer belongs to the auth user
        $emp = Employer::find($request->id);
        if ($emp->user_id !== $user_id) {
            return response()->json([
                'message' => 'Not Authorized'
            ], 401);
        }
        $role = new Role([
            'title' => 'New Role',
            'start' => now(),
            'end' => null
        ]);
        $role->employer_id = $request->id;
        $role->user_id = $user_id;
        $role->save();

        $p = new Paragraph(['body'=>'']);
        $p->user_id = $user_id;
        $p->role_id = $role->id;
        $p->save();
        $role->paragraphs;

        return response()->json([
            'role' => $role,
            'message' => 'Success'
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'title' => ['string']
        ]);
        $data = (object) $request->role;

        if (Auth::user()->id == $role->user_id) {

            $role->title = $data->title;
            $role->start = $data->start;
            $role->end = $data->end;

            $role->save();
            return response()->json([
                'role' => $role,
                'message' => 'success'
            ], 200);
        }

        return response()->json([
            'message' => 'Failed'
        ], 500);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {

        if (Auth::user()->id == $role->user_id) {
            $role->paragraphs()->delete();
            $role->delete();
            return response()->json([
                'message' => 'Role and Paragraphs Deleted'
            ], 200);
        }

        return response()->json([
            'message' => 'The role was not deleted'
        ], 500);
    }
}
