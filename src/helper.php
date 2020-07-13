<?php
function user(){
    return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}

function company(){
    return user() && user()->type === "company" ? user() : false;
}

function admin(){
    return user() && user()->email === "admin" ? user() : false;
}

function writer($uid){
    return user() && user()->id == $uid ? user() : false;
}

function go($url, $message){
    echo "<script>";
    echo "alert('$message');";
    echo "location.href='$url';";
    echo "</script>";
    exit;
}

function back($message){
    echo "<script>";
    echo "alert('$message');";
    echo "history.back();";
    echo "</script>";
    exit;
}

function json_response($data){
    header("Content-Type: application/json");
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function view($viewName, $data = []){
    extract($data);
    require VIEW.DS."layouts".DS."header.php";
    require VIEW.DS.$viewName.".php";
    require VIEW.DS."layouts".DS."footer.php";
    exit;
}

function extname($filename){
    return substr($filename, strrpos($filename, "."));
}

function pagination($page, $data){
    define("PAGE", 10); // 한 페이지당 존재할 수 있는 글의 수
    define("BLOCK", 5); // 한 페이지네이션 당 존재할 수 있는 페이지의 수

    $length = count($data);
    $pageLength = ceil($length / PAGE);
    $currentBlock = ceil($page / BLOCK);
    $start = $currentBlock;
    $end = $currentBlock + BLOCK - 1;
    $end = $end > $pageLength ? $pageLength : $end;
    
    $prev = true;
    $next = true;
    $prevNo = $start-1;
    $nextNo = $end+1;

    if($start - 1 < 1) $prev = false;
    if($end + 1 > $pageLength) $next = false;

    return (object)array_merge(
        compact("prev", "next", "start", "end", "page", "nextNo", "prevNo"),
        ["data" => array_slice($data, ($page - 1) * PAGE, PAGE)]
    );
}

function upload_file($filePath){
    $path = UPLOAD.DS.str_replace("/", DS, $filePath);
    $realname = substr($path, strrpos($path, DS) + 1);
    $filename = substr($realname, strrpos($realname, "-") + 1);
    $type = mime_content_type($path);
    $size = filesize($path);
    return (object)compact("path", "realname", "filename", "type", "size");
}