<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Filament\Facades\Filament;

class UserAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_panel()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Test logic canAccessPanel
        $this->assertTrue($admin->canAccessPanel(Filament::getPanel('admin')));
        
        // Test HTTP access
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_warga_can_access_warga_panel()
    {
        $warga = User::factory()->create(['role' => 'warga']);
        
        // Test logic canAccessPanel
        $this->assertTrue($warga->canAccessPanel(Filament::getPanel('warga')));
        
        // Test HTTP access
        $response = $this->actingAs($warga)->get('/warga');
        $response->assertStatus(200);
    }

    public function test_warga_cannot_access_admin_panel()
    {
        $warga = User::factory()->create(['role' => 'warga']);
        
        // Test logic canAccessPanel
        $this->assertFalse($warga->canAccessPanel(Filament::getPanel('admin')));
        
        // Test HTTP access (should be forbidden or redirect)
        $response = $this->actingAs($warga)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_cannot_access_warga_panel()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Test logic canAccessPanel
        $this->assertFalse($admin->canAccessPanel(Filament::getPanel('warga')));
        
        // Test HTTP access
        $response = $this->actingAs($admin)->get('/warga');
        $response->assertStatus(403);
    }
}
