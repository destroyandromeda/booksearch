 <form class="search " id="form">
        <div class="row">
            <div class="findByTitleBook col-12 col-md-12">
                <div class="form-group">
                    <input type="text" class="form-control ajax_q" name="book_title" value='<?php if(!empty($_GET)){echo $_GET['book_title'];}else{echo'';}?>'  placeholder = 'Введите название книги' >
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
                                <input class="form-check-input" name=<?='genre_'.$genre['id']?> type="checkbox" value=<?=$genre['id']?> id=<?=$genre['id']?> <?php for ($i = 0; $i <= count($genres); $i++) {if(isset($_GET['genre_' . $i]) and $_GET['genre_' . $i]==$genre['id']){echo 'checked';}} ?>>
                                <label class="form-check-label" >
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
                                <input class="form-check-input" name=<?='author_'.$author['id']?> type="checkbox" value=<?=$author['id']?> id="checkbox" <?php for ($i = 0; $i <= count($authors); $i++) {if(isset($_GET['author_' . $i]) and $_GET['author_' . $i]==$author['id']){echo 'checked';}} ?>>
                                <label class="form-check-label"><?=$author['full_name']?></label>
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
                 <div class="card" style="width: 14rem">
                     <img class="book-cover" src="<?=$book['cover']?>" alt="<?=$book['name']?>">
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