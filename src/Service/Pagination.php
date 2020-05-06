<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Pagination {
    private $entityClass;
    private $limit = 9;
    private $currentPage = 1;
    private $manager;
    private $champ;
    private $val;
    private $searchType;

    /**
     * Pagination constructor.
     * @param EntityManagerInterface $manager
     *
     */
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    /**
     * @return false|float
     */
    public function getPages(){
        $repo = $this->manager->getRepository($this->entityClass);

        if ($this->searchType == "findby" && $this->val != null ){
            $total = count($repo->findBy(
                [$this->champ => $this->val]
            ));
        }
        else{
            $total= count($repo->findAll());
        }

        $pages = ceil($total / $this->limit);

        return $pages;
    }

    /**
     * @return object[]
     *
     *
     */
    public function getData(){
        //1 .calcule de l offset
        $offset = $this->currentPage * $this->limit - $this->limit;

        $repo = $this->manager->getRepository($this->entityClass);

        if ($this->champ != null && $this->val != null){
            $data = $repo->findBy([$this->champ => $this->val], [], $this->limit, $offset);
        }
        else{
            $data = $repo->findBy([], [], $this->limit, $offset);
        }

        return $data;
    }
    public function getDataSearch(){
        //1 .calcule de l offset
        $offset = $this->currentPage * $this->limit - $this->limit;

        $repo = $this->manager->getRepository($this->entityClass);

        $data = $repo->findBy([], [], $this->limit, $offset);

        return $data;
    }
    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param int $Page
     * @return $this
     *
     */
    public function setPage(int $Page)
    {
        $this->currentPage = $Page;
        return $this;
    }
    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return $this
     *
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @param $entityClass
     * @return $this
     *
     */
    public function setEntityClass($entityClass, $champ = null, $val = null, $serchType = null)
    {
        $this->entityClass = $entityClass;
        $this->champ = $champ;
        $this->val = $val;
        $this->searchType = $serchType;

        return $this;
    }

}