<?php
use Tests\TestCase;
use App\Models\Fruit;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Capsule\Manager as DB;


class fruitIndexTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
        $this->fruit = Fruit::newFactory();
        $this->user = User::Factory();

        Config::set('something', true);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_assert_view_has_values()
    {
        // ACT -- ASSERT
        $this->get('/fruit')
            ->assertStatus(200)
            ->assertViewHas('fruits')
            ->assertViewIs('fruit');
    }
}
