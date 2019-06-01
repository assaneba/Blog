<?php


namespace Model;


class ModifPost
{
    private $date_modif;
    private $post;

    /**
     * @return mixed
     */
    public function getDateModif()
    {
        return $this->date_modif;
    }

    /**
     * @param mixed $date_modif
     * @return ModifPost
     */
    public function setDateModif($date_modif)
    {
        $this->date_modif = $date_modif;
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
     * @param mixed $post_idpost
     * @var integer
     * @return ModifPost
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
        return $this;
    }


}