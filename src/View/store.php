<!-- 상품 리스트 영역 -->
<input type="hidden" id="uid" value="<?=user()->id?>">
<div class="container py-5">
    <div class="sticky-top d-flex justify-content-between align-items-center bg-white py-3 border-bottom mb-4">
        <div id="search">
            <div class="hash-module" id="search-hash"></div>
            <button id="search-btn" class="btn btn-primary">검색</button>
        </div>
        <?php if(company()):?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#add-modal">상품 등록</button>
        <?php endif ?>
    </div>
    <div class="row" id="paper_list">
    </div>
</div>
<!-- /상품 리스트 영역 -->

<!-- 상품 구매 영역 -->
<div class="container py-5">
    <table class="table">
        <thead>
            <tr>
                <th>이미지</th>
                <th>이름</th>
                <th>업체명</th>
                <th>포인트</th>
                <th>수량</th>
                <th>합계 포인트</th>
                <th>삭제</th>
            </tr>
        </thead>
        <tbody id="buy_list">
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"></td>
                <td>보유 포인트</td>
                <td><?=user()->point?>p</td>
                <td>총 합계 포인트</td>
                <td id="total_point">1000p</td>
                <td>
                    <button class="btn btn-primary" id="buy_btn">구매 완료</button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<!-- /상품 구매 영역 -->

<?php if(company()):?>
<!-- 상품 등록 모달 -->
<div id="add-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>상품 등록</h5>    
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="paper_image">이미지</label>
                        <div class="custom-file">
                            <input type="file" id="paper_image" class="custom-file-input" required>
                            <label for="paper_image" class="custom-file-label"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="paper_name">이름</label>
                        <input type="text" id="paper_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="company_name">업체명</label>
                        <input type="text" id="company_name" class="form-control" value="<?=company()->user_name?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="width_size">가로 사이즈</label>
                        <input type="number" id="width_size" class="form-control" value="100" required>
                    </div>
                    <div class="form-group">
                        <label for="height_size">세로 사이즈</label>
                        <input type="number" id="height_size" class="form-control" value="100" required>
                    </div>
                    <div class="form-group">
                        <label for="point">포인트</label>
                        <input type="number" id="point" class="form-control"  value="10" required>
                    </div>
                    <div class="form-group">
                        <label>해시태그</label>
                        <div class="hash-module" id="add-hash"></div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button class="btn btn-primary" id="add-btn" type="submit">추가완료</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /상품 등록 모달 -->
<?php endif;?>

<script src="/js/store.js"></script>