<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Actions\ValidateTokenSyntax;

/**
 * Validate Token Middleware
 */
class ValidateToken
{
    protected $validateTokenSyntaxAction;
    public function __construct(ValidateTokenSyntax $validateTokenSyntaxAction)
    {
        $this->validateTokenSyntaxAction = $validateTokenSyntaxAction;
    }

    /**
     * Validate Token Handle.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $result = $this->validateTokenSyntaxAction->validate($request->bearerToken());

        if(!$result){
            return response()->json(['message' => 'unauthorized'], 403);
        }

        return $next($request);
    }
}
