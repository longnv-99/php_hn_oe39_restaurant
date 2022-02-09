<?php

namespace Tests\Browser;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CreateBookPage;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CreateBookTest extends DuskTestCase
{
    use WithFaker;
    public function testViewElements()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit(new CreateBookPage())
                ->assertInputPresent('category_id')
                ->assertInputPresent('title')
                ->assertInputPresent('author')
                ->assertInputPresent('number_of_page')
                ->assertInputPresent('published_date')
                ->assertInputPresent('image')
                ->assertPresent('@book-submit-button');
        });
    }

    public function testCreateBookSuccessfully()
    {
        $title = "a";
        $author = "b";
        $category_id = 1;
        $numberPage = 1;
        $publishDate = "2021-09-21";
        $image = $this->faker->image;
        $this->browse(function (Browser $browser) use (
            $title,
            $author,
            $category_id,
            $numberPage,
            $publishDate,
            $image
        ) {
            $browser->loginAs(User::find(1))
                ->visit(new CreateBookPage())
                ->createBook($title, $author, $category_id, $numberPage, $publishDate, $image)
                ->assertPathIs('/admin/books');
        });
    }

    public function testCreateBookFailed()
    {
        $title = "";
        $author = "";
        $category_id = 1;
        $numberPage = 1;
        $publishDate = "2021-09-21";
        $image = $this->faker->image;

        $this->browse(function (Browser $browser) use (
            $title,
            $author,
            $category_id,
            $numberPage,
            $publishDate,
            $image
        ) {
            $browser->loginAs(User::find(1))
                ->visit(new CreateBookPage())
                ->createBook($title, $author, $category_id, $numberPage, $publishDate, $image)
                ->assertSee(__('validation.required', ['attribute' => 'title']))
                ->assertSee(__('validation.required', ['attribute' => 'author']))
                ->assertPathIs('/admin/books/create');
        });
    }
}
