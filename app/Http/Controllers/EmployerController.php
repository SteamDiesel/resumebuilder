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
        $emp = Employer::find($data->id);
        if (Auth::user()->id == $emp->user_id) {
            $emp->description = $data->description;
            $emp->name = $data->name;
            $emp->save();
            return response()->json([
                'employer' => $emp,
                'message' => 'success'
            ], 200);
        }
        return "Failed";
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
        return "Failed";
    }
}
