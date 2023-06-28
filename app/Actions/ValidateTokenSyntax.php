<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Validate Token Syntax Action Class
 */
class ValidateTokenSyntax {
	/**
	 * Validate if the bearer token has the expected syntax
	 *
	 * @param string bearer token
	 * 
	 * @return bool result of the validation
	 */
	public function validate(string $token) : bool{
		try {
			Log::info(__CLASS__.' '.__FUNCTION__.' Start to validate bearer token');
			$validation = true;
			$openingTags = ['{', '[', '('];

			if(Str::length($token) == 0){
				// if token is empty then the validation is true
				return true;
			}

			// verify only valid characters '(, ), {, }, [, ]'
			if(preg_match('/[^{}\[\]\(\)]/', $token)){
				Log::warning(__CLASS__.' '.__FUNCTION__.' Invalid character in token');
				return false;
			}
			
			$closingTagList = array();
			// iterate every char in token string to validate token syntax
			for ($i = 0; $i < Str::length($token); $i++){
				
				//if the char is a valid opening tag then push in the array the correct closing tag
				if(in_array($token[$i], $openingTags)){
					array_push($closingTagList, $this->get_closing_tag($token[$i]));
				}

				// if the closing tag list is not empty and the current char is equal to the last closing tag added
				else if(count($closingTagList) > 0 && end($closingTagList)== $token[$i]){
					array_pop($closingTagList);
				}
				
				//if the previous validations are false, then the validation is false
				else{
					$validation = false;
					break;
				}
			}
			
			//If there is something in closing tag list then the validation is false
			if(count($closingTagList) > 0){
				$validation = false;
			}

			Log::info(__CLASS__.' '.__FUNCTION__.' Validate Bearer Token finished successfuly. Validation Result: '.json_encode($validation));
			return $validation;
		}
		catch(Exception $e){
			Log::error(__CLASS__.' '.__FUNCTION__.' Unexpected Error validating Bearer Token. Error: '.$e->getMessage());
			return false;
		}
	}

	/**
	 * Get closing tag from the start tag
	 *
	 * @param string $tag opening tag to validate
	 * 
	 * @return string closing tag
	 */
	private function get_closing_tag(string $tag): string {
		Log::info(__CLASS__.' '.__FUNCTION__.' Get Closing tag from: '.$tag);
		$closeTag = '';

		switch($tag){
			case '{':
				$closeTag = '}';
			break;
			case '[':
				$closeTag = ']';
			break;
			case '(':
				$closeTag = ')';
			break;
		}

		Log::info(__CLASS__.' '.__FUNCTION__.' Get Closing tag from: '.$tag.' finished succesfully. result: '.$closeTag);
		return $closeTag;
	}
} 