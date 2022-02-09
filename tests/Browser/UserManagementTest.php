<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\UserManagementPage;
use Tests\DuskTestCase;

class UserManagementTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function testUserManagementView()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit(new UserManagementPage)
                ->assertRouteIs('users.index')
                ->assertSee(__('messages.stt'))
                ->assertSee(__('messages.username'))
                ->assertSee(__('messages.email'))
                ->assertSee(__('messages.fullname'))
                ->assertSee(__('messages.dob'))
                ->assertSee(__('messages.active'))
                ->assertSee(__('messages.action'))
                ->assertPresent('@btn-change-user-status')
                ->assertPresent('@btn-delete');
        });
    }

    public function testChangeUserStatus()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit(new UserManagementPage)
                ->changeUserStatus()
                ->assertRouteIs('users.index');
        });
    }

    public function testDeleteUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit(new UserManagementPage)
                ->deleteUser()
                ->waitForDialog()
                ->acceptDialog()
                ->assertRouteIs('users.index')
                ->assertSee(__('messages.delete-user-success'));
        });
    }
}
