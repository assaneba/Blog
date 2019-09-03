<?php

namespace Model\Manager;

class CommentManager extends Manager
{

    public function addComment(string $content, int $postIdpost, int $userIduser)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('INSERT INTO comment (date_comment, date_last_modif, content, 
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

    /**
     * @param $idPost
     * Get published comments elements and users elements as author names and their Ids
     * @return array
     */
    public function getComments(int $idPost) {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT idcomment, date_last_modif, content, user_iduser, first_name, last_name  FROM comment
                                        INNER JOIN user ON user.iduser = comment.user_iduser WHERE post_idpost = :idPost AND published = 1
                                         ORDER BY date_last_modif DESC ');
        $req->execute(array(
           ':idPost' => $idPost
        ));
        $result = $req->fetchAll();

        return $result;
    }

    /**
     * @param $idPost
     * Get Unpublished comments elements and users elements as author names and their Ids
     * @return array
     */
    public function getUnpublishedCom()
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT idcomment, date_comment, content, user_iduser FROM comment
                                        WHERE published = 0 ORDER BY date_last_modif DESC ');
        $req->execute();
        $result = $req->fetchAll();

        return $result;
    }

    public function editComment(string $content, int $commentId)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('UPDATE comment SET date_last_modif = NOW(), content = :content WHERE idcomment = :commentId');
        $result = $req->execute(array(
            'conte
            nt' => $content,
            'commentId' => $commentId
        ));

        // $result return true if query success
        return $result;
    }

    public function validateComment(int $idComment) {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('UPDATE comment SET published = 1 WHERE idcomment = :idComment');
        $response = $req->execute(array(
            ':idComment' => $idComment
        ));

        return $response;
    }

    public function deleteComment(int $idComment)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('DELETE FROM comment WHERE idcomment = :idComment');
        $response = $req->execute(array(
            ':idComment' => $idComment
        ));

        return $response;
    }

}