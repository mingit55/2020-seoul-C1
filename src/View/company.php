<div class="container py-5">
    <h4>우수업체</h4>
    <div class="row">
        <?php foreach($ranker as $company):?>
        <div class="col-3">
            <div class="card">
                <img src="/uploads/users/<?=$company->image?>" class="card-img-top" />
                <div class="card-body">
                    <h5 class="card-title"><?=$company->user_name?></h5>
                    <p class="d-flex justify-content-between align-items-center">
                        <span class="text-muted"><?=$company->email?></span>
                        <span class="badge badge-primary"><?=$company->total?>p</span>
                    </p>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<div class="container py-5">
    <h4>업체 리스트</h4>
    <div class="row">
        <?php foreach($companies->data as $company):?>
            <div class="col-3">
                <div class="card">
                    <img src="/uploads/users/<?=$company->image?>" class="card-img-top" />
                    <div class="card-body">
                        <h5 class="card-title"><?=$company->user_name?></h5>
                        <p class="d-flex justify-content-between align-items-center">
                            <span class="text-muted"><?=$company->email?></span>
                            <span class="badge badge-primary"><?=$company->total?>p</span>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <ul class="pagination">
        <li class="page-item">
            <a href="<?=$companies->prev ? "/company?id=".$companies->prevNo : "#" ?>" class="page-link"><i class="fa fa-angle-left"></i></a>
        </li>
        <?php for($i = $companies->start; $i <= $companies->end; $i++):?>
        <li class="page-item<?=$companies->page == $i ? " active" : ""?>">
            <a href="/company?page=<?=$i?>" class="page-link"><?=$i?></a>
        </li>
        <?php endfor?>
        <li class="page-item">
            <a href="<?=$companies->next ? "/company?id=".$companies->nextNo : "#" ?>" class="page-link"><i class="fa fa-angle-right"></i></a>
        </li>
    </ul>
</div>