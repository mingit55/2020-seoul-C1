<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center">
        <h4>1:1 문의하기</h4>
    </div>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th>상태</th>
                <th>제목</th>
                <th>문의 일자</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($inquire as $item):?>
            <tr data-toggle="modal" data-target="#view-modal" data-id="<?=$item->id?>">
                <td>
                    <span class="badge badge-primary"><?= $item->status ? "완료" : "진행 중" ?></span>
                </td>
                <td>
                    <?=$item->title?>
                </td>
                <td><?=date("Y-m-d", strtotime($item->created_at))?></td>
                <td>
                    <?php if(!$item->status):?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#write-modal" data-id="<?=$item->id?>">답변하기</button>
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<div id="view-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body py-4">
                
            </div>
        </div>
    </div>
</div>

<form id="write-modal" class="modal fade" action="/answers" method="post">
    <input type="hidden" id="iid" name="iid">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>답변하기</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="contents">내용</label>
                    <textarea name="contents" id="contetns" cols="30" rows="10" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button class="btn btn-primary">답변하기</button>
            </div>
        </div>
    </div>
</form>

<script>
    $("[data-target='#write-modal']").on("click", function(e){
        e.stopPropagation();
        $("#iid").val(this.dataset.id);
        $("#write-modal").modal("show");
    });

    $("[data-target='#view-modal']").on("click", function(e){
        let id = $(this).data("id");
        $.getJSON("/inquire?id="+id, function(res){
            const {inquire, answer} = res;

            let html = `<h5 class="title">${inquire.title}</h5>
                <div>
                    <span class="badge badge-primary mr-2">${inquire.user_name}(${inquire.email})</span>
                    <span class="badge badge-primary mr-2">${inquire.created_at.split(' ')[0]}</span>
                </div>
                <div class="contents mt-3">${inquire.contents}</div>
                <hr>`;
            
            if(answer){
                html += `<div>
                            <div><span class="badge badge-primary">${answer.created_at.split(' ')[0]}</span></div>
                            <div class="mt-3">${answer.contents}</div>
                        </div>`;
            } else {
                html += `<div class="text-muted">문의에 대한 답변이 오지 않았습니다.</div>`;
            }

            console.log(html);
            $("#view-modal .modal-body").html(html);
        });
    });
</script>