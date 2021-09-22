<?php

namespace Tests\Browser\Pages;

use App\Models\Book;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class CreateBookPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/books/create';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  \Laravel\Dusk\Browser  $browser
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
            '@book-create-form' => 'form#form-add',
            '@book-category-select' => 'form#form-add select[name="category_id"]',
            '@book-title-input' => 'form#form-add input[name="title"]',
            '@book-author-input' => 'form#form-add input[name="author"]',
            '@book-pageNumber-input' => 'form#form-add input[name="number_of_page"]',
            '@book-publishDate-input' => 'form#form-add input[name="published_date"]',
            '@book-image-input' => 'form#form-add input[name="image"]',
            '@book-submit-button' => 'form#form-add button',
        ];
    }

    public function createBook(
        Browser $browser,
        $title,
        $author,
        $category_id,
        $numberPage,
        $publishDate,
        $image
    ) {
        $browser
            ->value('@book-category-select', $category_id)
            ->value('@book-title-input', $title)
            ->value('@book-author-input', $author)
            ->value('@book-pageNumber-input', $numberPage)
            ->value('@book-publishDate-input', $publishDate)
            ->attach('@book-image-input', $image)
            ->press('@book-submit-button');
    }
}
