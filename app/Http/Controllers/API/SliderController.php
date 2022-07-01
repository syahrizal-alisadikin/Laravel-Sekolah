<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(10);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Sliders"
            ],
            "data" => $sliders
        ], 200);
    }
}
