<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testHomePage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(1000)
                    ->screenshot('accueil-screenshot')
                    ->assertSee('Laravel Todolist')
                    ->assertDontSee('Vapor')
                    ->assertSee('Login');
        });
    }


    /**
     * At home page we MUST have a bootstrap container with dusk id 'main-container'
     */
    public function testMainContainer()
    {
        $this->browse(function (Browser $browser)
        {
            $browser->visit('/')
                    ->assertPresent('@main-container');
        });
    }

    /**
     * Test can see Laravel Todolist in 'main-container'
     */
    public function testLaravelTodolistInMainContainer(){
        $this->browse(function (Browser $browser)
        {
            $browser->visit('/')
                    ->assertSeeIn('@main-container', 'Laravel Todolist');
        });
    }



    /**
     * Check the welcome text on home page
     */
    public function testWelcomeText()
    {
        $this->browse(function (Browser $browser)
        {
            $browser->visit('/')
                    ->assertSee('Cette application va vous permettre de mettre en place des Todolists pour organiser vos tâches quotidiennes.');
        });
    }
}
