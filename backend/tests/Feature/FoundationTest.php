<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_queries_are_scoped_to_the_authenticated_owner(): void
    {
        $ownerA = User::factory()->create();
        $ownerB = User::factory()->create();

        Category::create(['user_id' => $ownerA->id, 'name' => 'Bags A']);
        Category::create(['user_id' => $ownerB->id, 'name' => 'Bags B']);

        $this->actingAs($ownerA);

        $this->assertSame(1, Category::count());
        $this->assertSame('Bags A', Category::first()->name);
        $this->assertSame(2, Category::withoutGlobalScope('user')->count());
    }

    public function test_user_id_is_auto_filled_when_creating_while_authenticated(): void
    {
        $owner = User::factory()->create();
        $this->actingAs($owner);

        $category = Category::create(['name' => 'Stickers']);

        $this->assertSame($owner->id, $category->user_id);
    }

    public function test_other_owners_records_are_not_visible(): void
    {
        $ownerA = User::factory()->create();
        $ownerB = User::factory()->create();

        Category::create(['user_id' => $ownerB->id, 'name' => 'Hidden']);

        $this->actingAs($ownerA);

        $this->assertNull(Category::where('name', 'Hidden')->first());
    }
}
