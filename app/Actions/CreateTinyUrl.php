<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Create Tiny Url Action Class
 */
class CreateTinyUrl
{

	/**
	 * Create Tiny Url from urlString
	 *
	 * @param string url
	 * 
	 * @return string result of the tinyUrl public api
	 */
	public function call_tiny_url(string $url): string
	{
		try {
			Log::info(__CLASS__ . ' ' . __FUNCTION__ . ' Start to call tinyUrl public api. url: ' . $url);

			// call to tiny url public api
			$response = Http::get('https://tinyurl.com/api-create.php', [
				'url' => $url,
			]);

			Log::info(__CLASS__ . ' ' . __FUNCTION__ . ' call tinyUrl public api finished successfuly. Result: ' . $response->body());
			
			// return the result of the tiny url public api
			return $response->body();

		} catch (Exception $e) {
			Log::error(__CLASS__ . ' ' . __FUNCTION__ . ' Unexpected Error calling tinyUrl public api. Error: ' . $e->getMessage());
			return '';
		}
	}
}
