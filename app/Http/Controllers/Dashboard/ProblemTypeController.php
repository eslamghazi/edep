<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreProblemTypeRequest;
use App\Http\Requests\Dashboard\UpdateProblemTypeRequest;
use App\Models\ProblemType;

class ProblemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProblemTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProblemType $problemType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProblemType $problemType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProblemTypeRequest $request, ProblemType $problemType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProblemType $problemType)
    {
        //
    }
}
