<?php

namespace App\Helpers;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class TestHelper{

    protected $EntityManger;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->EntityManger = $entityManager;
    }


    public function TestFunc($YtsId, $download = true)
    {
       $this->EntityManger->getRepository(User::class);
    }


}