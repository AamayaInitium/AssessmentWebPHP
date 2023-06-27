<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UrlShorterController extends Controller
{

    /**
     * Short Url Method.
     */
    public function shortUrl(Request $request): JsonResponse
    {
        Log::info(__CLASS__ . ' ' . __FUNCTION__ . ' Start to validate Request: ' . implode($request->all()));

        $validator = Validator::make($request->all(), [
            'url' => 'required',
        ]);

        if ($validator->fails()) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ' validation fails ' . $validator->errors());
            return new JsonResponse(['message' => 'url is required']);
        }

        Log::error(__CLASS__ . ' ' . __FUNCTION__ . ' finished successfuly.');
        return new JsonResponse(['url' => '<' . $request->all()["url"] . '>']);
    }
}
