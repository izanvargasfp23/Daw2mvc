<?php

abstract class ProductoBase
{
    // Constantes para las categorías de Valorant Eats
    const TYPE_ENTRANTES = 1;
    const TYPE_PRIMEROS  = 2;
    const TYPE_SEGUNDOS  = 3;
    const TYPE_POSTRES   = 4;

    //Columnas BBDD
    protected $id;
    protected $categoria_id;
    protected $nombre;
    protected $descripcion;
    protected $precio;
    protected $imagen;

    /**
     * fetch_object() rellena las propiedades ANTES de llamar al constructor.
     * Mantenemos nulls para no sobrescribir al instanciar desde BBDD.
     */
    public function __construct($nombre = null, $descripcion = null, $precio = null, $imagen = null, $categoria_id = null)
    {
        if ($nombre !== null) {
            $this->nombre = $nombre;
        }
        if ($descripcion !== null) {
            $this->descripcion = $descripcion;
        }
        if ($precio !== null) {
            $this->precio = $precio;
        }
        if ($imagen !== null) {
            $this->imagen = $imagen;
        }
        if ($categoria_id !== null) {
            $this->categoria_id = $categoria_id;
        }
    }

    // Getters y Setters
    public function getId() { 
        return $this->id; 
    }
    public function setId($id) { 
        $this->id = $id; return $this; 
    }

    public function getCategoriaId() {
        return $this->categoria_id; 
    }
    public function setCategoriaId($categoria_id) { 
        $this->categoria_id = $categoria_id; return $this; 
    }

    public function getNombre() { 
        return $this->nombre; 
    }
    public function setNombre($nombre) { 
        $this->nombre = $nombre; return $this; 
    }

    public function getDescripcion() { 
        return $this->descripcion; 
    }
    public function setDescripcion($descripcion) { 
        $this->descripcion = $descripcion; return $this; 
    }

    public function getPrecio() { 
        return $this->precio; 
    }
    public function setPrecio($precio) { 
        $this->precio = $precio; return $this; 
    }

    public function getImagen() { 
        return $this->imagen; 
    }
    public function setImagen($imagen) { 
        $this->imagen = $imagen; return $this; 
    }
}