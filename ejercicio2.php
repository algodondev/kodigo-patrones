<?php
// Ejercicio 2: Patrón Adapter
// Sistema de archivos compatible entre Windows 7 y Windows 10

// Clase para archivos de Windows 7
class ArchivoWindows7 {
    public $nombre;
    public $tipo;
    public $sistema;
    
    public function __construct($nombre, $tipo) {
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->sistema = "Windows 7";
    }
    
    public function obtenerInfo() {
        return "Archivo: " . $this->nombre . ", Tipo: " . $this->tipo . ", Sistema: " . $this->sistema;
    }
}

// Clase para Windows 10
class Windows10 {
    public function abrirArchivo($nombre, $tipo, $contenido) {
        echo "Windows 10 abriendo archivo...\n";
        echo "Nombre: " . $nombre . "\n";
        echo "Tipo: " . $tipo . "\n";
        echo "Contenido: " . $contenido . "\n";
        return true;
    }
}

// Adapter para hacer compatible archivos de Windows 7 en Windows 10
class AdaptadorWindows7 {
    private $archivoWin7;
    
    public function __construct($archivoWin7) {
        $this->archivoWin7 = $archivoWin7;
    }
    
    public function adaptar() {
        echo "Adaptando archivo de Windows 7 para Windows 10...\n";
        $datos = array();
        $datos['nombre'] = $this->archivoWin7->nombre;
        $datos['tipo'] = $this->archivoWin7->tipo;
        $datos['contenido'] = "Contenido adaptado desde " . $this->archivoWin7->sistema;
        return $datos;
    }
}

// Función para abrir archivos
function abrirArchivo($sistema, $archivos) {
    echo "\nArchivos disponibles:\n";
    for ($i = 0; $i < count($archivos); $i++) {
        echo ($i + 1) . ". " . $archivos[$i]['nombre'] . " (" . $archivos[$i]['tipo'] . ") - Creado en: " . $archivos[$i]['sistema'] . "\n";
    }
    
    echo "\nSelecciona el archivo a abrir (1-" . count($archivos) . "): ";
    $seleccion = trim(fgets(STDIN));
    $indice = $seleccion - 1;
    
    if ($indice < 0 || $indice >= count($archivos)) {
        echo "Seleccion invalida\n";
        return;
    }
    
    $archivoSeleccionado = $archivos[$indice];
    
    echo "\n--- Abriendo archivo ---\n";
    echo "Archivo: " . $archivoSeleccionado['nombre'] . "\n";
    echo "Sistema de origen: " . $archivoSeleccionado['sistema'] . "\n";
    echo "Sistema actual: " . $sistema . "\n\n";
    
    if ($sistema == "Windows 10") {
        $win10 = new Windows10();
        
        if ($archivoSeleccionado['sistema'] == "Windows 7") {
            // Usar el adapter
            echo "¡Archivo de Windows 7 detectado!\n";
            $archivoWin7 = new ArchivoWindows7($archivoSeleccionado['nombre'], $archivoSeleccionado['tipo']);
            $adapter = new AdaptadorWindows7($archivoWin7);
            $datosAdaptados = $adapter->adaptar();
            
            echo "\n";
            $win10->abrirArchivo($datosAdaptados['nombre'], $datosAdaptados['tipo'], $datosAdaptados['contenido']);
            echo "\n¡Archivo abierto exitosamente con compatibilidad!\n";
        } else {
            // Archivo nativo de Windows 10
            $win10->abrirArchivo($archivoSeleccionado['nombre'], $archivoSeleccionado['tipo'], "Contenido del archivo");
            echo "\n¡Archivo abierto exitosamente!\n";
        }
    } else {
        // Windows 7
        if ($archivoSeleccionado['sistema'] == "Windows 7") {
            echo "Abriendo archivo nativo de Windows 7...\n";
            echo "¡Archivo abierto exitosamente!\n";
        } else {
            echo "ADVERTENCIA: Este archivo fue creado en Windows 10\n";
            echo "Puede haber problemas de compatibilidad\n";
        }
    }
}

// Función principal
function ejecutarPrograma() {
    echo "=== SISTEMA DE COMPATIBILIDAD DE ARCHIVOS ===\n\n";
    
    // Crear algunos archivos de ejemplo
    $archivos = array();
    $archivos[] = array(
        "sistema" => "Windows 7",
        "nombre" => "documento.docx",
        "tipo" => "Word"
    );
    $archivos[] = array(
        "sistema" => "Windows 7",
        "nombre" => "reporte.xlsx",
        "tipo" => "Excel"
    );
    $archivos[] = array(
        "sistema" => "Windows 10",
        "nombre" => "presentacion.pptx",
        "tipo" => "PowerPoint"
    );
    
    $salir = false;
    
    while (!$salir) {
        echo "\n¿En qué sistema operativo te encuentras?\n";
        echo "1. Windows 7\n";
        echo "2. Windows 10\n";
        echo "Opcion: ";
        
        $sistemaOpcion = trim(fgets(STDIN));
        
        $sistema = "";
        if ($sistemaOpcion == "1") {
            $sistema = "Windows 7";
        } else if ($sistemaOpcion == "2") {
            $sistema = "Windows 10";
        } else {
            echo "Opcion invalida\n";
            continue;
        }
        
        echo "\nSistema seleccionado: " . $sistema . "\n";
        
        // Sesión iniciada
        $sesionActiva = true;
        while ($sesionActiva) {
            echo "\n--- MENU ---\n";
            echo "1. Abrir archivo\n";
            echo "2. Cerrar sesion y cambiar de SO\n";
            echo "3. Salir del programa\n";
            echo "Opcion: ";
            
            $opcion = trim(fgets(STDIN));
            
            if ($opcion == "1") {
                abrirArchivo($sistema, $archivos);
            } else if ($opcion == "2") {
                echo "\nCerrando sesion en " . $sistema . "...\n";
                $sesionActiva = false;
            } else if ($opcion == "3") {
                echo "\nSaliendo del programa...\n";
                $sesionActiva = false;
                $salir = true;
            } else {
                echo "Opcion invalida\n";
            }
        }
    }
}

// Ejecutar el programa
ejecutarPrograma();
?>
