


<div class="allbooks row">
    <?php foreach($books as $book): ?>
        <div class="book col-12">
            <div class="row" >

                <div class="col-12 col-md-2">
                    <img class="book-cover" src="https://www.litmir.me<?=$book['cover']?>">
                </div>

                <div class="col-12 col-md-10">

                    <div class="col-12">
                        <h2 class="title"><?=$book['name']?></h2>
                        <p><?= $book['genres'] ?> </p>
                        <h3><?= $book['autors'] ?></h3>
                    </div>

                </div>

                <div class="spoiler-wrap disabled col-12">
                    <div class="spoiler-head">Описание</div>
                    <p class=" spoiler-body description"><?=$book['description']?></p>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
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