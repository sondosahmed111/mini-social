<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = User::where('name', 'like', "%{$query}%")
                    ->orWhere('username', 'like', "%{$query}%")->get();

        return view('search', compact('users', 'query'));
    }

}
