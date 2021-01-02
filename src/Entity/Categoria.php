<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoriaRepository::class)
 * 
 * 
 * @ApiResource(
 *collectionOperations={"get"},
 *itemOperations={"get"},
 *     attributes={
 *         "normalization_context"={"groups"={"list","item"},
 *     }
 *},  
 *)
 */
class Categoria
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"list", "item"})
     */
    private $descripcion;

    /**
     * @ORM\ManyToMany(targetEntity=Libro::class, inversedBy="categorias")
     */
    private $libros;

    public function __construct()
    {
        $this->libros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection|Libro[]
     */
    public function getLibros(): Collection
    {
        return $this->libros;
    }

    public function addLibro(Libro $libro): self
    {
        if (!$this->libros->contains($libro)) {
            $this->libros[] = $libro;
        }

        return $this;
    }

    public function removeLibro(Libro $libro): self
    {
        $this->libros->removeElement($libro);

        return $this;
    }

    public function __toString(){
        return strval($this->getId() . " " . $this->getNombre());
    }
}
