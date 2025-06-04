<?php
    require_once 'Database.class.php';

    class CLient{
        public static function create_client($email,$name,$city,$phone){
            $db = new Database(); 
            $conn = $db->getConnection();

            $stmt = $conn->prepare("INSERT INTO listado_clientes (email, name, city, telephone) VALUES (:email, :name, :city, :telephone)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':telephone', $phone);

            if($stmt->execute()){
                header('HTTP/1.1 201 Created');
            } else {
                header('HTTP/1.1 404 Not Found');
            }
        }
    }
?>