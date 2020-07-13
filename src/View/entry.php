<div class="work-container py-5">
        <!-- 도구 영역 -->
        <div id="tool-bar" class="d-flex border-bottom py-2 mb-4">
            <span class="tool" data-role="select" title="선택 도구">
                <i class="fa fa-mouse-pointer"></i>
            </span>
            <span class="tool" data-role="spin" title="회전 도구">
                <i class="fa fa-rotate-left"></i>
            </span>
            <span class="tool" data-role="cut" title="자르기 도구">
                <i class="fa fa-cut"></i>
            </span>
            <span class="tool" data-role="glue" title="붙이기 도구">
                <i class="fa fa-object-ungroup"></i>
            </span>
            <button class="tool-btn" data-toggle="modal" data-target="#paper-modal" title="추가하기">
                <i class="fa fa-folder-open"></i>
            </button>
            <button class="tool-btn" data-role="remove-paper" title="삭제하기">
                <i class="fa fa-trash"></i>
            </button>
        </div>
        <!-- 도구 영역 -->
        <!-- 작업 영역 -->
        <canvas id="workspace" width="1000" height="600"></canvas>
        <!-- /작업 영역 -->
    </div>

    <!-- 한지 모달 -->
    <div id="paper-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">추가하기</div>
                <div class="modal-body">
                    <div id="paper-list" class="list-group">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /한지 모달 -->


    <!-- 출품정보 입력 영역 -->
    <div class="container py-5">
        <form id="entry_form" method="post">
            <input type="hidden" id="entry_image" name="image">
            <div class="form-group">
                <label for="entry_title">제목</label>
                <input type="text" id="entry_title" class="form-control" name="title" required>
            </div>

            <div class="form-group">
                <label for="entry_description">설명</label>
                <input type="text" id="entry_description" class="form-control" name="contents" required>
            </div>

            <div class="form-group">
                <label for="entry_hash_tags">해시태그</label>
                <div id="entry_hash_tags" class="hash-module"></div>
            </div>
            <input type="submit" id="" class="form-control" value="출품하기">
        </form>
    </div>
    <!-- /출품정보 입력 영역 -->


    <!-- 도움말 영역 -->
    <div class="container py-5">
        <div class="advice-container py-5">
            <div id="advice-search">
                <div class="form-group col-3">
                    <label for="search_form">검색</label>
                    <input type="text" class="form-control" id="search_form">
                    <span id="search_status"></span>
                </div>
                <div class="form-group col-3">
                    <button class="btn btn-primary" id="search_btn">검색</button>
                    <button class="btn btn-primary" id="search_prev">이전</button>
                    <button class="btn btn-primary" id="search_next">다음</button>
                </div>
            </div>  

        <!-- 도움말 영역 -->
            
            <ul class="nav nav-tabs" id="search_nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#select_advice" id="select_tab" data-toggle="tab" role="tab" aria-controls="select_advice" aria-selected="true">선택</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#rotate_advice" id="rotate_tab" data-toggle="tab" role="tab" aria-controls="rotate_advice" aria-selected="false">회전</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#cut_advice" id="cut_tab" data-toggle="tab" role="tab" aria-controls="cut_advice" aria-selected="false">자르기</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#glue_advice" id="glue_tab" data-toggle="tab" role="tab" aria-controls="glue_advice" aria-selected="false">붙이기</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="select_advice" role="tabpanel" aria-labelledby="select_tab">
                    선택 도구는 가장 기본적인 도구로써, 작업 영역 내의 한지를 선택할 수 있게 합니다. 
                    마우스 클릭으로 한지를 활성화하여 이동시킬 수 있으며, 선택된 한지는 삭제 버튼으로 삭제시킬 수 있습니다.
                </div>
                <div class="tab-pane fade" id="rotate_advice" role="tabpanel" aria-labelledby="rotate_tab">
                    회전 도구는 작업 영역 내의 한지를 회전할 수 있는 도구입니다. 
                    마우스 더블 클릭으로 회전하고자 하는 한지를 선택하면, 좌우로 마우스를 끌어당겨 회전시킬 수 있습니다. 
                    회전한 뒤에는 우 클릭의 콘텍스트 메뉴로 '확인'을 눌러 한지의 회전 상태를 작업 영역에 반영할 수 있습니다.
                </div>
                <div class="tab-pane fade" id="cut_advice" role="tabpanel" aria-labelledby="cut_tab">
                    자르기 도구는 작업 영역 내의 한지를 자를 수 있는 도구입니다. 
                    마우스 더블 클릭으로 자르고자 하는 한지를 선택하면 마우스를 움직임으로써 자르고자 하는 궤적을 그릴 수 있습니다. 
                    궤적을 그린 뒤에는 우 클릭의 콘텍스트 메뉴로 '자르기'를 눌러 그려진 궤적에 따라 한지를 자를 수 있습니다.
                </div>
                <div class="tab-pane fade" id="glue_advice" role="tabpanel" aria-labelledby="glue_tab">
                    붙이기 도구는 작업 영역 내의 한지들을 붙일 수 있는 도구입니다.
                    마우스 더블 클릭으로 붙이고자 하는 한지를 선택하면 처음 선택한 한지와 근접한 한지들을 선택할 수 있습니다. 
                    붙일 한지를 모두 선택한 뒤에는 우 클릭의 콘텍스트 메뉴로 '붙이기'를 눌러 선택한 한지를 붙일 수 있습니다.
                </div>
            </div>
        </div>
    </div>
    
      <!-- /도움말 영역 -->

    <script src="/js/Tools/Tools.js"></script>
    <script src="/js/Tools/Cut.js"></script>
    <script src="/js/Tools/Glue.js"></script>
    <script src="/js/Tools/Select.js"></script>
    <script src="/js/Tools/Spin.js"></script>
    <script src="/js/Source.js"></script>
    <script src="/js/Part.js"></script>
    <script src="/js/Workspace.js"></script>
    <script src="/js/App.js"></script>