<pre>
<?php 
    $notice->files = json_decode($notice->files);
?>
</pre>
<div class="container py-5">
    <h3><?=$notice->title?></h3>
    <?php if(admin()):?>
    <div class="mt-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#edit-modal">수정하기</button>
        <a href="/notice/remove?id=<?=$notice->id?>" class="btn btn-danger">삭제하기</a>
    </div>
    <?php endif;?>
    <div class="mt-4">
        <div>
            <?=nl2br($notice->contents)?>
        </div>
        <?php foreach($notice->files as $file):?>
            <?php if(substr(upload_file("notices/$file")->type, 0, 5) === "image"):?>
                <img class="mt-4 mw-100" src="/uploads/notices/<?=$file?>" alt="<?=$file?>">
            <?php endif;?>
        <?php endforeach;?>
    </div>
    <div class="list-group mt-4">
        <?php foreach($notice->files as $file):?>
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <b><?=upload_file("notices/$file")->filename?></b>
                <div class="text-muted"><?=number_format(upload_file("notices/$file")->size)?>byte</div>
            </div>
            <a href="/uploads/notices/<?=$file?>" download="<?=upload_file("notices/$file")->filename?>" class="btn btn-primary">다운로드</a>
        </div>
        <?php endforeach;?>
    </div>
</div>

<form id="edit-modal" class="modal fade" action="/notice/edit?id=<?=$notice->id?>" method="post" enctype="multipart/form-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>수정하기</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">제목</label>
                    <input type="text" id="title" class="form-control" name="title" value="<?=$notice->title?>" required>
                </div>
                <div class="form-group">
                    <label for="contents">내용</label>
                    <textarea name="contents" class="form-control" id="contents" cols="30" rows="10" required><?=$notice->contents?></textarea>
                </div>
                <div class="form-group">
                    <label for="uploads">첨부파일</label>
                    <input type="file" id="uploads" class="form-control" name="uploads[]" multiple>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button class="btn btn-primary">수정하기</button>
            </div>
        </div>
    </div>
</form>