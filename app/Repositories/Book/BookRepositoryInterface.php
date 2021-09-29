<?php

namespace App\Repositories\Book;

use App\Repositories\RepositoryInterface;

interface BookRepositoryInterface extends RepositoryInterface
{
    public function getAllBooksWithCategoriesAndImages();

    public function getBookWithRelationsById($id, $relations);

    public function prepareGetAllBooks();

    public function getAllBooksWithImagesAndLikesAndRates();

    public function searchBooksByCategoryId($category_id);

    public function searchBooksByTitle($title);

    public function getFavoriteBooksByUserId($user_id);
}
