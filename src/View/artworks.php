<div class="container py-5">
    <form class="d-flex">
        <div id="search_hash_tags" class="hash-module"></div>    
        <button class="btn btn-primary ml-2">검색</button>
    </form>
    
    <?php if(user()):?>
    <div class="py-5">
        <h4>내가 등록한 작품</h4>
        <div class="row mt-4">
            <?php foreach($myList as $artwork):?>
            <div class="col-3">
                <div class="card <?=isset($artwork->deleted) ? "deleted" :"" ?>" onclick="<?= isset($artwork->deleted) ? "" : "location.href='/artwork?id=".$artwork->id."'"?>">
                    <img src="/uploads/artworks/<?=$artwork->image?>" class="card-img-top" />
                    <div class="card-body">
                        <h5 class="card-title"><?=$artwork->title?></h5>
                        <p>
                            <span class="badge badge-light"><?=$artwork->user_name?></span>
                            <span class="badge badge-primary"><?=$artwork->type === "normal" ? "일반" : "기업"?></span>
                            <span class="text-primary">
                                <i class="fa fa-star"></i>
                                <b><?=$artwork->total?></b>
                            </span>
                            <small class="text-muted"><?=date("Y-m-d", strtotime($artwork->created_at))?></small>
                        </p>
                        <div>
                            <?php foreach(json_decode($artwork->tags) as $tag):?>
                            <span class="badge"><?=$tag->data?></span>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
                <?php if(isset($artwork->deleted)):?>
                    <div class="py-3 px-2">
                        <span class="badge text-muted">삭제사유</span>
                        <p><?=nl2br($artwork->comment)?></p>
                    </div>
                <?php endif;?>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <?php endif;?>
    <div class="py-5">
        <h4>우수 작품</h4>
        <div class="row mt-4">
            <?php foreach($ranker as $artwork):?>
                <div class="col-3">
                    <div class="card" onclick="location.href='/artwork?id=<?=$artwork->id?>'">
                        <img src="/uploads/artworks/<?=$artwork->image?>" class="card-img-top" />
                        <div class="card-body">
                            <h5 class="card-title"><?=$artwork->title?></h5>
                            <p>
                                <span class="badge badge-light"><?=$artwork->user_name?></span>
                                <span class="badge badge-primary"><?=$artwork->type === "normal" ? "일반" : "기업"?></span>
                                <span class="badge badge-danger">우수작품</span>
                                <span class="text-primary">
                                    <i class="fa fa-star"></i>
                                    <b><?=$artwork->total?></b>
                                </span>
                                <small class="text-muted"><?=date("Y-m-d", strtotime($artwork->created_at))?></small>
                            </p>
                            <div>
                                <?php foreach(json_decode($artwork->tags) as $tag):?>
                                <span class="badge"><?=$tag->data?></span>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="py-5">
        <h4>전체 작품</h4>
        <div class="row mt-4">
            <?php foreach($artworks->data as $artwork):?>
                <div class="col-3">
                    <div class="card" onclick="location.href='/artwork?id=<?=$artwork->id?>'">
                        <img src="/uploads/artworks/<?=$artwork->image?>" class="card-img-top" />
                        <div class="card-body">
                            <h5 class="card-title"><?=$artwork->title?></h5>
                            <p>
                                <span class="badge badge-light"><?=$artwork->user_name?></span>
                                <span class="badge badge-primary"><?=$artwork->type === "normal" ? "일반" : "기업"?></span>
                                <span class="text-primary">
                                    <i class="fa fa-star"></i>
                                    <b><?=$artwork->total?></b>
                                </span>
                                <small class="text-muted"><?=date("Y-m-d", strtotime($artwork->created_at))?></small>
                            </p>
                            <div>
                                <?php foreach(json_decode($artwork->tags) as $tag):?>
                                <span class="badge"><?=$tag->data?></span>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <ul class="pagination mt-5">
            <li class="page-item">
                <a href="<?=$artworks->prev ? "/artworks?id=".$artworks->prevNo : "#" ?>" class="page-link"><i class="fa fa-angle-left"></i></a>
            </li>
            <?php for($i = $artworks->start; $i <= $artworks->end; $i++):?>
            <li class="page-item<?=$artworks->page == $i ? " active" : ""?>">
                <a href="/artworks?page=<?=$i?><?=$keyword?>" class="page-link"><?=$i?></a>
            </li>
            <?php endfor?>
            <li class="page-item">
                <a href="<?=$artworks->next ? "/artworks?id=".$artworks->nextNo : "#" ?>" class="page-link"><i class="fa fa-angle-right"></i></a>
            </li>
        </ul>
    </div>
</div>

<script>
    fetch("/artworks/hash-tags")
    .then(res => res.json())
    .then(hash_tags => {
        console.log(hash_tags);
        let entryHashModule = new HashModule("#search_hash_tags", hash_tags, <?=$json_keyword?>);
        entryHashModule.init();
    })
</script>