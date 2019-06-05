<?php


namespace Model;


class ModifPost
{
    private $dateModif;
    private $post;

    /**
     * @return mixed
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * @param mixed $dateModif
     * @return ModifPost
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;
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
     * @param mixed $postIdpost
     * @var integer
     * @return ModifPost
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }


}