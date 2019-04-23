<?php
// контролер
Class Controller_Find Extends Controller_Base {

    // шаблон
    public $layouts = "first_layouts";

    // экшен
    function index() {

        require_once("core/phpQuery.php");
        $data = array();

        function connect(){
            $host = '127.0.0.1';
            $db   = 'job';
            $user = 'root';
            $pass = '';
            $charset = 'utf8';
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            return $pdo = new PDO($dsn, $user, $pass, $opt);
        }

        $sql = "SELECT * FROM book_author "; //sql запрос к бд
        $model = new Model_Book_Author($sql); // создаем объект модели
        $authors = $model->getAllRows(); // получаем все строки

        $sql = "SELECT * FROM book_genre "; //sql запрос к бд
        $model = new Model_Book_Genre($sql); // создаем объект модели
        $genres = $model->getAllRows(); // получаем все строки

        $sql = "SELECT * FROM authors "; //sql запрос к бд
        $model = new Model_Authors($sql); // создаем объект модели
        $authors_view = $model->getAllRows(); // получаем все строки

        $sql = "SELECT * FROM genres "; //sql запрос к бд
        $model = new Model_Genres($sql); // создаем объект модели
        $genres_view = $model->getAllRows(); // получаем все строки

        //поиск по данным из формы
        //проверка на наличее данных переданных формой
        $countAuthor=0;
        $countGenre=0;
        $strAuthor = 'WHERE ';
        if (!empty($_GET)) {
            //если есть название, то ищем по нему
            if (!empty($_GET['book_title']))
            {
                $sql = "SELECT 
                            books.name,
                            books.cover,
                            books.description, 
                            GROUP_CONCAT(distinct authors.full_name) as authors, 
                            GROUP_CONCAT(distinct genres.genre ) as genres 
                        FROM books
                            LEFT JOIN book_author ON book_author.book = books.name 
                            LEFT JOIN book_genre ON book_genre.book = books.name 
                            LEFT JOIN authors ON book_author.author = authors.id
                            LEFT JOIN genres ON book_genre.genres = genres.id WHERE books.name = '" . $_GET['book_title'] . "' group by books.id ";
                $model_books = new Model_Books($sql); // создаем объект модели
                $books1 = $model_books->getAllRows(); // получаем все строки
            }
            else {
                for ($i = 0; $i <= count($authors); $i++)
                {
                    //проверяем наличее checkbox'ов
                    if (!empty($_GET['author_id-' . $i]))
                    {
                        //добавляем в выборку данные
                        $countAuthor++;
                        $strAuthor .= ' authors.id = \'' . $_GET['author_id-' . $i] . '\' OR ';
                    }
                }


                if($i>=count($authors) and  $countAuthor>0){
                    $strAuthor = substr($strAuthor, 0, -3);
                    $strAuthor .= ' AND ';
                }


                for ($i = 0; $i <= count($genres); $i++)
                {
                    //проверяем наличее checkbox'ов
                    if (!empty($_GET['genre_id-' . $i]))
                    {
                        //добавляем в выборку данные
                        $countGenre++;
                        $strAuthor .= ' genres.id = \'' . $_GET['genre_id-' . $i] . '\' OR ';
                    }
                }
                if($countAuthor<1){
                    $strAuthor = substr($strAuthor, 0, -3);

                }
                $strAuthor = substr($strAuthor, 0, -1);//убираем последний OR
                
                if($countAuthor == 0 and $countGenre == 0)
                {
                    $strAuthor = '';
                }//если не было chekbox'ов, то убираем из запроса WHERE

                if(($countGenre != 0) and ($countGenre == 0)){
                    str_replace(' AND ','',$strAuthor);
                    $strAuthor = substr($strAuthor, 0, -3);
                }
                echo $strAuthor;
                echo '<br>';

                //добавляем в запрос наши параметры
                $sql = "SELECT 
                            books.name,
                            books.cover,
                            books.description, 
                            GROUP_CONCAT(distinct authors.full_name) as authors, 
                            GROUP_CONCAT(distinct genres.genre ) as genres 
                        FROM books
                            LEFT JOIN book_author ON book_author.book = books.name 
                            LEFT JOIN book_genre ON book_genre.book = books.name 
                            LEFT JOIN authors ON book_author.author = authors.id
                            LEFT JOIN genres ON book_genre.genres = genres.id ".$strAuthor." group by books.id  ";
                echo $sql;


                $model_books = new Model_Books($sql); // создаем объект модели
                $books1 = $model_books->getAllRows(); // получаем все строки



            }

            //отправка данных
            $this->template->vars('books1', $books1);

        }

        $this->template->vars('authors', $authors_view);
        $this->template->vars('genres', $genres_view);
        $this->template->view('index');
    }

}