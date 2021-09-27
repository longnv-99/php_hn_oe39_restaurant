<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class UserManagementPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/users';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@btn-change-user-status' => 'a.btn-change-user-status',
            '@btn-delete' => 'a.btn-delete',
        ];
    }

    public function changeUserStatus(Browser $browser)
    {
        $browser->press('@btn-change-user-status');
    }

    public function deleteUser(Browser $browser)
    {
        $browser->press('@btn-delete');
    }
}
