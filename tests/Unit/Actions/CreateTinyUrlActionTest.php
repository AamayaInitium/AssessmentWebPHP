<?php

namespace Tests\Unit\Action;

use Tests\TestCase;

class CreateTinyUrlActionTest extends TestCase
{
    protected $createTinyUrlAction;
    
    /**
     * Set up method for dependencies
     */
    public function setUp(): void {
        parent::setUp();
        $this->createTinyUrlAction = $this->app->make('App\Actions\CreateTinyUrl');
    }

    /**
     * Test Valid TinyUrl Response.
     * @dataProvider urlProvider
     */
    public function testValidTinyUrlResponse($url): void
    {
        $tinyUrlResonse = $this->createTinyUrlAction->call_tiny_url($url);
        $this->assertIsString($tinyUrlResonse);
        $this->assertStringContainsString('tinyurl', $tinyUrlResonse);
    }

    /**
     * Url Provider
     */
    public function urlProvider()
    {
        return [
            ['https://laravel.com/'],
            ['https://phpunit.de/'],
            ['https://www.google.com/'],
            ['https://example.com/12345'],
        ];
    }
}
