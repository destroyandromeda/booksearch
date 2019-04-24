<?php
// контролер
Class Controller_Parser Extends Controller_Base {

    // шаблон
    public $layouts = "first_layouts";

    // экшен
    function index() {

        require_once("core/phpQuery.php");
        $data = array();
        ini_set('max_execution_time', 900);
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
        //чистим таблицы
        function delTables(){
            connect()->exec("DELETE FROM books");
            connect()->exec("DELETE FROM authors");
            connect()->exec("DELETE FROM genres");
            connect()->exec("DELETE FROM book_genre");
            connect()->exec("DELETE FROM book_author");
        }

        if(isset($_GET['parse']))
        {
            delTables();
            //парсинг по страницам, $i - номерс страницы,6 и более очень долго
            for ($i = 1; $i <= 10; $i++){
                // 1. инициализация
                $ch = curl_init();
                $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";
                // 2. устанавливаем опции, включая урл
                curl_setopt($ch, CURLOPT_URL, "https://www.litmir.me/bs?p=".$i);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
                curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
                curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

                // 3. выполнение запроса и получение ответа
                $html = curl_exec($ch);



                //$html = file_get_contents("https://www.litmir.me/bs?p=".$i);
                phpQuery::newDocument($html);
                $books = pq("div[jq=\"BookList\"]")->find(".island");
                foreach($books as $book){
                    $book = pq($book);
                    $data[] = array(
                        "name" => $book->find('.book_name span')->text(),
                        "authors" => $book ->find('span[itemprop=\'author\']')->text(),
                        "genres" => $book ->find('span[itemprop=\'genre\']')->text(),
                        "description" => $book ->find('div[itemprop="description"]')->text(),
                        "image" => $book->find('img[jq="BookCover"]')->attr("data-src"),
                        "alt" => $book->find('img[jq="BookCover"]')->attr("alt")
                    );
                }
            }
            //убираем лишние символы
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['genres'] = str_replace('...','',explode(',', $data[$i]['genres']));
                $data[$i]['authors'] = str_replace('...','',explode(',', $data[$i]['authors']));
            }
            //собираем данные в структурироввнный массив - актуально для жанров и авторов
            function normal($title,$data){
                $array = array();
                foreach ($data as $da){
                    foreach ($da[$title] as $a){
                        $array[] = $a;
                    }
                }
                $array = array_unique($array);
                $array = array_values($array);
                return $array;
            }
            //сохраняем книги
            for ($i = 1; $i <= count($data); $i++) {
                $book = new Model_Books();
                $book->id = $i;
                $book->name = $data[$i-1]['name'];
                $book->description =  $data[$i-1]['description'];
                $book->cover =  $data[$i-1]['image'];
                $book->save();
            }
            //сохраняем жанры
            $gen = normal('genres',$data);
            for ($i = 1; $i <= count($gen); $i++) {
                $genre = new Model_Genres();
                $genre->id = $i;
                $genre->genre = $gen[$i-1];
                $genre->save();
            }
            //сохраняем авторов
            $auth = normal('authors',$data);
            for ($i = 1; $i <= count($auth); $i++) {
                $authors = new Model_Authors();
                $authors->id = $i;
                $authors->full_name = $auth[$i-1];
                $authors->save();
            }
            //таблица book_author
            for ($i = 1; $i <= count($data); $i++) {
                $book_author = new Model_Book_Author();
                $a = $book_author->book = $data[$i-1]['name'];
                foreach ($data[$i-1]['authors'] as $value)
                {
                    $select_from_authors = 'SELECT * FROM authors WHERE full_name = \'' . $value . '\''; //sql запрос к бд
                    $model = new Model_Authors($select_from_authors); // создаем объект модели
                    $auth = $model->getOneRow(); // получаем все строки

                    $b = $book_author->author = $auth['id'];
                    $sql = "INSERT INTO book_author (id, book, author) VALUES (NULL,'$a','$b')";
                    $ept = connect()->prepare($sql);
                    $ept ->execute();
                    $book_author->save();
                }
            }
            //таблица book_genre
            for ($i = 1; $i <= count($data); $i++)
            {
                $book_genre = new Model_Book_Genre();
                $a = $book_genre->book = $data[$i-1]['name'];
                foreach ($data[$i-1]['genres'] as $value)
                {

                    $select_from_genres = 'SELECT * FROM genres WHERE genre = \'' . $value . '\''; //sql запрос к бд
                    $model = new Model_Genres($select_from_genres); // создаем объект модели
                    $gee = $model->getOneRow(); // получаем все строки

                    $b =  $book_genre->genres = $gee['id'];
                    $sql = "INSERT INTO book_genre (id, book, genres) VALUES (NULL,'$a','$b')";
                    $ept = connect()->prepare($sql);
                    $ept ->execute();
                    $book_genre->save();
                }
            }
            //отправка данных
            $this->template->vars('data', $data);

            // 4. очистка ресурсов
            curl_close($ch);
        }
        $this->template->view('index');


    }

}