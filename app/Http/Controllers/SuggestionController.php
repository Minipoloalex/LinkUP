<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function getUserSuggestions(Request $request)
    {
        $request->validate(['page' => 'required|int']);
        $page = $request->input('page');

        $user = auth()->user()->id;

        $suggestions = $this->getSuggestions($user);
        $suggestions = $suggestions->forPage($page + 1, 10)->values();

        $suggestions = $this->translateSuggestionsArrayToHtml($suggestions);

        return response()->json(['suggestions' => $suggestions]);
    }
}
