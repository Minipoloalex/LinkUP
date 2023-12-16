<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuggestionController extends Controller
{
    static int $pagination = 5;
    public function getUserSuggestions(Request $request)
    {
        $request->validate(['page' => 'required|int']);
        $page = $request->input('page');

        $user = auth()->user()->id;

        $suggestions = $this->getSuggestions($user, $page);
        $suggestions = $suggestions->forPage($page + 1, 2 * self::$pagination)->values();
        dd($suggestions);

        $suggestions = $this->translateSuggestionsArrayToHtml($suggestions);

        return response()->json(['suggestions' => $suggestions]);
    }

    private function getSuggestions(int $user, int $page)
    {
        // Users that my 'following' follow
        $usersSuggestions = DB::table('follows')
            ->select('id_followed')->whereIn('id_user', function ($query) use ($user) {
                $query->select('id_followed')->from('follows')->where('id_user', $user);
            })->whereNotIn('id_followed', function ($query) use ($user) {
                $query->select('id_followed')->from('follows')->where('id_user', $user);
            })->distinct()->skip($page * self::$pagination)->take(self::$pagination)->get()->pluck('id_followed');

        foreach ($usersSuggestions as $key => $value) {
            $usersSuggestions[$key] = DB::table('users')->where('id', $value)->first();
        }

        // Groups that my 'following' belong to (and I don't)
        $groupsSuggestions = DB::table('group_member')
            ->select('id_group')->whereIn('id_user', function ($query) use ($user) {
                $query->select('id_followed')->from('follows')->where('id_user', $user);
            })->whereNotIn('id_group', function ($query) use ($user) {
                $query->select('id_group')->from('group_member')->where('id_user', $user);
            })->distinct()->skip($page * self::$pagination)->take(self::$pagination)->get()->pluck('id_group');

        foreach ($groupsSuggestions as $key => $value) {
            $groupsSuggestions[$key] = DB::table('groups')->where('id', $value)->first();
        }

        $suggestions = $usersSuggestions->merge($groupsSuggestions);
        return $suggestions;
    }
}
