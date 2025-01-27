<?php

class Db{
    private $servername= "localhost";
    private $username= "root";
    private $password= "";
    private $dbname= "watchloop_db";
    private $conn;

    public function __construct() {
        $this->conn = $this->connect();
    }
    //método para establecer la base de datos
    public function connect() {
        $this->conn = null;

        try {
            // Intentar crear una nueva conexión PDO con los detalles proporcionados
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            // Establecer el modo de error de PDO para que lance excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // Si ocurre un error, captura la excepción y muestra un mensaje de error
            echo 'Connection Error: ' . $e->getMessage();
        }

        // Retorna la conexión establecida (o null si falló)
        return $this->conn;
    }
    //Método para ejecutar una consulta SQL con parámetros opcionales
    public function query($sql, $params=[]){
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);//retorna un booleano si la consulta fue exitosa o no
        return $stmt;//boleano
    }

     // Método para ejecutar una consulta y obtener un solo registro
    public function fetch($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        //Retornar un solo regisro como array asociativo
        return $stmt->fetch(PDO::FETCH_ASSOC);/*devuelve el resultado de la consulta, toda la primera fila, 
                                            solo un array y tu después puedes acceder al parámetro que quiera*/
    }

    public function fetchAll($sql, $params = []) {
        //ejecuta la consulta usado query , basicamente preparar y ejecutar la conexión
        $stmt = $this->query($sql, $params);
        //Retornar todos los registros como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);/*en el caso que haya más de una fila en el resultado de consulta SQL 
                                                devuelve una lista de arrays con todos los resultados, un array por fila */ 
    } 

     //funciones de usuario
    public function getUser($user_id){
        
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC); 
            
            // Verifica si se obtuvo una nota
            if ($user) {
                return $user; 
            } else {
                return ['error' => 'Usuario no encontrada.']; 
            }
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateUser($name, $surname, $username, $email, $password,  $user_id){
         
        if ($password) {
                try {
                    $stmt = $this->conn->prepare("UPDATE users SET name = ?, surname = ?, username = ?, email = ? , password = ? WHERE id = ?");
                    if ($stmt->execute([$name, $surname, $username, $email, $password, $user_id])) {
                        return ['id'=>$user_id, 'name'=> $name, 'surname' => $surname, 'username' => $username ,'email' => $email];
                    }
                    return null;
                } catch (PDOException $e) {
                    return ['error' => $e->getMessage()];
                }
            } else {
                try {
                    $stmt = $this->conn->prepare("UPDATE users SET name = ?, surname = ?,username = ?, email = ? WHERE id = ?");
                    if ($stmt->execute([$name, $surname, $username, $email, $user_id])) {
                        return ['id'=>$user_id, 'name'=> $name, 'surname' => $surname, 'username' => $username ,'email' => $email];
                    }
                    return null;
                } catch (PDOException $e) {
                    return ['error' => $e->getMessage()];
                }
            }
        }
}






