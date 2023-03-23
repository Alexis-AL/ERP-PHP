<?php
require_once 'config/config.php';
require_once 'config/functions.php';
$conexion = connect($server,$port,$db,$user,$pass);

if(!$conexion){
    die("Conexion fallida: " . mysqli_connect_error());
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM empleados WHERE idEmpleados = '$usuario' AND pw = '$password';";
    $query = $conexion->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    if(count($resultado) ==1){
        //SI SE COMPRUEBA QUE EL PUESTO DEL USUARIO INGRESADO ES ADMIN
        //Pasa a otra pestaña donde se muestran los datos de todos los trabajadores
        if($resultado[0]['Puesto'] == "Administrador"){
 
            header('Location: Muestreo.php?id='.$resultado[0]['idEmpleados']);
        }else{
            //si no solo se registra su hora en la base de datos
            //esta con una tolerancia variable, por el momento 15 min
            //Extraccion de horas del dia
            $dt = new DateTime("now", new DateTimeZone('America/Mexico_City'));
            //extraccion de fecha del dia
            $fecha = $dt->format('Y-m-d');
            //extraccion de hora del dia de la salida
            $hora_salida=date_create($dt->format('H:i:s'));
            //extraccion de hora del dia de la entrada
            $dt->modify('-15 minute');
            //Creacion de la hora de entrada en formato de datetime
            $date1=date_create($dt->format('H:i:s'));
           

            //consulta para verificar si el empleado ya registro su entrada
            $comprobacion="SELECT * FROM dia WHERE $usuario = FidEmpleados and Fecha = '$fecha'";
            $compro = $conexion->prepare($comprobacion);
            $compro->execute();
            $resul = $compro->fetchAll();
            $BANDERA_ENTRADA=0;
            $BANDERA_SALIDA=0;
            //Comprueba que no haya resgistrado su hora de entrada el dia de hoy
            if(count($resul) == 0){
            }else{
            foreach($resul as $fila){
            if($fila['Rentrada'] == 1){
                $BANDERA_ENTRADA=1;
            }
            if($fila['Rsalida'] == 1){
                $BANDERA_SALIDA=1;
            }
        }
    }
          
            if($BANDERA_ENTRADA==0){
                $fecha=$dt->format('Y-m-d');
                $hora_entrada=$date1->format('H:i:s');
                $sql = "INSERT INTO dia (Fecha,H_Entrada,Rentrada,FidEmpleados) VALUES ('$fecha','$hora_entrada',1,'$usuario')";
                $query = $conexion->prepare($sql);
                $query->execute();
            }
            if($BANDERA_SALIDA==0 && $BANDERA_ENTRADA==1){
                $hora_salida=$hora_salida->format('H:i:s');
                $sql="UPDATE dia SET H_Salida = '$hora_salida', Rsalida = 1 WHERE FidEmpleados = '$usuario' AND Fecha = '$fecha'";
                $query = $conexion->prepare($sql);
                $query->execute();
            }
            if($BANDERA_SALIDA==1 && $BANDERA_ENTRADA==1){
            }



        }



    }else{
        
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/iniciar-sesion.png">
    <link rel="stylesheet" href="./styles/login.css">
    
    <title>CAMM</title>
</head>
<body>
    <header>
        
        <!-- linea de arriba -->
    </header>

            </nav>

    <section class="container">
        <div class="cuadro-login" >
        
            <div class="texto_login">
                <?php 
                if(isset($resultado)){
                    if($BANDERA_ENTRADA==0){
                    echo "<h1>Registraste Entrada ".$resultado[0]['Nombre']."</h1>";}
                    else if($BANDERA_SALIDA==0 && $BANDERA_ENTRADA==1){
                        echo "<h1>Registraste Salida ".$resultado[0]['Nombre']."</h1>";
                    }
                    else{
                        echo "<h1>Ya registraste tu entrada y tu salida</h1>";
                    }
                
                }
                ?>
                  <p> Bienvenido </p>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            
                <div class="entrada-datos">
<!-- No se como poner el icono y a un ladito en input -->   
                    <div class="lista1">                  
                        <ul>
                          <li> <img src="./img/user.png" alt=""> </li>
                          <li>  <input type="text" name="usuario" placeholder="Usuario" required>  </li>
                           
                        </ul>
                    </div>  
                    <div class="lista2">     
                        <ul>
                          <li>  <img src="./img/unlock.png" alt=""> </li>
                          <li>  <input type="password" name="password" placeholder="Contraseña" required></li>
                           
                        </ul>
                    </div>     
                              
                    </div>
                    
                    <input class="button" type="submit" value="Ingresar">
                </form>
            </div>
        </div>
    </section>

    <footer>
         <!-- linea de abajo -->
        
    </footer>
    <!-- Script para evitar reenvio de formulario -->
    <script src="./scripts/evitarReenvio.js"></script>
</body>
</html>