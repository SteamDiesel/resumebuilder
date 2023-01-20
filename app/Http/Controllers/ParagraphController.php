<?php

namespace App\Http\Controllers;

use App\Models\Paragraph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParagraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = (object) $request->paragraph;

        if($data->body){
            $p = new Paragraph([
                'body' => $data->body
            ]);
        } else {
            $p = new Paragraph([
                'body' => ''
            ]);
        }
        $p->user_id = Auth::id();
        $p->role_id = $data->role_id;
        $p->save();
        return response()->json([
            'paragraph' => $p,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function show(Paragraph $paragraph)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function edit(Paragraph $paragraph)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paragraph $paragraph)
    {
        //
        if($paragraph->user_id == Auth::id()){
            $paragraph->body = $request->body;
            $paragraph->save();
            return response()->json([
                'paragraph' => $paragraph,
                'message' => 'Success'
            ], 200);
        }
        return response()->json([
            'message' => 'Not Authorized'
        ], 401);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paragraph $paragraph)
    {
        //
        if ($paragraph->user_id == Auth::id()) {
            $paragraph->delete();
            return response()->json([
                'message' => 'Success'
            ], 200);
        }
        return response()->json([
            'message' => 'Not Authorized'
        ], 401);
    }
}
