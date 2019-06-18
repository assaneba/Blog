<?php


namespace Model;


class Comment
{
    private $idComment;
    private $dateComment;
    private $dateLastModif;
    private $content;
    private $published;
    private $postIdPost;
    private $userIdUser;

    public function __construct($inputs) {
        $this->setIdComment($inputs->idcomment);
        $this->setDateComment($inputs->date_comment);
        $this->setDateLastModif($inputs->date_last_modif);
        $this->setContent($inputs->content);
        $this->setPublished($inputs->published);
        $this->setPostIdPost($inputs->post_idpost);
        $this->setUserIdUser($inputs->user_iduser);

    }

    /**
     * @return mixed
     */
    public function getIdComment()
    {
        return $this->idComment;
    }

    /**
     * @param mixed $idComment
     * @return Comment
     */
    public function setIdComment($idComment)
    {
        $this->idComment = $idComment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateComment()
    {
        return $this->dateComment;
    }

    /**
     * @param mixed $dateComment
     * @return Comment
     */
    public function setDateComment($dateComment)
    {
        $this->dateComment = $dateComment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateLastModif()
    {
        return $this->dateLastModif;
    }

    /**
     * @param mixed $dateLastModif
     * @return Comment
     */
    public function setDateLastModif($dateLastModif)
    {
        $this->dateLastModif = $dateLastModif;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param mixed $published
     * @return Comment
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostIdPost()
    {
        return $this->postIdPost;
    }

    /**
     * @param mixed $postIdPost
     * @return Comment
     */
    public function setPostIdPost($postIdPost)
    {
        $this->postIdPost = $postIdPost;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserIdUser()
    {
        return $this->userIdUser;
    }

    /**
     * @param mixed $userIdUser
     * @return Comment
     */
    public function setUserIdUser($userIdUser)
    {
        $this->userIdUser = $userIdUser;
        return $this;
    }


}