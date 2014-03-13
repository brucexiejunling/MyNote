<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paper extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['js'][] = 'nav.js';
        $this->_generate(array("nav"));
    }

    public function view($id) {
        $data["paper"] = $this->PaperModel->getPaperById($id);
        $data["classification"] = $this->ClassificationModel->getClassificationById($data["paper"]["classification"]);
        $data["userdata"] = $this->session->userdata;
        $papertype = $this->TypeModel->getTypeByName("paper");
        $data["comments"] = $this->CommentModel->getCommentsByTarget($data["paper"]["id"], $papertype["id"]);
        $data["notes"] = $this->getallnotes($data);
        $data["peopleReadPaper"] = $this->getpeoplewhoreadsthepaper($data);
        $data["favpapers"] = $this->PaperModel->getPapersByClassfication($data["paper"]["classification"]);
        $data["css"][] = "paper.css";
        $data["css"][] = "tagview.css";
        $data["js"][] = "foreverypaper.js";
        $data["js"][] = "tagview.js";
        $data["title"] = $data["paper"]["title"] . " Paper View";
        $data["cur_user"] = null;
        $data["target_type"] = $this->TypeModel->getTypeByName('paper');
        $data["target_id"] = $id;
        $data["islogin"] = isset($data["userdata"]["islogin"]) && $data["userdata"]["islogin"];
        $tagtargets = $this->TagTargetModel->getTagTargetByTargetTypeAndId($data["target_type"]['id'], $data["target_id"]);
        $data["tags"] = $this->TagModel->getTagsByTagtargets($tagtargets);
        $data["tag_span"] = $this->load->view('tagview', $data, true);
        $this->_generate(array("paper/for_every_paper"), $data);
    }

    public function getallnotes($data) {
        if (!isset($data["userdata"]["islogin"]) || !$data["userdata"]["islogin"]) {
            return null;
        }

        $papertype = $this->TypeModel->getTypeByName("paper");
        $notes = $this->NoteModel->getNotesByTarget($data["paper"]["id"], $papertype["id"]);
        $newnotes = null;

        foreach ($notes as $note) {
            if ($this->UserModel->is_friend($data["userdata"]["id"], $note["user_id"]) || (
                    $note["for_group"] != 0 && $this->UserModel->is_group_friend($data["userdata"]["id"], $note["user_id"]) )) {
                $newnotes[] = $note;
            }
        }

        return $newnotes;
    }

    public function getpeoplewhoreadsthepaper($data) {

        $peopleid = null;
        foreach ($data["comments"] as $comment) {
            $peopleid[] = $comment["user_id"];
        }

        $papertype = $this->TypeModel->getTypeByName("paper");
        $notes = $this->NoteModel->getNotesByTarget($data["paper"]["id"], $papertype["id"]);

        foreach ($notes as $note) {
            $peopleid[] = $note["user_id"];
        }

        if (!isset($peopleid)) {
            return null;
        }
        $newuserid = array_flip(array_flip($peopleid));

        $peopleReadPaper = null;
        foreach ($newuserid as $nid) {
            $peopleReadPaper[] = $this->UserModel->getUserById($nid);
        }
        return $peopleReadPaper;
    }

    public function addcommentsandnotes($paperid) {
        $comments = $this->input->post('comments');
        $notes = $this->input->post('notes');

        $papercomments = null;
        $papercomments["success"] = false;
        if (!empty($comments)) {
            $id = $this->CommentModel->getInsertId();
            $userid = $this->session->userdata["id"];
            $target_type = $this->TypeModel->getTypeByName("paper");
            $target_id = $paperid;
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

            $papercomments["success"] = $this->CommentModel->addComment($newcomments);
            $user_url = base_url("index.php/user/showuser/{$id}");
            $new_avatar = base_url() . "/img/avatar/" . $this->session->userdata['avatar'];
            $new_name = $this->session->userdata["nickname"];
            $papercomments["msg"] = "
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
            echo json_encode($papercomments);
        } else if (!empty($notes)) {
            $page_num = $this->input->post('page_num');
            $id = $this->NoteModel->getInsertId();
            $userid = $this->session->userdata["id"];
            $target_type = $this->TypeModel->getTypeByName("paper");
            $target_id = $paperid;
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

            $papercomments["success"] = $this->NoteModel->addNotes($newnotes);
            
            $user_url = base_url("index.php/user/showuser/{$id}");
            $new_avatar = base_url() . "/img/avatar/" . $this->session->userdata['avatar'];
            $new_name = $this->session->userdata["nickname"];
            $papercomments["msg"] = "
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
            echo json_encode($papercomments);
        } else {
            echo json_encode($papercomments);
        }
    }

    public function addpaper() {
        $data["css"][] = "addpaper.css";
        $data["title"] = "Add Paper";
        $this->_generate(array("paper/addpaper"), $data);

        /*
          $this->load->helper(array('form', 'url'));
          $this->load->library('form_validation');

          $this->form_validation->set_rules('papername', 'need paper name', 'required');
          $this->form_validation->set_rules('paperisbn13', 'paper isbn should have 13 digits', 'exact_length( 13 )');
          $this->form_validation->set_rules('paperisbn10', 'paper isbn should have 10 digits', 'exact_length( 10 )');
          if ($this->form_validation->run() == FALSE){
          $this->_generate(array("paper/addpaper"), $data);
          }
          else{
          $this->load->view('formsuccess');
          } */
    }

    public function formresult() {
        $data = null;
        $data["success"] = false;

        $paperid = $this->paperModel->getInsertId();
        $papertitle = $this->input->post('papertitle');
        $paperauthors = $this->input->post('paperauthors');
        $paperintro = $this->input->post('paperintro');
        $paperclassification = $this->input->post('Classification');

        if (!empty($papername)) {
            $newpaper = array(
                "id" => $paperid,
                "title" => $papertitle,
                "authors" => $paperauthor,
                "intro" => $paperintro,
                "Classification" => $paperclassification,
            );

            $data["success"] = $this->paperModel->addpaper($newpaper);
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