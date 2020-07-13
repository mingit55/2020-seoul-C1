<?php 
namespace Controller;

use App\DB;

class MainController {
    function page_index(){
        view("index");
    }

    function page_intro(){
        view("intro");
    }

    function page_map(){
        view("map");
    }

    function page_notices(){
        $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;
        $notices = DB::fetchAll("SELECT * FROM notices ORDER BY id DESC");
        view("notice", ["notices" => pagination($page, $notices)]);
    }
    function page_notice(){
        $notice = DB::find("notices", $_GET['id']);
        if(!$notice) back("게시물이 존재하지 않습니다.");
        view("notice-view", ["notice" => $notice]);
    }
    function process_addNotice(){
        extract($_POST);
        
        if(mb_strlen($title) > 50) back("제목은 50자 이하여야 합니다.");
        
        $uploads = $_FILES['uploads'];
        $length = $uploads['name'][0] !== "" ? count($uploads['name']) : 0;
        $filenames = [];
        if($length > 4)  back("파일은 4개까지 업로드할 수 있습니다.");
        
        for($i = 0; $i < $length; $i++){
            if($uploads['size'][$i] > 1024 * 1024 * 10) back("10MB 이하의 파일만 업로드할 수 있습니다.");
            $filename = $i.time()."-".$uploads['name'][$i];
            $filePath = UPLOAD.DS."notices".DS.$filename;
            move_uploaded_file($uploads['tmp_name'][$i], $filePath);
            $filenames[] = $filename;
        }

        DB::query("INSERT INTO notices(title, contents, files) VALUES (?, ?, ?)", [$title, $contents, json_encode($filenames)]);

        go("/notices", "공지사항이 작성되었습니다.");
    }
    function process_editNotice(){
        $notice = DB::find("notices", $_GET['id']);
        if(!$notice) back("게시물이 존재하지 않습니다.");
        if(!admin()) back("권한이 없습니다.");
        extract($_POST);

        if(mb_strlen($title) > 50) back("제목은 50자 이하여야 합니다.");

        $uploads = $_FILES['uploads'];
        $length = $uploads['name'][0] !== "" ? count($uploads['name']) : 0;
        $filenames = [];

        for($i = 0; $i < $length; $i++){
            if($uploads['size'][$i] > 1024 * 1024 * 10) back("10MB 이하의 파일만 업로드할 수 있습니다.");
            $filename = $i.time()."-".$uploads['name'][$i];
            $filePath = UPLOAD.DS."notices".DS.$filename;
            move_uploaded_file($uploads['tmp_name'][$i], $filePath);
            $filenames[] = $filename;
        }

        DB::query("UPDATE notices SET title = ?, contents = ?, files = ? WHERE id = ?", [
            $title, $contents, json_encode($filenames), $notice->id
        ]);
        go("/notice?id={$notice->id}", "수정되었습니다.");
    }
    function process_removeNotice(){
        $notice = DB::find("notices", $_GET['id']);
        if(!$notice) back("게시물이 존재하지 않습니다.");
        if(!admin()) back("권한이 없습니다.");
        
        DB::query("DELETE FROM notices WHERE id = ?", [$notice->id]);
        go("/notices", "공지사항이 삭제되었습니다.");
    }



    function page_inquires(){
        if(admin()){
            view("inquire-admin", [
                "inquire" => DB::fetchAll("SELECT I.*, A.id status
                                            FROM inquires I
                                            LEFT JOIN answers A ON A.iid = I.id", [user()->id])
                ]
            );
        } 
        else if(user()) {
            view("inquire-user", [
                "inquire" => DB::fetchAll("SELECT I.*, A.id status
                                            FROM inquires I
                                            LEFT JOIN answers A ON A.iid = I.id
                                            WHERE I.uid = ?", [user()->id])
            ]);
        } 
        else {
            go("/login", "로그인 후 이용하실 수 있습니다.");
        }
    }

    function process_addInquire(){
        extract($_POST);       

        if(mb_strlen($title) > 50) back("제목은 50자 이하여야 합니다.");
        DB::query("INSERT INTO inquires(uid, title, contents) VALUES (?, ?, ?)" ,[user()->id, $title, $contents]);
        go("/inquires", "작성되었습니다.");
    }

    function process_getInquire(){
        $inquire = DB::fetch("SELECT I.*, user_name, email FROM inquires I LEFT JOIN users U ON U.id = I.uid WHERE I.id = ?", [$_GET['id']]);
        if(!$inquire) json_response("문의가 존재하지 않습니다");
        
        $answer = DB::fetch("SELECT * FROM answers WHERE iid = ?", [$inquire->id]);
        json_response(["inquire" => $inquire, "answer" => $answer]);
    }

    function process_addAnswer(){
        if(!admin()) back("권한이 없습니다.");
        extract($_POST);

        $inquire = DB::find("inquires", $iid);
        if(!$inquire) back("해당 문의가 존재하지 않습니다.");
        
        DB::query("INSERT INTO answers(iid, contents) VALUES (?, ?)", [$iid, $contents]);
        go("/inquires", "답변이 완료되었습니다.");
    }
}