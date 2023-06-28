<?php

namespace Tests\Unit\Action;

use Tests\TestCase;

class ValidateTokenSyntaxActionTest extends TestCase
{
    protected $validateTokenSyntaxAction;

    /**
     * Set up method for dependencies
     */
    public function setUp(): void {
        parent::setUp();
        $this->validateTokenSyntaxAction = $this->app->make('App\Actions\ValidateTokenSyntax');
    }

    /**
     * Validate Token Syntax From Valid Token
     * @dataProvider validTokenProvider
     */
    public function testValidTokenSyntaxFromValidToken($token): void
    {
        $validation = $this->validateTokenSyntaxAction->validate($token);
        $this->assertTrue($validation);
    }

    /**
     * Validate Token Syntax From Invalid Token
     * @dataProvider invalidTokenProvider
     */
    public function testValidTokenSyntaxFromInvalidToken($token): void
    {
        $validation = $this->validateTokenSyntaxAction->validate($token);
        $this->assertFalse($validation);
    }

    /**
     * Validate Token Syntax From Invalid characters in Token
     */
    public function testValidTokenSyntaxFromInvalidCharactersInToken(): void
    {
        $token = '1234';
        $validation = $this->validateTokenSyntaxAction->validate($token);
        $this->assertFalse($validation);
    }

    /**
     * Token provider for valid token tests
     */
    public function validTokenProvider()
    {
        return [
            [''],
            ['[]'],
            ['()'],
            ['{}'],
            ['()[]{}'],
            ['([{}])']
        ];
    }

    /**
     * Token provider for invalid token tests
     */
    public function invalidTokenProvider()
    {
        return [
            ['['],
            ['('],
            ['{'],
            ['([{)]}'],
            ['(((((((({})']
        ];
    }
}
