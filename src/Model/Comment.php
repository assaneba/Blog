<?php


namespace Model;


class Comment
{
    private $id_comment;
    private $date_comment;
    private $date_last_modif;
    private $content;
    private $published;
    private $post;

    /**
     * @return mixed
     */
    public function getIdComment()
    {
        return $this->id_comment;
    }

    /**
     * @param mixed $id_comment
     * @return Comment
     */
    public function setIdComment($id_comment)
    {
        $this->id_comment = $id_comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateComment()
    {
        return $this->date_comment;
    }

    /**
     * @param mixed $date_comment
     * @return Comment
     */
    public function setDateComment($date_comment)
    {
        $this->date_comment = $date_comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateLastModif()
    {
        return $this->date_last_modif;
    }

    /**
     * @param mixed $date_last_modif
     * @return Comment
     */
    public function setDateLastModif($date_last_modif)
    {
        $this->date_last_modif = $date_last_modif;
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
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     * @return Comment
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
        return $this;
    }




}