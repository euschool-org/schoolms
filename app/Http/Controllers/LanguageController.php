<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLanguage(Request $request)
    {
        $request->validate(['language' => 'required|in:en,ge']);
        session(['locale' => $request->language]);
        return redirect()->back();
    }

}
