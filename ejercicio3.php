<?php
// Ejercicio 3: Patrón Decorator
// Sistema de equipamiento de personajes

// Clase base de personaje
class PersonajeBase {
    public $nombre;
    public $ataque;
    public $defensa;
    
    public function __construct($nombre, $ataque, $defensa) {
        $this->nombre = $nombre;
        $this->ataque = $ataque;
        $this->defensa = $defensa;
    }
    
    public function obtenerAtaque() {
        return $this->ataque;
    }
    
    public function obtenerDefensa() {
        return $this->defensa;
    }
    
    public function obtenerDescripcion() {
        return $this->nombre;
    }
    
    public function obtenerEquipamiento() {
        return "Sin equipamiento";
    }
}

// Personajes específicos
class Guerrero extends PersonajeBase {
    public function __construct() {
        parent::__construct("Guerrero", 30, 20);
    }
}

class Mago extends PersonajeBase {
    public function __construct() {
        parent::__construct("Mago", 40, 10);
    }
}

// Clase base Decorator
class ArmaDecorator extends PersonajeBase {
    protected $personaje;
    
    public function __construct($personaje) {
        $this->personaje = $personaje;
        $this->nombre = $personaje->nombre;
        $this->ataque = $personaje->ataque;
        $this->defensa = $personaje->defensa;
    }
    
    public function obtenerAtaque() {
        return $this->personaje->obtenerAtaque();
    }
    
    public function obtenerDefensa() {
        return $this->personaje->obtenerDefensa();
    }
    
    public function obtenerDescripcion() {
        return $this->personaje->obtenerDescripcion();
    }
    
    public function obtenerEquipamiento() {
        return $this->personaje->obtenerEquipamiento();
    }
}

// Decoradores de armas
class Espada extends ArmaDecorator {
    public function obtenerAtaque() {
        return $this->personaje->obtenerAtaque() + 15;
    }
    
    public function obtenerDescripcion() {
        return $this->personaje->obtenerDescripcion() . " con Espada";
    }
    
    public function obtenerEquipamiento() {
        $equipo = $this->personaje->obtenerEquipamiento();
        if ($equipo == "Sin equipamiento") {
            return "Espada (+15 ataque)";
        }
        return $equipo . ", Espada (+15 ataque)";
    }
}

class Arco extends ArmaDecorator {
    public function obtenerAtaque() {
        return $this->personaje->obtenerAtaque() + 12;
    }
    
    public function obtenerDescripcion() {
        return $this->personaje->obtenerDescripcion() . " con Arco";
    }
    
    public function obtenerEquipamiento() {
        $equipo = $this->personaje->obtenerEquipamiento();
        if ($equipo == "Sin equipamiento") {
            return "Arco (+12 ataque)";
        }
        return $equipo . ", Arco (+12 ataque)";
    }
}

class Baston extends ArmaDecorator {
    public function obtenerAtaque() {
        return $this->personaje->obtenerAtaque() + 20;
    }
    
    public function obtenerDescripcion() {
        return $this->personaje->obtenerDescripcion() . " con Baston Magico";
    }
    
    public function obtenerEquipamiento() {
        $equipo = $this->personaje->obtenerEquipamiento();
        if ($equipo == "Sin equipamiento") {
            return "Baston Magico (+20 ataque)";
        }
        return $equipo . ", Baston Magico (+20 ataque)";
    }
}

class Escudo extends ArmaDecorator {
    public function obtenerDefensa() {
        return $this->personaje->obtenerDefensa() + 25;
    }
    
    public function obtenerDescripcion() {
        return $this->personaje->obtenerDescripcion() . " con Escudo";
    }
    
    public function obtenerEquipamiento() {
        $equipo = $this->personaje->obtenerEquipamiento();
        if ($equipo == "Sin equipamiento") {
            return "Escudo (+25 defensa)";
        }
        return $equipo . ", Escudo (+25 defensa)";
    }
}

// Función para mostrar stats del personaje
function mostrarStats($personaje) {
    echo "\n=== ESTADISTICAS ===\n";
    echo "Personaje: " . $personaje->obtenerDescripcion() . "\n";
    echo "Ataque: " . $personaje->obtenerAtaque() . "\n";
    echo "Defensa: " . $personaje->obtenerDefensa() . "\n";
    echo "Equipamiento: " . $personaje->obtenerEquipamiento() . "\n";
}

// Función principal
function menuEquipamiento() {
    echo "=== MENU DE EQUIPAMIENTO ===\n\n";
    echo "Selecciona tu personaje:\n";
    echo "1. Guerrero (Ataque: 30, Defensa: 20)\n";
    echo "2. Mago (Ataque: 40, Defensa: 10)\n";
    echo "Opcion: ";
    
    $opcion = trim(fgets(STDIN));
    
    $personaje = null;
    if ($opcion == "1") {
        $personaje = new Guerrero();
    } else if ($opcion == "2") {
        $personaje = new Mago();
    } else {
        echo "Opcion invalida\n";
        return;
    }
    
    mostrarStats($personaje);
    
    // Array para controlar items equipados
    $itemsEquipados = array(
        "1" => false,  // Espada
        "2" => false,  // Arco
        "3" => false,  // Baston
        "4" => false   // Escudo
    );
    
    $continuar = true;
    while ($continuar) {
        echo "\n--- MENU DE EQUIPAMIENTO ---\n";
        
        // Mostrar solo items no equipados
        if (!$itemsEquipados["1"]) {
            echo "1. Equipar Espada (+15 ataque)\n";
        }
        if (!$itemsEquipados["2"]) {
            echo "2. Equipar Arco (+12 ataque)\n";
        }
        if (!$itemsEquipados["3"]) {
            echo "3. Equipar Baston Magico (+20 ataque)\n";
        }
        if (!$itemsEquipados["4"]) {
            echo "4. Equipar Escudo (+25 defensa)\n";
        }
        
        echo "5. Ver estadisticas\n";
        echo "6. Salir\n";
        echo "Opcion: ";
        
        $accion = trim(fgets(STDIN));
        
        if ($accion == "1") {
            if ($itemsEquipados["1"]) {
                echo "\n¡Ya tienes la Espada equipada!\n";
            } else {
                $personaje = new Espada($personaje);
                $itemsEquipados["1"] = true;
                echo "\n¡Espada equipada!\n";
                mostrarStats($personaje);
            }
        } else if ($accion == "2") {
            if ($itemsEquipados["2"]) {
                echo "\n¡Ya tienes el Arco equipado!\n";
            } else {
                $personaje = new Arco($personaje);
                $itemsEquipados["2"] = true;
                echo "\n¡Arco equipado!\n";
                mostrarStats($personaje);
            }
        } else if ($accion == "3") {
            if ($itemsEquipados["3"]) {
                echo "\n¡Ya tienes el Baston Magico equipado!\n";
            } else {
                $personaje = new Baston($personaje);
                $itemsEquipados["3"] = true;
                echo "\n¡Baston Magico equipado!\n";
                mostrarStats($personaje);
            }
        } else if ($accion == "4") {
            if ($itemsEquipados["4"]) {
                echo "\n¡Ya tienes el Escudo equipado!\n";
            } else {
                $personaje = new Escudo($personaje);
                $itemsEquipados["4"] = true;
                echo "\n¡Escudo equipado!\n";
                mostrarStats($personaje);
            }
        } else if ($accion == "5") {
            mostrarStats($personaje);
        } else if ($accion == "6") {
            echo "\nSaliendo del menu...\n";
            $continuar = false;
        } else {
            echo "Opcion invalida\n";
        }
    }
}

// Ejecutar el programa
menuEquipamiento();
?>
