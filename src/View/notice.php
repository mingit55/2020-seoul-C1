<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center">
        <h4>알려드립니다</h4>
        <?php if(admin()):?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#write-modal">공지 작성</button>
        <?php endif;?>
    </div>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>제목</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($notices->data as $notice):?>
            <tr onclick="location.assign('/notice?id=<?=$notice->id?>')">
                <td><?=$notice->id?></td>
                <td><?=$notice->title?></td>
                <td><?=date("Y-m-d", strtotime($notice->created_at))?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <ul class="pagination">
        <li class="page-item">
            <a href="<?=$notices->prev ? "/notice?id=".$notice->prevNo : "#" ?>" class="page-link"><i class="fa fa-angle-left"></i></a>
        </li>
        <?php for($i = $notices->start; $i <= $notices->end; $i++):?>
        <li class="page-item<?=$notices->page == $i ? " active" : ""?>">
            <a href="/notice?page=<?=$i?>" class="page-link"><?=$i?></a>
        </li>
        <?php endfor?>
        <li class="page-item">
            <a href="<?=$notices->next ? "/notice?id=".$notice->nextNo : "#" ?>" class="page-link"><i class="fa fa-angle-right"></i></a>
        </li>
    </ul>
</div>

<form id="write-modal" class="modal fade" method="post" enctype="multipart/form-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>공지 작성</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">제목</label>
                    <input type="text" id="title" class="form-control" name="title" required>
                </div>
                <div class="form-group">
                    <label for="contents">내용</label>
                    <textarea class="form-control" name="contents" id="contents" cols="30" rows="10" required></textarea>
                </div>
                <div class="form-group">
                    <label for="uploads">첨부파일</label>
                    <input type="file" id="uploads" name="uploads[]" class="form-control" multiple>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">작성 완료</button>
                </div>
            </div>
        </div>
    </div>
</form>