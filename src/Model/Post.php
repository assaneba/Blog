<?php

namespace Model;

class Post
{
    private $idpost;
    private $title;
    private $lead;
    private $content;
    private $dateCreation;
    private $postPublic;
    private $datePlanned;
    private $user;

 //On construit l'objet post grâce aux données $inputs recupérées dans la fonction getOne($id) de la classe PostManager
    public function __construct($inputs)
    {
        $this->setIdpost($inputs->idpost);
        $this->setTitle($inputs->title);
        $this->setLead($inputs->lead);
        $this->setContent($inputs->content);
        $this->setDateCreation($inputs->date_creation);
        $this->setPostPublic($inputs->post_public);
        $this->setDatePlanned($inputs->date_planned);
        $this->setUser($inputs->login);
        //$this->hydrate($inputs);
    }

    /*public function hydrate($inputs)
    {

        foreach ($inputs as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                echo "{$method}  existe Valeur => {$value} <br>";
                $this->$method($value);
            }
            else {
                //echo $method . ' NOT FOUND.<br>';
            }
        }
    }*/
    /**
     * @return mixed
     */
    public function getIdpost()
    {
        return $this->idpost;
    }

    /**
     * @param integer $idpost
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
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     * @return Post
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostPublic()
    {
        return $this->postPublic;
    }

    /**
     * @param mixed $postPublic
     * @var boolean
     * @return Post
     */
    public function setPostPublic($postPublic)
    {
        $this->postPublic = $postPublic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDatePlanned()
    {
        return $this->datePlanned;
    }

    /**
     * @param mixed $datePlanned
     * @return Post
     */
    public function setDatePlanned($datePlanned)
    {
        $this->datePlanned = $datePlanned;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Post
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


}