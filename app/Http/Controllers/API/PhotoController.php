<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $photos = Photo::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Foto"
            ],
            "data" => $photos
        ], 200);
    }

    /**
     * PhotoHomePage
     *
     * @return void
     */
    public function PhotoHomePage()
    {
        $photos = Photo::latest()->take(2)->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Foto Homepage"
            ],
            "data" => $photos
        ], 200);
    }
}
