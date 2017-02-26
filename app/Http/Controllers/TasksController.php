<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tasks;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tasks $tasks)
    {
        return response()->json( $tasks->orderBy('updated_at', 'desc')->get() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tasks $tasks)
    {
        $tasks->body = $request->input('body');
        $tasks->save();

        return response()->json( $request->input() );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tasks $tasks, $id)
    {
        return response()->json( $tasks->where('id', $id)->first() );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasks $tasks, $id)
    {
        $task = $tasks->where('id', $id)->first();
        $task->body = $request->input('body');
        $task->save();

        return response()->json( $request->input() );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $tasks, $id)
    {
        $tasks->where('id', $id)->delete();
    }
}
