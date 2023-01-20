<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $emp = new Employer([
            'name' => 'New Employer',
            'description' => '',
            'start' => null,
            'end' => null,
            'current' => false
        ]);
        $emp->user_id = Auth::user()->id;
        $emp->save();
        $emp->roles = [];
        return response()->json([
            'employer' => $emp,
            'message' => 'success'
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employer $employer)
    {
        $request->validate([
            'name' => ['max:100', 'required'],
            'description' => ['max:1200'],
            'current' => 'boolean',
            'start' => 'date',
            'end' => 'date',
        ]);
        $data = (object) $request->emp;

        if (Auth::user()->id == $employer->user_id) {
            $employer->description = $data->description;
            $employer->name = $data->name;
            $employer->start = $data->start;
            $employer->end = $data->end;
            $employer->save();

            return response()->json([
                'employer' => $employer,
                'message' => 'success'
            ], 200);
        }
        return response()->json([

            'message' => 'Not Authorized'
        ], 401);
    }
    /**
     * delete the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function delete(Employer $employer)
    {
        if (Auth::user()->id == $employer->user_id) {
            $employer->roles()->delete();
            $employer->delete();
            return response()->json([
                'message' => 'success'
            ], 200);
        }
        return response()->json([
            'message' => 'Not Authorized'
        ], 401);
    }
}
