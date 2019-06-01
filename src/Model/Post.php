<?php


namespace Model;


class Post
{
    private $idpost;
    private $title;
    private $lead;
    private $content;
    private $date_creation;
    private $post_public;
    private $date_planned;
    private $user;

    public function __construct(array $inputs)
    {
        $this->hydrate($inputs);
    }

    // Attribuer des valeurs dynamiquement via les setters aux champs des valeurs d'un objet post

    public function hydrate(array $inputs)
    {
        foreach ($inputs as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                //echo "{$method}  existe Valeur => {$value} <br>";
                $this->$method($value);
            }
            else {
                //echo $method . ' NOT FOUND.<br>';
            }
        }
    }

    /**
     * @return mixed
     */
    public function getIdpost()
    {
        return $this->idpost;
    }

    /**
     * @param mixed $idpost
     * @return Post
     */
    public function setIdpost($idpost)
    {
        $this->idpost = $idpost;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param mixed $lead
     * @return Post
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
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
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate_creation()
    {
        return $this->date_creation;
    }

    /**
     * @param mixed $date_creation
     * @return Post
     */
    public function setDate_creation($date_creation)
    {
        $this->date_creation = $date_creation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPost_public()
    {
        return $this->post_public;
    }

    /**
     * @param mixed $post_public
     * @var boolean
     * @return Post
     */
    public function setPost_public($post_public)
    {
        $this->post_public = $post_public;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate_planned()
    {
        return $this->date_planned;
    }

    /**
     * @param mixed $date_planned
     * @return Post
     */
    public function setDate_planned($date_planned)
    {
        $this->date_planned = $date_planned;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser_iduser()
    {
        return $this->user;
    }

    /**
     * @param mixed $id_user
     * @return Post
     */
    public function setUser_iduser($user)
    {
        $this->user = $user;
        return $this;
    }


}