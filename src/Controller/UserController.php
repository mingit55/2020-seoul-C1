<?php
namespace Controller;

use App\DB;

class UserController {
    function page_login(){
        view("login");
    }
    function process_login(){
        extract($_POST);

        $user = DB::who($email);
        if(!$user) back("아이디와 일치하는 회원이 존재하지 않습니다.");
        if($user->password !== hash("sha256", $password)) back("비밀번호가 일치하지 않습니다.");
        
        $_SESSION['user'] = $user;

        go("/", "로그인 되었습니다.");
    }

    function page_join(){
        view("join");
    }
    function process_join(){
        extract($_POST);
        
        $user = DB::who($email);
        if($user) back("이미 사용 중인 이메일입니다.");
    
        $image = $_FILES['profile'];
        $filename = time() . extname($image['name']);
        move_uploaded_file($image['tmp_name'], UPLOAD.DS."users".DS.$filename);

        DB::query("INSERT INTO users(email, password, user_name, type, image) VALUES (?, ?, ?, ?, ?)", [
            $email,
            hash("sha256", $password),
            $name,
            $type,
            $filename
        ]);

        exit;
        go("/", "정상적으로 회원가입 되었습니다.");
    }

    function process_logout(){
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }


    function page_company(){
        $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;

        $companies = DB::fetchAll("SELECT U.*, IFNULL(H.total, 0) total
            FROM users U
            LEFT JOIN (SELECT SUM(point) total, cid FROM sale_history ORDER BY cid) H ON H.cid = U.id
            WHERE U.type = 'company'
            ORDER BY total DESC");
        view("company", [
            "ranker" => array_slice($companies, 0, 4),
            "companies" => pagination($page, array_slice($companies, 4))
        ]);
    }
}