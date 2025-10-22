<?php
// Ejercicio 4: Patrón Strategy
// Sistema de mensajes con diferentes formatos de salida

// Interfaz Strategy
class EstrategiaSalida {
    public function mostrar($mensaje) {
        // Método base
    }
}

// Estrategia para salida en consola
class SalidaConsola extends EstrategiaSalida {
    public function mostrar($mensaje) {
        echo "=== SALIDA POR CONSOLA ===\n";
        echo $mensaje . "\n";
        echo "==========================\n";
    }
}

// Estrategia para salida en formato JSON
class SalidaJSON extends EstrategiaSalida {
    public function mostrar($mensaje) {
        echo "=== SALIDA EN FORMATO JSON ===\n";
        $datos = array(
            "tipo" => "mensaje",
            "contenido" => $mensaje,
            "timestamp" => date("Y-m-d H:i:s")
        );
        // Simular JSON en consola
        echo "{\n";
        echo "  \"tipo\": \"" . $datos['tipo'] . "\",\n";
        echo "  \"contenido\": \"" . $datos['contenido'] . "\",\n";
        echo "  \"timestamp\": \"" . $datos['timestamp'] . "\"\n";
        echo "}\n";
        echo "==============================\n";
    }
}

// Estrategia para salida en archivo TXT
class SalidaTXT extends EstrategiaSalida {
    public function mostrar($mensaje) {
        echo "=== SALIDA EN FORMATO TXT ===\n";
        echo "--- Inicio del archivo mensaje.txt ---\n";
        echo "Mensaje: " . $mensaje . "\n";
        echo "Fecha: " . date("Y-m-d H:i:s") . "\n";
        echo "--- Fin del archivo ---\n";
        echo "=============================\n";
    }
}

// Contexto que usa la estrategia
class SistemaMensajes {
    private $estrategia;
    
    public function establecerEstrategia($estrategia) {
        $this->estrategia = $estrategia;
    }
    
    public function enviarMensaje($mensaje) {
        if ($this->estrategia != null) {
            $this->estrategia->mostrar($mensaje);
        } else {
            echo "No se ha seleccionado una estrategia de salida\n";
        }
    }
}

// Función principal
function ejecutarSistema() {
    echo "=== SISTEMA DE MENSAJES ===\n\n";
    
    $sistema = new SistemaMensajes();
    
    echo "Ingresa el mensaje a mostrar: ";
    $mensaje = trim(fgets(STDIN));
    
    if ($mensaje == "") {
        $mensaje = "Este es un mensaje de prueba";
    }
    
    $continuar = true;
    while ($continuar) {
        echo "\n--- MENU DE SALIDAS ---\n";
        echo "1. Mostrar en Consola\n";
        echo "2. Mostrar en formato JSON\n";
        echo "3. Mostrar en formato TXT\n";
        echo "4. Mostrar en todos los formatos\n";
        echo "5. Cambiar mensaje\n";
        echo "6. Salir\n";
        echo "Opcion: ";
        
        $opcion = trim(fgets(STDIN));
        
        echo "\n";
        
        if ($opcion == "1") {
            $estrategia = new SalidaConsola();
            $sistema->establecerEstrategia($estrategia);
            $sistema->enviarMensaje($mensaje);
            
        } else if ($opcion == "2") {
            $estrategia = new SalidaJSON();
            $sistema->establecerEstrategia($estrategia);
            $sistema->enviarMensaje($mensaje);
            
        } else if ($opcion == "3") {
            $estrategia = new SalidaTXT();
            $sistema->establecerEstrategia($estrategia);
            $sistema->enviarMensaje($mensaje);
            
        } else if ($opcion == "4") {
            echo "Mostrando en todos los formatos...\n\n";
            
            $estrategia = new SalidaConsola();
            $sistema->establecerEstrategia($estrategia);
            $sistema->enviarMensaje($mensaje);
            echo "\n";
            
            $estrategia = new SalidaJSON();
            $sistema->establecerEstrategia($estrategia);
            $sistema->enviarMensaje($mensaje);
            echo "\n";
            
            $estrategia = new SalidaTXT();
            $sistema->establecerEstrategia($estrategia);
            $sistema->enviarMensaje($mensaje);
            
        } else if ($opcion == "5") {
            echo "Ingresa el nuevo mensaje: ";
            $mensaje = trim(fgets(STDIN));
            if ($mensaje == "") {
                $mensaje = "Este es un mensaje de prueba";
            }
            echo "Mensaje actualizado!\n";
            
        } else if ($opcion == "6") {
            echo "Saliendo del sistema...\n";
            $continuar = false;
            
        } else {
            echo "Opcion invalida\n";
        }
    }
}

// Ejecutar el programa
ejecutarSistema();
?>
