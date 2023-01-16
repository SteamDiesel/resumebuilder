<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    //
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
            'description' => ['max:250', 'required'],
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
}
