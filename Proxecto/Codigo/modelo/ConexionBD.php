<?php
class ConexionBD extends PDO {

    private $host = "localhost";
    private $db = "baseinfodb3";
    private $usuario = "arancha";
    private $contrasinal = "Arancha25";
    private $dsn;

    public function __construct() {
        $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";

        try {
            parent::__construct($this->dsn, $this->usuario, $this->contrasinal);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Erro na conexión: mensaxe: " . $e->getMessage());
        }
    }
}

?>
