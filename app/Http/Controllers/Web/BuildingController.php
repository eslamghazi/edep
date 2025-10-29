<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreBuildingRequest;
use App\Http\Requests\Dashboard\UpdateBuildingRequest;
use App\Models\Building;
use App\Models\City;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function buildingsByCity(City $city)
    {
        $buildings = $city->buildings()->pluck('name','id');
        return  json_encode($buildings);
    }
}
