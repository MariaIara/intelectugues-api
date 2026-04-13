<?php

namespace App\Http\Controllers;

use App\Adapters\internalDictionary;
use App\Http\Requests\WordsCreateRequest;
use App\Interfaces\DictionaryInterface;
use App\Models\Word;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordsController extends Controller
{
    protected DictionaryInterface $api;
    protected AchievementService $achievementService;

    public function __construct()
    {
        $this->api = new internalDictionary();
        $this->achievementService = new AchievementService();
    }

    public function index()
    {
        return response()->json(['data' => Word::paginate(10)]);
    }

    public function info(Request $request)
    {
        return response()->json(['data' => Word::find($request->id)]);
    }

    public function dailyWord()
    {
        $word = $this->api->getDailyWord();

        return response()->json([
            'data' => $word
        ]);
    }

    public function create(WordsCreateRequest $request)
    {
        $word = Word::create($request->validated());

        return response()->json([
            'data' => $word
        ]);
    }

    public function favorite(Request $request)
    {
        $word = Word::findOrFail($request->id);

        $user = Auth::user();
        $toggle_fav = $word->users()->toggle($user->id);

        $favorited = empty($toggle_fav['detached']);

        if ($favorited) {
            $this->achievementService->checkFavoriteWords($user);
        }

        return response()->json([
            'message' => $favorited ? 'Word favorited successfully.' : 'Word unfavorited successfully.'
        ]);
    }

    public function delete(Request $request)
    {
        $word = Word::find($request->id);

        $word->delete();

        return response()->json([
            'message' => 'Word deleted successfully.'
        ]);
    }
}
