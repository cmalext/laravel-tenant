<?php

namespace App\Http\Controllers;

use App\Models\Channel;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = Channel::paginate(15);

        return view('channels.index', compact('channels'));
    }
}
