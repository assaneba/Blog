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
            ':content' => $content,
            ':post_idpost' => $postIdpost,
            ':user_iduser' => $userIduser
        ));
        // $result return true if query success
        return $result;

    }

    public function getComments($idPost) {
        $db = $this->connectToDB();
        $req = $db->prepare('SELECT date_last_modif, content, first_name, last_name  FROM comment
                                        INNER JOIN user ON user.iduser = comment.user_iduser WHERE post_idpost = :idPost
                                         ORDER BY date_last_modif DESC ');
        $req->execute(array(
           ':idPost' => $idPost
        ));
        $result = $req->fetchAll();
        return $result;

    }
}