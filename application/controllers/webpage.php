<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Webpage extends CI_Controller {

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
        $data["webpage"] = $this->WebpageModel->getWebpageById($id);
        $data["classification"] = $this->ClassificationModel->getClassificationById($data["webpage"]["classification"]);
        $data["userdata"] = $this->session->userdata;
        $webpagetype = $this->TypeModel->getTypeByName("webpage");
        $data["comments"] = $this->CommentModel->getCommentsByTarget($data["webpage"]["id"], $webpagetype["id"]);
        $data["notes"] = $this->getallnotes($data);
        $data["peopleReadWebpage"] = $this->getpeoplewhoreadsthewebpage($data);
        $data["favwebpages"] = $this->WebpageModel->getWebpagesByClassfication($data["webpage"]["classification"]);
        $data["css"][] = "webpage.css";
        $data["css"][] = "tagview.css";
        $data["js"][] = "foreverywebpage.js";
        $data["js"][] = "tagview.js";
        $data["cur_user"] = null;
        $data[ "target_type" ] = $this->TypeModel->getTypeByName('webpage');
        $data[ "target_id" ] = $id;
        $data[ "islogin" ] = isset($data["userdata"]["islogin"]) && $data["userdata"]["islogin"];
        $tagtargets = $this->TagTargetModel->getTagTargetByTargetTypeAndId($data["target_type"]['id'], $data["target_id"]);
        $data[ "tags" ] = $this->TagModel->getTagsByTagtargets($tagtargets);
        $data[ "tag_span" ] = $this->load->view('tagview', $data, true);
        $data["title"] = $data["webpage"]["title"] . " Webpage View";
        $this->_generate(array("webpage/for_every_webpage"), $data);
    }

    public function getallnotes($data) {
        if (!isset($data["userdata"]["islogin"]) || !$data["userdata"]["islogin"]) {
            return null;
        }

        $webpagetype = $this->TypeModel->getTypeByName("webpage");
        $notes = $this->NoteModel->getNotesByTarget($data["webpage"]["id"], $webpagetype["id"]);
        $newnotes = null;

        foreach ($notes as $note) {
            if ($this->UserModel->is_friend($data["userdata"]["id"], $note["user_id"]) ||
                    $this->UserModel->is_group_friend($data["userdata"]["id"], $note["user_id"])) {
                $newnotes[] = $note;
            }
        }

        return $newnotes;
    }

    public function getpeoplewhoreadsthewebpage($data) {

        $peopleid = null;
        foreach ($data["comments"] as $comment) {
            $peopleid[] = $comment["user_id"];
        }

        if (!isset($peopleid)) {
            return null;
        }
        $newuserid = array_flip(array_flip($peopleid));

        $peopleReadWebpage = null;
        foreach ($newuserid as $nid) {
            $peopleReadWebpage[] = $this->UserModel->getUserById($nid);
        }
        return $peopleReadWebpage;
    }

    public function addcommentsandnotes($webpageid) {
        $comments = $this->input->post('comments');
        $id = $this->CommentModel->getInsertId();
        $userid = $this->session->userdata["id"];
        $target_type = $this->TypeModel->getTypeByName("webpage");
        $target_id = $webpageid;
        $pub_time = $mod_time = date("Y-m-d H:i:s");
        $webpagecomments = null;
        $webpagecomments["success"] = false;

        if (!empty($comments)) {
            $newcomments = array(
                "id" => $id,
                "user_id" => $userid,
                "target_type" => $target_type["id"],
                "target_id" => $target_id,
                "comment" => $comments,
                "pub_time" => $pub_time,
                "mod_time" => $mod_time,
            );

            $webpagecomments["success"] = $this->CommentModel->addComment($newcomments);
            
            $user_url = base_url("index.php/user/showuser/{$id}");
            $new_avatar = base_url() . "/img/avatar/" . $this->session->userdata['avatar'];
            $new_name = $this->session->userdata["nickname"];
            $webpagecomments["msg"] = "
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
            echo json_encode($webpagecomments);
        } else {
            echo json_encode($webpagecomments);
        }
    }
    
    public function addwebpage(){
        $data["css"][] = "addwebpage.css";
        $data["title"] = "Add Webpage";
        $this->_generate(array("webpage/addwebpage"), $data);
        
        /*
          $this->load->helper(array('form', 'url'));
          $this->load->library('form_validation');

          $this->form_validation->set_rules('webpagename', 'need webpage name', 'required');
          $this->form_validation->set_rules('webpageisbn13', 'webpage isbn should have 13 digits', 'exact_length( 13 )');
          $this->form_validation->set_rules('webpageisbn10', 'webpage isbn should have 10 digits', 'exact_length( 10 )');
          if ($this->form_validation->run() == FALSE){
           $this->_generate(array("webpage/addwebpage"), $data);
          }
          else{
           $this->load->view('formsuccess');
          }*/
    }
    
    public function formresult(){
        $data = null;
        $data["success"] = false;
        
        $webpageid = $this->webpageModel->getInsertId();
        $webpagetitle = $this->input->post('webpagetitle');
        $webpageurl = $this->input->post('webpageurl');
        $webpageintro = $this->input->post('webpageintro');
        $webpageclassification = $this->input->post('Classification');
        
        if( !empty( $webpagename ) )
        {
             $newwebpage = array( 
                "id" => $webpageid,
                "title" => $webpagetitle,
                "url" => $webpageurl,
                "intro" => $webpageintro,
                "Classification" => $webpageclassification,
            );
             
            $data["success"] = $this->webpageModel->addwebpage( $newwebpage );
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