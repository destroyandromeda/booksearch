 <form class="search ">
        <div class="row">
            <div class="findByTitleBook col-12 col-md-12">
                <div class="form-group">
                    <input type="text" class="form-control" name="book_title" value='<?php if(!empty($_GET)){echo $_GET['book_title'];}else{echo'';}?>'  placeholder = 'Введите название книги' >
                </div>
            </div>
            <div class="findByGenres col-12 col-md-4">
                <div class="spoiler-wrap disabled">
                    <div class="spoiler-head" style="width: 100%;text-align: center">Жанры</div>
                    <div class="spoiler-body">
                        <div class="form-check">
                            <input class="form-check-input" name='genre' type="checkbox" value=null id='genre' checked>
                        </div>
                        <?php foreach ($genres as $genre):?>
                            <div class="form-check">
                                <input class="form-check-input" name=<?='genre_id-'.$genre['id']?> type="checkbox" value=<?=$genre['id']?> id=<?='genre_id-'.$genre['id']?> <?php for ($i = 0; $i <= count($genres); $i++) {if(isset($_GET['genre_id-' . $i]) and $_GET['genre_id-' . $i]==$genre['id']){echo 'checked';}} ?>>
                                <label class="form-check-label" for=<?='genre_id-'.$genre['id']?>>
                                    <?=$genre['genre']?>
                                </label>
                            </div>
                        <?php endforeach?>
                    </div>
                </div>
            </div>
            <div class="click col- col-md-4" style="text-align: center">
                <button type="submit" class="btn btn-primary" >Искать</button>
            </div>
            <div class="findByAuthors col-12 col-md-4">
                <div class="spoiler-wrap disabled">
                    <div class="spoiler-head" style="width: 100%;text-align: center">Авторы</div>
                    <div class="spoiler-body">
                        <div class="form-check">
                            <input class="form-check-input" name='author' type="checkbox" value=null id='author' checked>
                        </div>
                        <?php foreach ($authors as $author):?>
                            <div class="form-check">
                                <input class="form-check-input" name=<?='author_id-'.$author['id']?> type="checkbox" value=<?=$author['id']?> id=<?='author_id-'.$author['id']?> <?php for ($i = 0; $i <= count($authors); $i++) {if(isset($_GET['author_id-' . $i]) and $_GET['author_id-' . $i]==$author['id']){echo 'checked';}} ?>>
                                <label class="form-check-label" for=<?='author_id-'.$author['id']?>>
                                    <?=$author['full_name']?>
                                </label>
                            </div>
                        <?php endforeach?>
                    </div>
                </div>
            </div>
        </div>
 </form>

 <div class="allbooks">
     <div class="row">
         <?php if(!empty($books1)):?>
             <?php foreach($books1 as $book): ?>
                 <div class="card" style="width: 16rem">
                     <img class="book-cover" src="https://www.litmir.me<?=$book['cover']?>" alt="<?=$book['cover']?>">
                     <div class="card-body">
                         <div class="spoiler-wrap disabled">
                             <div class="spoiler-head">Подробнее</div>
                             <div class=" spoiler-body description">
                                 <h5><?=$book['name']?></h5>
                                 <p><strong>Автор : </strong><?= $book['authors'] ?></p>
                                 <p><strong>Жанр : </strong><?= $book['genres'] ?> </p>
                                 <p><?=$book['description']?></p>
                             </div>
                         </div>
                     </div>

                 </div>
             <?php endforeach; ?>
         <?php endif; ?>
     </div>
 </div>
<script>
    $(function () {
        $('.spoiler-body').hide(300);
        $(document).on('click','.spoiler-head',function (e) {
            e.preventDefault()
            $(this).parents('.spoiler-wrap').toggleClass("active").find('.spoiler-body').slideToggle();
        })
    })
</script>