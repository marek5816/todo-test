<?php

namespace Tests\Browser;

use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FullAplicationTest extends DuskTestCase
{
    use RefreshDatabase;

    public function testBasicExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->value('#email', 'test@test.sk')
                ->value('#password', 'password')
                ->press('Log in')
                ->assertPathIs('/todo/tasks');

            $browser->visit('/todo/categories')
                ->value('#categoryName', 'duskCategory')
                ->press('Add Category')
                ->assertSee('Category created successfully!')
                ->assertSee('duskCategory');
        });
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }
}
