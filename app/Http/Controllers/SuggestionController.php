<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Group;

class SuggestionController extends Controller
{
    static int $pagination = 5;
    public function getUserSuggestions(Request $request)
    {
        $request->validate(['page' => 'required|int']);
        $page = $request->input('page');

        $user = auth()->user()->id;

        $suggestions = $this->getSuggestions($user, $page)->shuffle()->values();

        $suggestions = $this->translateSuggestionsArrayToHtml($suggestions);

        return response()->json(['suggestions' => $suggestions]);
    }

    private function translateSuggestionsArrayToHtml($suggestions)
    {
        return $suggestions->map(function ($suggestion) {
            if ($suggestion->type == 'group') {
                return view('partials.suggestion.group', ['group' => $suggestion])->render();
            } else {
                return view('partials.suggestion.user', ['user' => $suggestion])->render();
            }
        });
    }

    private function getSuggestions(int $user, int $page)
    {
        // Users that my 'following' follow
        $usersSuggestions = DB::table('follows')
            ->select('id_followed')->whereIn('id_user', function ($query) use ($user) {
                $query->select('id_followed')->from('follows')->where('id_user', $user);
            })->whereNotIn('id_followed', function ($query) use ($user) {
                $query->select('id_followed')->from('follows')->where('id_user', $user);
            })->where('id_followed', '!=', $user)->distinct()->orderBy('id_followed')
            ->skip($page * self::$pagination)->limit(self::$pagination)->get()->pluck('id_followed');

        // If there are no users that my 'following' follow, get users that I don't follow
        if ($usersSuggestions->isEmpty()) {
            $usersSuggestions = DB::table('users')->where('id', '!=', $user)->orderBy('id')
                ->skip($page * self::$pagination)->limit(self::$pagination)->get()->pluck('id');
        }

        foreach ($usersSuggestions as $key => $value) {
            $usersSuggestions[$key] = DB::table('users')->where('id', $value)->first();
            $usersSuggestions[$key]->type = 'user';
        }

        // Groups that my 'following' belong to (and I don't)
        $groupsSuggestions = DB::table('group_member')
            ->select('id_group')->whereIn('id_user', function ($query) use ($user) {
                $query->select('id_followed')->from('follows')->where('id_user', $user);
            })->whereNotIn('id_group', function ($query) use ($user) {
                $query->select('id_group')->from('group_member')->where('id_user', $user);
            })->distinct()->orderBy('id_group')
            ->skip($page * self::$pagination)->limit(self::$pagination)->get()->pluck('id_group');

        // If there are no groups that my 'following' belong to, get groups that I don't belong to
        if ($groupsSuggestions->isEmpty()) {
            $groupsSuggestions = DB::table('groups')->where('id', '!=', $user)->orderBy('id')
                ->skip($page * self::$pagination)->limit(self::$pagination)->get()->pluck('id');
        }

        foreach ($groupsSuggestions as $key => $value) {
            $groupsSuggestions[$key] = DB::table('groups')->where('id', $value)->first();
            $groupsSuggestions[$key]->type = 'group';
        }

        $suggestions = $usersSuggestions->merge($groupsSuggestions);
        return $suggestions;
    }
}
