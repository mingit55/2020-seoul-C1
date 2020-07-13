<div class="container py-5">
    <!-- 작품 소개 영역 -->
    <div class="py-5">
        <div class="py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3><?=$artwork->title?></h3>
                <div>
                        <?php if( writer($artwork->uid) ):?>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#edit-modal">수정하기</button>
                        <?php endif;?>
                        <?php if(admin()):?>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#delete-modal">삭제하기</button>
                        <?php elseif(writer($artwork->uid)):?>
                            <a href="/artwork/delete?id=<?=$artwork->id?>" class="btn btn-danger">삭제하기</a>
                        <?php endif;?>
                    </div>
            </div>
            <p>
                <span class="text-muted mr-3"><?=date("Y-m-d", strtotime($artwork->created_at))?></span>
                <b class="text-primary mr-3">
                    <i class="fa fa-star"></i>
                    <?= $artwork->total ?>
                </b>
            </p>
            <p>
                <?php foreach(json_decode($artwork->tags) as $tag):?>
                    <span class="badge"><?=$tag->data?></span>
                <?php endforeach;?>
            </p>
        </div>
        <div class="py-3">
            <?= nl2br($artwork->contents) ?>
        </div>
        <div class="py-3">
            <img src="/uploads/artworks/<?=$artwork->image?>" alt="작품 이미지" class="border mw-100">
        </div>
    </div>
    <!-- /작품 소개 영역 -->
    <!-- 평점주기 영역 -->
    <?php if(user() && !$scored && $artwork->uid != user()->id):?>
    <div class="py-5">
        <form action="/artworks/scores" method="post">
            <input type="hidden" name="aid" value="<?=$artwork->id?>">
            <select name="score" id="score" class="text-danger fa">
                <option class="fa" value="5">&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;</option>
                <option class="fa" value="4.5">&#xf005;&#xf005;&#xf005;&#xf005;&#xf089;</option>
                <option class="fa" value="4">&#xf005;&#xf005;&#xf005;&#xf005;&#xf006;</option>
                <option class="fa" value="3.5">&#xf005;&#xf005;&#xf005;&#xf089;&#xf006;</option>
                <option class="fa" value="3">&#xf005;&#xf005;&#xf005;&#xf006;&#xf006;</option>
                <option class="fa" value="2.5">&#xf005;&#xf005;&#xf089;&#xf006;&#xf006;</option>
                <option class="fa" value="2">&#xf005;&#xf005;&#xf006;&#xf006;&#xf006;</option>
                <option class="fa" value="1.5">&#xf005;&#xf089;&#xf006;&#xf006;&#xf006;</option>
                <option class="fa" value="1">&#xf005;&#xf006;&#xf006;&#xf006;&#xf006;</option>
                <option class="fa" value="0.5">&#xf089;&#xf006;&#xf006;&#xf006;&#xf006;</option>
            </select>
            <button class="btn btn-light border">확인</button>
        </form>     
    </div>
    <?php endif;?>
    <!-- /평점주기 영역 -->
    <!-- 제작자 소개 영역 -->
    <div class="card">
        <div class="row no-gutters align-items-center">
            <div class="col-2">
                <img src="/uploads/users/<?=$writer->image?>" alt="프로필 사진" class="card-img">
            </div>
            <div class="col-offset-1"></div>
            <div class="col-9">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0"><?=$writer->user_name?></h5>
                        <span class="badge badge-primary ml-2"><?= $writer->type == "company" ? "기업" : "일반" ?></span>
                    </div>
                    <p class="card-text text-muted"><?=$writer->email?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- /제작자 소개 영역 -->
</div>

<!-- 관리자 삭제 -->
<form action="/artwork/delete" id="delete-modal" class="modal fade" method="post">
    <input type="hidden" name="aid" value="<?=$artwork->id?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                삭제하기
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="comment">삭제 사유</label>
                    <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal footer text-right">
                <button class="btn btn-primary">삭제하기</button>
            </div>
        </div>
    </div>
</form>
<!-- /관리자 삭제 -->

<!-- 텍스트 수정 -->
<form action="/artwork/edit" id="edit-modal" class="modal fade" method="post">
    <input type="hidden" name="aid" value="<?=$artwork->id?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                수정하기
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">제목</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?=$artwork->title?>" required>
                </div>
                <div class="form-group">
                    <label for="contents">내용</label>
                    <textarea name="contents" id="contents" cols="30" rows="10" class="form-control" required><?=$artwork->contents?></textarea>
                </div>
                <div class="form-group">
                    <div id="edit_hash" class="hash-module"></div>
                </div>
            </div>
            <div class="modal footer text-right">
                <button class="btn btn-primary">수정 완료</button>
            </div>
        </div>
    </div>
</form>
<!-- /텍스트 수정 -->

<script>
    let hashModule = new HashModule("#edit_hash", [], <?=$artwork->tags?>);
    hashModule.init();
</script>