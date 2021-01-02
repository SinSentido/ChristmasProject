<?php

namespace App\Entity;

use App\Repository\ComentarioRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ComentarioRepository::class)
 * 
 * @ApiResource(
 *collectionOperations={"get"},
 *itemOperations={"get"},
 *     attributes={
 *         "normalization_context"={"groups"={"list","item"},
 *     }
 *},  
 *)
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "libro": "exact"})
 */
class Comentario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"list", "item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"list", "item"})
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="comentarios")
     * 
     * @Groups({"list", "item"})
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity=Libro::class, inversedBy="comentarios")
     */
    private $libro;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getLibro(): ?Libro
    {
        return $this->libro;
    }

    public function setLibro(?Libro $libro): self
    {
        $this->libro = $libro;

        return $this;
    }

    public function __toString(){
        return strval($this->getId());
    }
}
