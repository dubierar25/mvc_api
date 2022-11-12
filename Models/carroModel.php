<?php


include_once('./Models/connection.php');

class carroModel{

       //Nombre de la tabla
   private $table = 'carro';

    private function validarDatos($datos){

        $letras = preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/ ');
        $numeros = preg_match('/^[^0-9]');
        $identificacion = $data['identificacion'];
        $nombres = $data['nombres'];
        $apellidos = $data['apellidos'];

        $numeros = "0123456789";
        $letras = "abcdefghijklmnopqrstuvwxyzñABCDEFGHIJKLMNOPQRSTUVWXYZÑ ";

        if ($identificacion < 0) {
            return "El numero de indentificacion no puede ser negativo";
        }

        for ($i = 0; $i < strlen($identificacion); $i++) {
            if (strpos($numeros, substr($identificacion, $i, 1)) === false) {
                return "El campo identificacion debe ser de tipo numérico y sin puntos ni comas";
            }
        }
        for ($i = 0; $i < strlen($nombres); $i++) {
            if (strpos($letras, substr($nombres, $i, 1)) === false) {
                return "el campo nombres contiene caracteres invalidos";
            }
        }
        for ($i = 0; $i < strlen($apellidos); $i++) {
            if (strpos($letras, substr($apellidos, $i, 1)) === false) {
                return "el campo apellidos contiene caracteres invalidos";
            }
        }
        if ($this->getBy("identificacion", $identificacion) != null) {
            return "Ya existe una persona registrada con el número de identificación ingresado";
        }

        return "ok";
    }
    


    public function read(){

        $db = new DATABASE();

        try
        {
            $stm = $db->getConnection()->prepare("SELECT * FROM $this->table");
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $result;
       
           
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }

     
    }

    public function create(){

        $db = new DATABASE();

        try{

            $stm= $db->getConnection()->prepare("INSERT INTO $this->table (placa, marca, cant_pasajeros) VALUES (?,?,?)");
            
            $stm->execute([
                $_POST['placa'],
                $_POST['marca'],
                $_POST['cant_pasajeros'],
            ]);

            return $db->getConnection()->lastInsertId();
        }catch(PDOException $e){
        echo $e->getMessage();
        }
    }

          //Elimina un registro por Id
    public function delete(){

        $db = new DATABASE();

        try
        {

            $statement = $db->getConnection()->prepare("SELECT * FROM carro WHERE id_carro = ?");
            $statement->execute([
                $_POST['id']
            ]);
        
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

            $stm = $db->getConnection()->prepare("DELETE FROM $this->table WHERE id_carro=?");
            $stm->execute([
                $_POST['id']
            ]);

            return $resultado;
           
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

     // Actualiza un resgistro por Id
     public function update(){

        $db = new DATABASE();
        try{
            $stm = $db->getConnection()->prepare("UPDATE $this->table SET placa = ?, marca = ?, cant_pasajeros = ? WHERE id_carro = ?");

            $stm->execute([
                $_POST['placa'],
                $_POST['marca'],
                $_POST['cant_pasajeros'],
                $_POST['id'],
                
        ]);
        }catch(PDOException $e){
            header('Content-type:application/json;charset=utf-8');
            echo json_encode([
                'error' => [
                    'codigo' => $e->getCode(),
                    'mensaje' => $e->getMessage()
                ]
            ]);
        }
    }

       //Obtiene un registro por Id
       public function carro(){

        $db = new DATABASE();
        try
        {
            $stm = $db->getConnection()->prepare("SELECT * FROM $this->table WHERE id_carro= ?");
            $stm->execute([$_POST['id']]);
            return $stm->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

}