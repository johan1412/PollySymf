<?php

namespace App\Entity;

use App\Repository\ResultatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultatsRepository::class)
 */
class Resultats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $res1;

    /**
     * @ORM\Column(type="integer")
     */
    private $res2;

    /**
     * @ORM\Column(type="integer")
     */
    private $res3;

    /**
     * @ORM\Column(type="integer")
     */
    private $res4;

    /**
     * @ORM\Column(type="integer")
     */
    private $res5;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRes1(): ?string
    {
        return $this->res1;
    }

    public function setRes1(int $res1): self
    {
        $this->res1 = $res1;

        return $this;
    }

    public function getRes2(): ?int
    {
        return $this->res2;
    }

    public function setRes2(int $res2): self
    {
        $this->res2 = $res2;

        return $this;
    }

    public function getRes3(): ?int
    {
        return $this->res3;
    }

    public function setRes3(int $res3): self
    {
        $this->res3 = $res3;

        return $this;
    }

    public function getRes4(): ?int
    {
        return $this->res4;
    }

    public function setRes4(int $res4): self
    {
        $this->res4 = $res4;

        return $this;
    }

    public function getRes5(): ?int
    {
        return $this->res5;
    }

    public function setRes5(int $res5): self
    {
        $this->res5 = $res5;

        return $this;
    }
}
