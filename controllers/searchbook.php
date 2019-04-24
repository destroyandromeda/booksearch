<?php
// контролер
Class Controller_SearchBook Extends Controller_Base {

    // шаблон
    public $layouts = "first_layouts";

    // экшен
    function index() {
        $select_from_books = "SELECT books.name,books.cover,books.description,
GROUP_CONCAT(distinct authors.full_name) as autors, 
GROUP_CONCAT(distinct genres.genre) as genres FROM books 
LEFT JOIN book_author ON book_author.book = books.name 
LEFT JOIN book_genre ON book_genre.book = books.name
LEFT JOIN authors ON book_author.author = authors.id
LEFT JOIN genres ON book_genre.genres = genres.id group by books.id"; //sql запрос к бд

        $model_books = new Model_Books($select_from_books); // создаем объект модели
        $books = $model_books->getAllRows(); // получаем все строки

        $this->template->vars('books', $books);
        $this->template->view('index');
    }
}