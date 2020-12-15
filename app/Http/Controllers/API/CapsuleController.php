<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Capsule;
use Illuminate\Http\Request;
use App\Http\Resources\CapsuleCollection;

class CapsuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return new CapsuleCollection(Capsule::with(['missions'])->get());
        // return response()->json(Capsule::with('missions')->get());
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Capsule  $capsule
     * @return \Illuminate\Http\Response
     */
    public function show(Capsule $capsule)
    {
        return response()->json($capsule);
    }

}
