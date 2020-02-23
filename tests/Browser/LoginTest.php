<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }

    public function testRegisterNewUser()
    {

        $this->browse(function ($browser)
        {
            $browser->visit('/register')
                    ->type('name', 'Lorem Doloris')
                    ->type('email', 'lorem@lorem.xyz')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->screenshot('register-input-filled')
                    ->press('Register')
                    ->assertSee('You are logged in!')
                    ->click('#navbarDropdown')
                    ->screenshot('click-dropdown')
                    ->click('#navbarSupportedContent > ul.navbar-nav.ml-auto > li > div > a')
                    ->assertSee('LARACASTS');
        });
    }

    /**
     * Test login with an existing user
     *
     * @return void
     */
    public function testLoginWithExistingUser()
    {
        $user = factory(User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->screenshot('existing-user-login-page')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->screenshot('existing-user-back-to-home-page')
                    ->assertPathIs('/home')
                    ->click('#navbarDropdown')
                    ->screenshot('click-dropdown')
                    ->click('#navbarSupportedContent > ul.navbar-nav.ml-auto > li > div > a')
                    ->assertSee('LARACASTS')
                    ->screenshot('existing-user-logout'); // #navbarSupportedContent > ul.navbar-nav.ml-auto > li > div > a
        });
    }

    /**
     * Test login with an existing user but with bad password
     *
     * @return void
     */
    public function testLoginWithExistingUserButBadPassword()
    {
        $user = factory(User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->screenshot('bad-password-login-page')
                    ->type('email', $user->email)
                    ->type('password', 'lorem')
                    ->press('Login')
                    ->screenshot('bad-password-error-password')
                    ->assertSee('These credentials do not match our records.');
        });
    }


}
