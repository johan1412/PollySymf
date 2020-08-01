<?php

namespace App\Entity;

use App\Repository\ChoixRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChoixRepository::class)
 */
class Choix
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $option1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $option2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option5;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOption1(): ?string
    {
        return $this->option1;
    }

    public function setOption1(string $option1): self
    {
        $this->option1 = $option1;

        return $this;
    }

    public function getOption2(): ?string
    {
        return $this->option2;
    }

    public function setOption2(string $option2): self
    {
        $this->option2 = $option2;

        return $this;
    }

    public function getOption3(): ?string
    {
        return $this->option3;
    }

    public function setOption3(?string $option3): self
    {
        $this->option3 = $option3;

        return $this;
    }

    public function getOption4(): ?string
    {
        return $this->option4;
    }

    public function setOption4(?string $option4): self
    {
        $this->option4 = $option4;

        return $this;
    }

    public function getOption5(): ?string
    {
        return $this->option5;
    }

    public function setOption5(?string $option5): self
    {
        $this->option5 = $option5;

        return $this;
    }
}
