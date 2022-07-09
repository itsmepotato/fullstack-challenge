<?php

namespace App\Http\Controllers;

use App\Stage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StageController extends Controller
{
    public function index()
    {
        $stages = Stage::orderBy('order', 'asc')->get();
        return response()->json($stages, Response::HTTP_OK);
    }
}
