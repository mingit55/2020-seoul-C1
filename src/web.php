<?php
use App\Router;

// 메인
Router::get("/", "MainController@page_index");
Router::get("/intro", "MainController@page_intro");
Router::get("/map", "MainController@page_map");

// 공지사항
Router::get("/notices", "MainController@page_notices");
Router::post("/notices", "MainController@process_addNotice");
Router::get("/notice", "MainController@page_notice");
Router::post("/notice/edit", "MainController@process_editNotice");
Router::get("/notice/remove", "MainController@process_removeNotice");

// 1:1 문의
Router::get("/inquires", "MainController@page_inquires");
Router::post("/inquires", "MainController@process_addInquire");
Router::get("/inquire", "MainController@process_getInquire");
Router::post("/answers", "MainController@process_addAnswer");


// 회원관리
Router::get("/join", "UserController@page_join");
Router::post("/join", "UserController@process_join");
Router::get("/login", "UserController@page_login");
Router::post("/login", "UserController@process_login");
Router::get("/logout", "UserController@process_logout");

// 한지 업체
Router::get("/company", "UserController@page_company");

// 온라인스토어
Router::get("/store", "ArtworkController@page_store");
Router::get("/papers", "ArtworkController@process_getPaperAll");
Router::post("/papers", "ArtworkController@process_addPaper");
Router::post("/store", "ArtworkController@process_buy");

// 출품 신청
Router::get("/entry", "ArtworkController@page_entry");
Router::get("/has-papers", "ArtworkController@process_getMyPaper");
Router::post("/take-paper", "ArtworkController@process_takePaper");
Router::post("/entry", "ArtworkController@process_entry");

// 참가 작품
Router::get("/artworks", "ArtworkController@page_artworks");
Router::get("/artworks/hash-tags", "ArtworkController@process_getHashTags");
Router::get("/artwork", "ArtworkController@page_artwork");
Router::post("/artworks/scores", "ArtworkController@process_score");
Router::get("/artwork/delete", "ArtworkController@process_deleteForWriter");
Router::post("/artwork/delete", "ArtworkController@process_deleteForAdmin");
Router::post("/artwork/edit", "ArtworkController@process_edit");

Router::start();