<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Book extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['js'][] = 'nav.js';
        $this->_generate(array("nav"));
    }

    public function view($id) {
        $data["book"] = $this->BookModel->getBookById($id);
        $data["classification"] = $this->ClassificationModel->getClassificationById($data["book"]["classification"]);
        $data["userdata"] = $this->session->userdata;
        $booktype = $this->TypeModel->getTypeByName("book");
        $data["comments"] = $this->CommentModel->getCommentsByTarget($data["book"]["id"], $booktype["id"]);
        $data["notes"] = $this->getallnotes($data);
        $data["peopleReadBook"] = $this->getpeoplewhoreadsthebook($data);
        $data["favbooks"] = $this->BookModel->getBooksByClassfication($data["book"]["classification"]);
        $data["css"][] = "book.css";
        $data["css"][] = "tagview.css";
        $data["js"][] = "foreverybook.js";
        $data["js"][] = "tagview.js";
        $data["title"] = $data["book"]["name"] . " Book View";
        $data["cur_user"] = null;
        $data["target_type"] = $this->TypeModel->getTypeByName('book');
        $data["target_id"] = $id;
        $data["islogin"] = isset($data["userdata"]["islogin"]) && $data["userdata"]["islogin"];
        $tagtargets = $this->TagTargetModel->getTagTargetByTargetTypeAndId($data["target_type"]['id'], $data["target_id"]);
        $data["tags"] = $this->TagModel->getTagsByTagtargets($tagtargets);
        $data["tag_span"] = $this->load->view('tagview', $data, true);
        $this->_generate(array("book/for_every_book"), $data);
    }

    public function getallnotes($data) {
        if (!isset($data["userdata"]["islogin"]) || !$data["userdata"]["islogin"]) {
            return null;
        }

        $booktype = $this->TypeModel->getTypeByName("book");
        $notes = $this->NoteModel->getNotesByTarget($data["book"]["id"], $booktype["id"]);
        $newnotes = null;

        foreach ($notes as $note) {
            if ($this->UserModel->is_friend($data["userdata"]["id"], $note["user_id"]) || (
                    $note["for_group"] != 0 && $this->UserModel->is_group_friend($data["userdata"]["id"], $note["user_id"]) )
                    || $data["userdata"]["id"] == $note["user_id"]) {
                $newnotes[] = $note;
            }
        }

        return $newnotes;
    }

    public function getpeoplewhoreadsthebook($data) {

        $peopleid = null;
        foreach ($data["comments"] as $comment) {
            $peopleid[] = $comment["user_id"];
        }

        $booktype = $this->TypeModel->getTypeByName("book");
        $notes = $this->NoteModel->getNotesByTarget($data["book"]["id"], $booktype["id"]);

        foreach ($notes as $note) {
            $peopleid[] = $note["user_id"];
        }

        if (!isset($peopleid)) {
            return null;
        }
        $newuserid = array_flip(array_flip($peopleid));

        $peopleReadBook = null;
        foreach ($newuserid as $nid) {
            $peopleReadBook[] = $this->UserModel->getUserById($nid);
        }
        return $peopleReadBook;
    }

    public function addcommentsandnotes($bookid) {
        $comments = $this->input->post('comments');
        $notes = $this->input->post('notes');

        $bookcomments = null;
        $bookcomments["success"] = false;

        if (!empty($comments)) {
            $id = $this->CommentModel->getInsertId();
            $userid = $this->session->userdata["id"];
            $target_type = $this->TypeModel->getTypeByName("book");
            $target_id = $bookid;
            $pub_time = $mod_time = date("Y-m-d H:i:s");


            $newcomments = array(
                "id" => $id,
                "user_id" => $userid,
                "target_type" => $target_type["id"],
                "target_id" => $target_id,
                "comment" => $comments,
                "pub_time" => $pub_time,
                "mod_time" => $mod_time,
            );

            $bookcomments["success"] = $this->CommentModel->addComment($newcomments);
            $user_url = base_url("index.php/user/showuser/{$id}");
            $new_avatar = base_url() . "/img/avatar/" . $this->session->userdata['avatar'];
            $new_name = $this->session->userdata["nickname"];
            $bookcomments["msg"] = "
                <div class = 'comment_user_part'>
                        <div class = 'comment_user_photo'>
                            <a href='{$user_url}' target ='_blank'>
                                <img class ='user_img' src='{$new_avatar }' alt='暂时无法显示图片'/>                    
                            </a>
                        </div>
                        <div>
                            <div class = 'comment_word'>
                                <span class = 'comment_user_name'>{$new_name }</span>评论:<br/>
                               {$comments}<br>
                                <span class ='comment_time'>{$pub_time}</span><br/>
                            </div>
                        </div>
                    </div>
";
            echo json_encode($bookcomments);
        } else if (!empty($notes)) {
            $page_num = $this->input->post('page_num');
            $id = $this->NoteModel->getInsertId();
            $userid = $this->session->userdata["id"];
            $target_type = $this->TypeModel->getTypeByName("book");
            $target_id = $bookid;
            $pub_time = $mod_time = date("Y-m-d H:i:s");
            $for_group = $this->input->post('for_group');

            $newnotes = array(
                "id" => $id,
                "user_id" => $userid,
                "target_type" => $target_type["id"],
                "target_id" => $target_id,
                "page_num" => $page_num,
                "note" => $notes,
                "pub_time" => $pub_time,
                "mod_time" => $mod_time,
                "for_group" => $for_group,
            );

            $bookcomments["success"] = $this->NoteModel->addNotes($newnotes);
            $user_url = base_url("index.php/user/showuser/{$id}");
            $new_avatar = base_url() . "/img/avatar/" . $this->session->userdata['avatar'];
            $new_name = $this->session->userdata["nickname"];
            $bookcomments["msg"] = "
               <div class = 'notes_user_part'>
                            <div class = 'notes_user_photo'>
                                <a href='{$user_url }' target ='_blank'>
                                    <img class ='user_img' src='{$new_avatar}' alt='暂时无法显示图片'/>                    
                                </a>                               </div>
                            <div class = 'notes_word'>
                                <span class = 'note_user_name'>{$new_name}</span>在第
                                <span class = 'note_user_name'>{$page_num}</span>页说道:<br>
                                {$notes}
                                <span class ='note_time'>{$pub_time}</span><br>
                            </div>
                        </div>
";
            echo json_encode($bookcomments);
        } else {
            echo json_encode($bookcomments);
        }
    }

    public function addbook() {
        $data = null;
        $data["css"][] = "addbook.css";
        $data["title"] = "Add a book - On My Notes - Washing Machie";

        $this->_generate(array("book/addbook"), $data);
        /*
          $this->load->helper(array('form', 'url'));
          $this->load->library('form_validation');

          $this->form_validation->set_rules('bookname', 'need book name', 'required');
          $this->form_validation->set_rules('bookisbn13', 'book isbn should have 13 digits', 'exact_length( 13 )');
          $this->form_validation->set_rules('bookisbn10', 'book isbn should have 10 digits', 'exact_length( 10 )');
          if ($this->form_validation->run() == FALSE){
          $this->_generate(array("book/addbook"), $data);
          }
          else{
          $this->load->view('formsuccess');
          } */
    }

    public function formresult() {
        $data = null;
        $data["success"] = false;

        $bookid = $this->BookModel->getInsertId();
        $bookname = $this->input->post('bookname');
        $bookauthor = $this->input->post('bookauthor');
        $bookisbn13 = $this->input->post('bookisbn13');
        $bookisbn10 = $this->input->post('bookisbn10');
        $bookintro = $this->input->post('bookintro');
        $bookclassification = $this->input->post('Classification');

        if (!empty($bookname)) {
            $newbook = array(
                "id" => $bookid,
                "name" => $bookname,
                "isbn13" => $bookisbn13,
                "isbn10" => $bookisbn10,
                "author" => $bookauthor,
                "intro" => $bookintro,
                "Classification" => $bookclassification,
            );

            $data["success"] = $this->BookModel->addBook($newbook);
        }

        $this->_generate(array("formresult"), $data);
    }

    private function _generate($pages=array(), $data=array()) {
        $data["body_content"] = "";
        foreach ($pages as $page) {
            $data["body_content"] .= $this->load->view($page, $data, true);
        }
        $this->load->view("base", $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */