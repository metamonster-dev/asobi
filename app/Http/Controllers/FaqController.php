<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function faq(Request $request)
    {
        $searchText = ($request->input('searchText')) ? $request->input('searchText') : "";

        $data = [
            'search_text' => $searchText,
        ];
//        \App::make('helper')->vardump($searchText);
//        exit;
        $req = Request::create('/api/faq', 'GET', $data);
        $boardController = new BoardController();
        $res = $boardController->faq($req);

        return view('faq/list',[
            'list' => $res->original['list'] ?? [],
            'searchText' => $searchText ?? '',
        ]);
    }
}
