<?php

namespace App\Http\Controllers;

use App\Repositories\CacheRepository;
use Illuminate\Http\Request;

class ValueController extends Controller
{

    protected $cache;


    public function __construct()
    {
        $this->cache = new CacheRepository();
    }


    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if($request->has('keys')) {
            $keys = explode(',', $request->keys);
            $items = $this->cache->getValueByKeys($keys);
        } else {
            $items = $this->cache->all();
        }


       if(count($items) > 0){
            return response()->json($items, 200);
        }

        return response()->json('No Content!', 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $this->cache->store($request->toArray());
        return response()->json('whatever’s appropriate', 201);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request)
    {
        $this->cache->update($request->toArray());
        return response()->json('whatever’s appropriate', 200);
    }
}
