<?php

namespace Tests\Feature;

use App\Http\Middleware\SetFilamentLocale;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Define a dummy route using the middleware
        Route::get('/test-locale-middleware', function () {
            return app()->getLocale();
        })->middleware([
            \Illuminate\Session\Middleware\StartSession::class, // Session must be started first
            SetFilamentLocale::class
        ]);
    }

    public function test_middleware_sets_default_locale_to_id()
    {
        // Ensure session is empty
        Session::flush();
        
        $response = $this->get('/test-locale-middleware');
        
        $response->assertSee('id');
    }

    public function test_middleware_sets_locale_from_session()
    {
        // Set session
        $this->withSession(['locale' => 'en']);
        
        $response = $this->get('/test-locale-middleware');
        
        $response->assertSee('en');
    }

    public function test_switch_language_route()
    {
        $response = $this->get('/switch-language/en');
        $response->assertRedirect();
        $this->assertEquals('en', session('locale'));
        
        $response = $this->get('/switch-language/id');
        $response->assertRedirect();
        $this->assertEquals('id', session('locale'));
    }
}
