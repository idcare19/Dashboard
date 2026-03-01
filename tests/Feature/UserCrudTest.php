<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);
    }

    public function test_users_index_page_loads_successfully(): void
    {
        $this->actingAsAdmin();
        User::factory()->count(2)->create();

        $response = $this->get(route('users.index'));

        $response->assertOk();
        $response->assertSee('Users CRUD');
    }

    public function test_user_can_be_created(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('users.store'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_user_can_be_updated_without_changing_password(): void
    {
        $this->actingAsAdmin();

        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'password' => 'old-password-123',
            'role' => 'user',
        ]);

        $oldPasswordHash = $user->password;

        $response = $this->put(route('users.update', $user), [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'password' => '',
            'password_confirmation' => '',
            'role' => 'user',
        ]);

        $response->assertRedirect(route('users.index'));

        $user->refresh();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
            'password' => $oldPasswordHash,
        ]);
    }

    public function test_user_can_be_deleted(): void
    {
        $this->actingAsAdmin();

        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
