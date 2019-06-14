<?php


namespace Model\Manager;


class CommentManager extends Manager
{

    public function addComment($content, $postIdpost, $userIduser) {
        $db = $this->connectToDB();
        $req = $db->prepare('INSERT INTO comment (date_comment, date_last_modif, content, 
                                        published, post_idpost, user_iduser) VALUES (NOW(), NOW(), 
                                        :content, 0, :post_idpost, :user_iduser)');
        $result = $req->execute(array(
            'content' => $content,
            'post_idpost' => $postIdpost,
            'user_iduser' => $userIduser
        ));
        // $result return true if query success
        return $result;

    }
}