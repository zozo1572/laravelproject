<?php

namespace App\Http\Controllers;

use App\Models\Expert;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function Search(Request $request)

    {
      $search=Expert::query()->select('name','experience');
      $colms=['name','experience','info'];
      foreach($colms as $colm){
        $search->orWhere($colm,'like','%'.$request->value.'%');
      }
      if($search->count()){
        $expert=$search->get();
        return response()->json([
            'Search Result'=>$expert
        ]);
      }
      else{
        return response()->json([
            'message'=>'No Result Found'
        ]);
      }

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function autocomplete(Request $request)

    {

        $data = Expert::select("name",'experience')

                   ->where('name', 'LIKE', '%'. $request->get('query'). '%')

                    ->get();



        return response()->json($data);

    }
}
