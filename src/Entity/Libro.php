<?php

namespace App\Entity;

use App\Repository\LibroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LibroRepository::class)
 *
 * @ApiResource(
 *collectionOperations={"get"},
 *itemOperations={"get"},
 *     attributes={
 *         "normalization_context"={"groups"={"list","item"},
 *         "filters"={"comentario.idlibro"}
 *     }
 *},  
 *)
 */
class Libro
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
    private $titulo;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"list", "item"})
     */
    private $autor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Groups({"list", "item"}) 
     */
    private $imagen;

    /**
     * @ORM\OneToMany(targetEntity=Usuario::class, mappedBy="libros")
     */
    private $usuarios;

    /**
     * @ORM\ManyToMany(targetEntity=Categoria::class, mappedBy="libros")
     * 
     * @Groups({"list", "item"})
     */
    private $categorias;

    /**
     * @ORM\Column(type="string", length=1024)
     * 
     * @Groups({"list", "item"})
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=Comentario::class, mappedBy="libro")
     * 
     * @Groups({"libro:list", "libro:item"})
     */
    private $comentarios;


    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->categorias = new ArrayCollection();
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

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * @return Collection|Usuario[]
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario): self
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios[] = $usuario;
            $usuario->setLibros($this);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): self
    {
        if ($this->usuarios->removeElement($usuario)) {
            // set the owning side to null (unless already changed)
            if ($usuario->getLibros() === $this) {
                $usuario->setLibros(null);
            }
        }

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
            $comentario->setLibro($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): self
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getLibro() === $this) {
                $comentario->setLibro(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return strval($this->getId() . " " . $this->getTitulo());
    }

    /**
     * @return Collection|Categoria[]
     */
    public function getCategorias(): Collection
    {
        return $this->categorias;
    }

    public function addCategoria(Categoria $categoria): self
    {
        if (!$this->categorias->contains($categoria)) {
            $this->categorias[] = $categoria;
            $categoria->addLibro($this);
        }

        return $this;
    }

    public function removeCategoria(Categoria $categoria): self
    {
        if ($this->categorias->removeElement($categoria)) {
            $categoria->removeLibro($this);
        }

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
}
