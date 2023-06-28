<?php

namespace App\Http\Controllers;

use App\Actions\CreateTinyUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

/**
 * Url Shorter Controller
 */
class UrlShorterController extends Controller
{
    /**
     * Short Url Method.
     */
    public function shortUrl(Request $request, CreateTinyUrl $createTinyUrl): JsonResponse
    {
        Log::info(__CLASS__ . ' ' . __FUNCTION__ . ' Start to validate Request: ' . implode($request->all()));

        //create validator for the request
        $validator = Validator::make($request->all(), [
            'url' => 'required',
        ]);

        //handle if the validation fails
        if ($validator->fails()) {
            Log::error(__CLASS__ . ' ' . __FUNCTION__ . ' validation fails ' . $validator->errors());
            return new JsonResponse(['message' => 'url is required']);
        }

        //Call to Tiny Url Public api
        $response = $createTinyUrl->call_tiny_url($request->all()["url"]);

        Log::error(__CLASS__ . ' ' . __FUNCTION__ . ' finished successfuly.');
        return new JsonResponse(['url' => '<' . $response . '>']);
    }
}
