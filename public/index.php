<?php
session_start();

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__));
define("SRC", ROOT.DS."src");
define("VIEW", SRC.DS."View");
define("UPLOAD", ROOT.DS."public".DS."uploads");

require SRC.DS."autoload.php";
require SRC.DS."helper.php";

use App\DB;
// 매 페이지 로드마다 어드민이 없으면 추가생성함
$admin = DB::who("admin");
if(!$admin){
    DB::query("INSERT INTO users(email, password, user_name, type, image) VALUES (?, ?, ?, ?, ?)", [
        "admin", 
        hash("sha256", "1234"),
        "관리자",
        "normal",
        ""
    ]);
}
// 로그인 시, 매 페이지 로드마다 갱신된 유저 정보를 가져옴
if(user()){
    $_SESSION['user'] = DB::find("users", user()->id);
}


require SRC.DS."web.php";