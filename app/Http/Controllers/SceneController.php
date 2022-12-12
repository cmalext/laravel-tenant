<?php

namespace App\Http\Controllers;

use App\Models\Scene;

class SceneController extends Controller
{
    public function index()
    {
        $scenes = Scene::paginate(15);

        return view('scenes.index', compact('scenes'));
    }
}
