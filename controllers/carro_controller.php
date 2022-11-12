<?php


class ControllerCarro{


    #crea un nuevo cliente
    public function create(){

        $json = json_decode(file_get_contents("php://input"), true);

        
        $json['placa'] = $_POST['placa'];
        $json['marca']= $_POST['marca'];
        $json['cant_pasajeros'] = $_POST['cant_pasajeros'];
    
        require_once  ("./Models/carroModel.php");

        $model = new carroModel();

        $result = $model->create();

        $json['id_carro'] = $result;

        header('Content-type:application/json;charset=utf-8');
        return json_encode($json);
        
    }

    public function read(){
        
        require_once  ("./Models/carroModel.php");

        $model = new carroModel();

        header('Content-type:application/json;charset=utf-8');
        return json_encode($model->read());
     
    }

    public function delete(){
        
        require_once  ("./Models/carroModel.php");

        $model = new carroModel();
        
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            'mensaje' => "Registro eliminado correctamente",
            'Carro eliminado' => $model->delete()
        ]);
     
    }


    public function update(){

        $json['placa'] = $_POST['placa'];
        $json['marca']= $_POST['marca'];
        $json['cant_pasajeros'] = $_POST['cant_pasajeros'];
        $json['id'] = $_POST['id'];
        
        require_once  ("./Models/carroModel.php");

        $model = new carroModel();

        $model->update();
        
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            'mensaje' => "Registro actualizado correctamente",
            'Carro actualizado' => $json
        ]);
     
    }

    
    public function carro(){

         
        require_once  ("./Models/carroModel.php");

        $model = new carroModel();

        header('Content-type:application/json;charset=utf-8');
        return json_encode($model->carro());
     
    }

   


}
