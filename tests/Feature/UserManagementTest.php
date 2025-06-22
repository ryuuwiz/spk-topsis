<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_user_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('users.index');
    }

    public function test_user_can_view_create_user_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('users.create'));

        $response->assertStatus(200);
        $response->assertViewIs('users.create');
    }

    public function test_user_can_create_new_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('users.store'), [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_can_view_edit_user_form(): void
    {
        $user = User::factory()->create();
        $userToEdit = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('users.edit', $userToEdit));

        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
    }

    public function test_user_can_update_user(): void
    {
        $user = User::factory()->create();
        $userToUpdate = User::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('users.update', $userToUpdate), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_user_can_view_user_details(): void
    {
        $user = User::factory()->create();
        $userToView = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('users.show', $userToView));

        $response->assertStatus(200);
        $response->assertViewIs('users.show');
    }

    public function test_user_can_delete_user(): void
    {
        $user = User::factory()->create();
        $userToDelete = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('users.destroy', $userToDelete));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id,
        ]);
    }

    public function test_user_cannot_delete_themselves(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('users.destroy', $user));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    public function test_user_index_shows_search_results(): void
    {
        $user = User::factory()->create();
        User::factory()->create(['name' => 'John Doe']);
        User::factory()->create(['name' => 'Jane Smith']);

        $response = $this->actingAs($user)
            ->get(route('users.index', ['search' => 'John']));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    }
} 