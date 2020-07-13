<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>전주한지문화축제</title>
    <script src="/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/HashModule.css">
    <script src="/js/HashModule.js"></script>
    <script src="/js/IDB.js"></script>
</head>
<body>
    <!-- 헤더 영역 -->
    <input type="checkbox" id="open-nav" hidden>
    <div id="top" class="d-none d-lg-block bg-dark">
        <div class="container">
            <div class="text-right">
                <?php if(user()):?>
                    <span class="text-white mr-2"><?=user()->user_name?>(<?=user()->point?>p)</span>
                    <a href="/logout" class="mr-3">로그아웃</a>
                <?php else:?>
                    <a href="/login" class="mr-3">로그인</a>
                    <a href="/join" class="mr-3">회원가입</a>
                <?php endif;?>
            </div>
        </div>
    </div>
    <header>
        <div class="container d-flex align-items-center justify-content-between h-100">
            <a href="/" class="logo">
                전주한지문화축제
            </a>
            <nav class="d-none d-lg-flex">
                <div class="nav-group">
                    <a href="/intro">전주한지문화축제</a>
                    <div class="sub-list">
                        <a href="/intro">개요/연혁</a>
                        <a href="/map">찾아오시는길</a>
                    </div>
                </div>
                <div class="nav-group">
                    <a href="/company">한지상품판매관</a>
                    <div class="sub-list">
                        <a href="/company">한지업체</a>
                        <a href="/store">온라인스토어</a>
                    </div>
                </div>
                <div class="nav-group">
                    <a href="/entry">한지공예대전</a>
                    <div class="sub-list">
                        <a href="/entry">출품신청</a>
                        <a href="/artworks">참가작품</a>
                    </div>
                </div>
                <div class="nav-group">
                    <a href="/notices">축제공지사항</a>
                    <div class="sub-list">
                        <a href="/notices">알려드립니다</a>
                        <a href="/inquires">1:1문의</a>
                    </div>
                </div>
            </nav>
            <label for="open-nav" class="menu-icon d-lg-none">
                <span></span>
                <span></span>
                <span></span>
            </label>
        </div>
    </header>
    <label for="open-nav" id="aside-background" class="d-lg-none"></label>
    <aside class="d-lg-none">
        <div class="nav-group">
            <a href="/intro">전주한지문화축제</a>
            <div class="sub-list">
                <a href="/intro">개요/연혁</a>
                <a href="/map">찾아오시는길</a>
            </div>
        </div>
        <div class="nav-group">
            <a href="/company">한지상품판매관</a>
            <div class="sub-list">
                <a href="/company">한지업체</a>
                <a href="/store">온라인스토어</a>
            </div>
        </div>
        <div class="nav-group">
            <a href="#">한지공예대전</a>
            <div class="sub-list">
                <a href="/entry">출품신청</a>
                <a href="/artworks">참가작품</a>
            </div>
        </div>
        <div class="nav-group">
            <a href="/notices">축제공지사항</a>
            <div class="sub-list">
                <a href="/notices">알려드립니다</a>
                <a href="/inquires">1:1문의</a>
            </div>
        </div>
        <div class="auth pl-3 mt-3">
        <?php if(user()):?>
            <span class="mr-2"><?=user()->user_name?>(<?=user()->point?>p)</span>
            <a href="/logout" class="mr-2">로그아웃</a>
        <?php else:?>
            <a href="/login" class="mr-2">로그인</a>
            <a href="/join" class="mr-2">회원가입</a>
        <?php endif;?>
        </div>
    </aside>
    <!-- /헤더 영역 -->