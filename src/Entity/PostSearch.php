<?php


namespace App\Entity;


class PostSearch

{
    /**
     * @var String|null
     */
    private $inputSearch;

    /**
     * @return mixed
     */
    public function getInputSearch()
    {
        return $this->inputSearch;
    }

    /**
     * @param mixed $inputSearch
     */
    public function setInputSearch($inputSearch): void
    {
        $this->inputSearch = $inputSearch;
    }

}