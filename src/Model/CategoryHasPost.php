<?php


namespace Model;


class CategoryHasPost
{
    private $category;
    private $post;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return CategoryHasPost
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
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
     * @return CategoryHasPost
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }


}