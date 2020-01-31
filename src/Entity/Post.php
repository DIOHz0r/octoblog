<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="15")
     */
    private $titulo;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min="25")
     */
    private $contenido;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $fecha;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentario", mappedBy="post")
     */
    private $comentarios;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $autor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Puntaje", mappedBy="post")
     */
    private $puntajes;

    public function __construct()
    {
        $this->comentarios = new ArrayCollection();
        $this->puntajes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getContenido(): ?string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): self
    {
        $this->contenido = $contenido;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * @return Collection|Comentario[]
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): self
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios[] = $comentario;
            $comentario->setPost($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): self
    {
        if ($this->comentarios->contains($comentario)) {
            $this->comentarios->removeElement($comentario);
            // set the owning side to null (unless already changed)
            if ($comentario->getPost() === $this) {
                $comentario->setPost(null);
            }
        }

        return $this;
    }

    public function getAutor(): ?Usuario
    {
        return $this->autor;
    }

    public function setAutor(?Usuario $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * @return Collection|Puntaje[]
     */
    public function getPuntajes(): Collection
    {
        return $this->puntajes;
    }

    public function addPuntaje(Puntaje $puntaje): self
    {
        if (!$this->puntajes->contains($puntaje)) {
            $this->puntajes[] = $puntaje;
            $puntaje->setPost($this);
        }

        return $this;
    }

    public function removePuntaje(Puntaje $puntaje): self
    {
        if ($this->puntajes->contains($puntaje)) {
            $this->puntajes->removeElement($puntaje);
            // set the owning side to null (unless already changed)
            if ($puntaje->getPost() === $this) {
                $puntaje->setPost(null);
            }
        }

        return $this;
    }
}
