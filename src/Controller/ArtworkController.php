<?php
namespace Controller;

use App\DB;

class ArtworkController {
    // 스토어 페이지
    function page_store(){
        if(!user()) go("/", "로그인 후 이용하실 수 있습니다.");
        view("store");
    }
    function process_getPaperAll(){
        $papers = DB::fetchAll("SELECT P.*, user_name company_name
                                FROM papers P 
                                LEFT JOIN users U ON U.id = P.uid
                                ORDER BY P.id DESC");
        foreach($papers as $paper){
            $paper->hash_tags = [];
            foreach(DB::fetchAll("SELECT name FROM paper_tags WHERE pid = ?", [$paper->id]) as $tag){
                $paper->hash_tags[] = $tag->name;
            }
        }
        json_response(compact("papers"));
    }
    function process_addPaper(){
        if(!company()) exit;

        extract($_POST);
        
        // 이미지 저장
        $split = explode(";base64,", $image);
        $extname = explode("/", $split[0])[1];
        $imageData = base64_decode($split[1]);
        $filename = time() . "." . $extname;
        file_put_contents(UPLOAD.DS."papers".DS.$filename, $imageData);
        
        // DB 저장
        DB::query("INSERT INTO papers(paper_name, uid, width_size, height_size, image, point) VALUES (?, ?, ?, ?, ?, ?)", [
            $paper_name,
            user()->id,
            $width_size,
            $height_size,
            $filename,
            $point
        ]);
        $pid = DB::lastInsertId();

        // 해시태그 저장
        foreach($hash_tags as $tag){
            DB::query("INSERT INTO paper_tags(name, pid) VALUES (?, ?)", [$tag, $pid]);
        }


        // 보유 한지에 무한히 사용할 수 있도록 추가
        DB::query("INSERT INTO has_papers(uid, pid, count, infinity) VALUES (?, ?, ?, 1)", [user()->id, $pid, 1]);

        json_response(DB::find("papers", $pid));
    }
    function process_buy(){
        extract($_POST);

        if(!user()) exit;
        if(admin()) json_response(["message" => "관리자는 해당 서비스를 이용할 수 없습니다."]);
        if(user()->point < $totalPoint) json_response(["message" => "포인트가 부족하여 구매하실 수 없습니다."]);
        
        foreach($list as $buyItem){
            $buyItem = (object)$buyItem;

            // 기업 포인트 갱신
            DB::query("UPDATE users SET point = point + ? WHERE id = ?", [$buyItem->point * $buyItem->cnt, $buyItem->uid]);

            // 구매 내역 작성
            DB::query("INSERT INTO sale_history(cid, point) VALUES (?, ?)", [$buyItem->uid, $buyItem->point * $buyItem->cnt]);

            // 보유 한지에 추가
            $exist = DB::fetch("SELECT * FROM has_papers WHERE uid = ? AND pid = ?", [user()->id, $buyItem->id]);
            if(!$exist) DB::query("INSERT INTO has_papers(uid, pid, count) VALUES (?, ?, ?)", [user()->id, $buyItem->id, $buyItem->cnt]);
            else DB::query("UPDATE has_papers SET count = count + ? WHERE id = ?", [$buyItem->cnt, $exist->id]);
        }

        // 유저 포인트 차감
        DB::query("UPDATE users SET point = point - ? WHERE id = ?", [$totalPoint, user()->id]);
    }

    // 출품 신청
    function page_entry(){
        if(!user()) go("/", "로그인 후 이용하실 수 있습니다.");
        if(admin()) back("관리자는 해당 서비스를 이용할 수 없습니다.");
        view("entry");
    }   

    function process_getMyPaper(){
        if(!user()) exit;

        $papers = DB::fetchAll("SELECT DISTINCT H.*, P.image, paper_name, width_size, height_size, user_name company_name
                FROM has_papers H
                LEFT JOIN papers P ON H.pid = P.id
                LEFT JOIN users U ON U.id = P.uid
                WHERE H.uid = ?
                ORDER BY P.id DESC", [user()->id]);

        foreach($papers as $paper){
            $paper->hash_tags = [];
            foreach(DB::fetchAll("SELECT name FROM paper_tags WHERE pid = ?", [$paper->id]) as $tag){
                $paper->hash_tags[] = $tag->name;
            }
        }

        json_response(compact("papers"));
    }

    function process_takePaper(){
        extract($_POST);

        $paper = DB::find("has_papers", $id);
        if(!$paper || !user() || $paper->uid !== user()->id) exit;

        if($paper->count - 1 <= 0 && !$paper->infinity){
            DB::query("DELETE FROM has_papers WHERE id = ?", [$paper->id]);
        } else {
            DB::query("UPDATE has_papers SET count = count - 1 WHERE id = ?", [$paper->id]);
        }
    }

    function process_entry(){
        extract($_POST);

        if(admin()) back("관리자는 해당 서비스를 이용할 수 없습니다.");

        // 이미지 저장
        $split = explode(";base64,", $image);
        $extname = explode("/", $split[0])[1];
        $imageData = base64_decode($split[1]);
        $filename = time() . "." . $extname;
        file_put_contents(UPLOAD.DS."artworks".DS.$filename, $imageData);

        // DB저장
        DB::query("INSERT INTO artworks(title, contents, uid, image, tags) VALUES (?, ?, ?, ?, ?)", [$title, $contents, user()->id, $filename, $hash_tags]);
        $aid = DB::lastInsertId();
        
        // 태그저장
        foreach(json_decode($hash_tags) as $tag){
            DB::query("INSERT INTO artwork_tags(aid, name) VALUES (?, ?)", [$aid, $tag->data]);
        }
        
        go("/artworks", "출품이 완료되었습니다.");
    }



    // 출품 작품
    function page_artworks(){
        $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;
        $keyword = "";
        $where = "";

        if(isset($_GET['hash_tags'])){
            $keyword = $_GET['hash_tags'];
            $_keyword_arr = json_decode($keyword);
            $keyword_arr = [];
            foreach($_keyword_arr as $item) $keyword_arr[] = "'$item->data'";
            $inWhere = implode(", ", $keyword_arr);
            
            $where = "WHERE A.id IN (SELECT aid FROM artwork_tags WHERE name IN ($inWhere))";

            if(count($keyword_arr) === 0){
                $keyword = "";
                $where = "";
            } else {
                $keyword = "&hash_tags=" . urlencode($keyword);
            }
        }


        view("artworks", [
            "myList" => user() ? 
                array_merge(
                    DB::fetchAll("SELECT DISTINCT A.*, user_name, type, IFNULL(total, 0) total
                                    FROM artworks A 
                                    LEFT JOIN users U ON U.id = A.uid 
                                    LEFT JOIN (SELECT ROUND(AVG(score), 1) total, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                    WHERE uid = ?", [user()->id]),
                    DB::fetchAll("SELECT DISTINCT A.*, user_name, 1 deleted, type, IFNULL(total, 0) total
                                    FROM artwork_bin A 
                                    LEFT JOIN users U ON U.id = A.uid 
                                    LEFT JOIN (SELECT ROUND(AVG(score), 1) total, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                    WHERE uid = ?", [user()->id])
                ) : [],
            "ranker" => DB::fetchAll("SELECT DISTINCT A.*, user_name, type, IFNULL(total, 0) total
                                        FROM artworks A 
                                        LEFT JOIN users U ON U.ID = A.uid 
                                        LEFT JOIN (SELECT ROUND(AVG(score), 1) total, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                        WHERE DATEDIFF(NOW(), A.created_at) <= 7
                                        ORDER BY total DESC
                                        LIMIT 0, 4"),
            "artworks" => pagination($page, DB::fetchAll("SELECT DISTINCT A.*, user_name, type, IFNULL(total, 0) total
                                                            FROM artworks A 
                                                            LEFT JOIN users U ON U.ID = A.uid
                                                            LEFT JOIN (SELECT ROUND(AVG(score), 1) total, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                                            $where")),
            "keyword" => $keyword
        ]);
    }

    function process_getHashTags(){
        $tags = [];
        $_tags = DB::fetchAll("SELECT DISTINCT name FROM artwork_tags");
        foreach($_tags as $tag) $tags[] = $tag->name;
        json_response($tags);
    }

    function page_artwork(){
        $artwork = DB::fetch("SELECT DISTINCT A.*, IFNULL(total, 0) total
                                FROM artworks A
                                LEFT JOIN (SELECT ROUND(AVG(score), 1) total, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                WHERE A.id = ?", [$_GET['id']]);
        if(!$artwork) back("해당 게시글이 존재하지 않습니다.");
            
        $scored = DB::fetch("SELECT * FROM scores WHERE uid = ? AND aid = ? ", [user() ? user()->id : 0, $artwork->id]) != false;

        $writer = DB::find("users", $artwork->uid);
        
        view("artwork", compact("artwork", "writer", "scored"));
    }

    function process_score(){
        if(admin()) back("관리자는 해당 서비스를 이용할 수 없습니다.");
        extract($_POST);
        $artwork = DB::find("artworks", $aid);
        if(!$artwork) back("해당 작품이 존재하지 않습니다.");
        DB::query("INSERT INTO scores(uid, aid, score) VALUES (?, ?, ?)", [user()->id, $aid, $score]);
        go("/artwork?id=$aid", "평점이 반영되었습니다.");
    }

    function process_deleteForWriter(){
        $artwork = DB::find("artworks", $_GET['id']);
        if(!$artwork) back("해당 작품이 존재하지 않습니다.");
        if(!writer($artwork->uid)) back("권한이 없습니다.");

        DB::query("DELETE FROM artworks WHERE id = ?", [$artwork->id]);
        go("/artworks", "삭제되었습니다.");
    }

    function process_deleteForAdmin(){
        extract($_POST);
        $artwork = DB::find("artworks", $aid);
        if(!$artwork) back("해당 작품이 존재하지 않습니다.");
        if(!admin()) back("권한이 없습니다.");

        DB::query("DELETE FROM artworks WHERE id = ?", [$artwork->id]);
        DB::query("INSERT INTO artwork_bin(id, title, contents, uid, image, created_at, tags, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [
            $artwork->id,
            $artwork->title,
            $artwork->uid,
            $artwork->image,
            $artwork->created_at,
            $artwork->tags,
            $comment
        ]);

        go("/artworks", "삭제되었습니다.");
    }

    function process_edit(){
        $artwork = DB::find("artworks", $_GET['id']);
        if(!$artwork) back("해당 작품이 존재하지 않습니다.");
        if(!writer($artwork->uid)) back("권한이 없습니다.");                      
    }
}