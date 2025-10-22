<?php
// Ejercicio 1: Patrón Factory
// Juego de turnos con Esqueleto y Zombi

// Clase base para los personajes
class Personaje {
    public $nombre;
    public $vida;
    public $ataque;
    public $velocidad;
    
    public function __construct($nombre, $vida, $ataque, $velocidad) {
        $this->nombre = $nombre;
        $this->vida = $vida;
        $this->ataque = $ataque;
        $this->velocidad = $velocidad;
    }
    
    public function atacar() {
        return $this->ataque;
    }
    
    public function recibirDanio($danio) {
        $this->vida = $this->vida - $danio;
        if ($this->vida < 0) {
            $this->vida = 0;
        }
    }
    
    public function estaVivo() {
        return $this->vida > 0;
    }
}

// Clase Esqueleto
class Esqueleto extends Personaje {
    public function __construct() {
        parent::__construct("Esqueleto", 50, 10, 15);
    }
    
    public function atacar() {
        echo $this->nombre . " ataca con su espada!\n";
        return $this->ataque;
    }
}

// Clase Zombi
class Zombi extends Personaje {
    public function __construct() {
        parent::__construct("Zombi", 80, 15, 8);
    }
    
    public function atacar() {
        echo $this->nombre . " muerde ferozmente!\n";
        return $this->ataque;
    }
}

// Factory para crear personajes
class PersonajeFactory {
    public function crearPersonaje($nivel) {
        if ($nivel == "facil") {
            return new Esqueleto();
        } else if ($nivel == "dificil") {
            return new Zombi();
        } else {
            return null;
        }
    }
}

// Clase Jugador
class Jugador {
    public $vida;
    public $ataque;
    
    public function __construct() {
        $this->vida = 100;
        $this->ataque = 20;
    }
    
    public function atacar() {
        return $this->ataque;
    }
    
    public function recibirDanio($danio) {
        $this->vida = $this->vida - $danio;
        if ($this->vida < 0) {
            $this->vida = 0;
        }
    }
    
    public function estaVivo() {
        return $this->vida > 0;
    }
}

// Función de combate
function combatir($jugador, $enemigo) {
    echo "\n¡Aparece un " . $enemigo->nombre . "!\n";
    echo "Vida del enemigo: " . $enemigo->vida . "\n";
    echo "Tu vida: " . $jugador->vida . "\n\n";
    
    // Bucle de combate
    while ($jugador->estaVivo() && $enemigo->estaVivo()) {
        echo "--- Tu turno ---\n";
        echo "1. Atacar\n";
        echo "2. Ver estado\n";
        echo "Opcion: ";
        
        $accion = trim(fgets(STDIN));
        
        if ($accion == "1") {
            // Jugador ataca
            $danio = $jugador->atacar();
            echo "Atacas al " . $enemigo->nombre . " causando " . $danio . " de daño!\n";
            $enemigo->recibirDanio($danio);
            echo "Vida del enemigo: " . $enemigo->vida . "\n";
            
            if (!$enemigo->estaVivo()) {
                echo "\n¡Has derrotado al " . $enemigo->nombre . "!\n";
                return true; // Enemigo derrotado
            }
            
            // Turno del enemigo
            echo "\n--- Turno del enemigo ---\n";
            $danioEnemigo = $enemigo->atacar();
            $jugador->recibirDanio($danioEnemigo);
            echo "El " . $enemigo->nombre . " te causa " . $danioEnemigo . " de daño!\n";
            echo "Tu vida: " . $jugador->vida . "\n\n";
            
            if (!$jugador->estaVivo()) {
                echo "\n¡Has sido derrotado!\n";
                echo "GAME OVER\n";
                return false; // Jugador murió
            }
            
        } else if ($accion == "2") {
            echo "Tu vida: " . $jugador->vida . "\n";
            echo "Vida del enemigo: " . $enemigo->vida . "\n\n";
        } else {
            echo "Opcion invalida\n\n";
        }
    }
    
    return false;
}

// Función principal del juego
function jugar() {
    echo "=== JUEGO DE COMBATE ===\n";
    echo "¡Prepárate para enfrentar 2 niveles!\n\n";
    
    $factory = new PersonajeFactory();
    $jugador = new Jugador();
    
    // NIVEL 1: Esqueleto
    echo "--- NIVEL 1: FACIL ---\n";
    $enemigo1 = $factory->crearPersonaje("facil");
    $ganoNivel1 = combatir($jugador, $enemigo1);
    
    if (!$ganoNivel1) {
        // El jugador murió
        return;
    }
    
    echo "\n¡Pasaste al siguiente nivel!\n";
    echo "Presiona Enter para continuar...";
    fgets(STDIN);
    
    // NIVEL 2: Zombi
    echo "\n--- NIVEL 2: DIFICIL ---\n";
    $enemigo2 = $factory->crearPersonaje("dificil");
    $ganoNivel2 = combatir($jugador, $enemigo2);
    
    if ($ganoNivel2) {
        echo "\n¡FELICIDADES! ¡HAS COMPLETADO TODOS LOS NIVELES!\n";
        echo "¡VICTORIA TOTAL!\n";
    }
}

// Iniciar el juego
jugar();
?>
