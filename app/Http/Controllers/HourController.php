<?php

namespace App\Http\Controllers;

use App\Models\Hour;
use App\Http\Requests\StoreHourRequest;
use App\Http\Requests\UpdateHourRequest;

class HourController extends Controller
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
    public function store(StoreHourRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Hour $hour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hour $hour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHourRequest $request, Hour $hour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hour $hour)
    {
        //
    }
}
