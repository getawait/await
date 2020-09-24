<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ListsController extends Controller
{
    public function index()
    {
        return Inertia::render('Lists/Index', [
            'list' => auth()->user()->currentLists,
        ]);
    }

    public function create()
    {
        return Inertia::render('Lists/Create');
    }
}
