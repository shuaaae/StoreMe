<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Locker;

class LockerController extends Controller
{
    public function index()
    {
        $lockers = Locker::all(); // fetch all lockers from DB
        return view('dashboard', compact('lockers')); // pass to view
    }
}
