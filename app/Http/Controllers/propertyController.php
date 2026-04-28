<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Property;

class propertyController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        return view('properties.index', compact('properties'));
    }
}


