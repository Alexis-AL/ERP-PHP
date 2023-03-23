<script>
    function alerta1() {
        alert("Contraseñas no coinciden");
        history.go(-1);
    }
    function alerta2() {
        alert("Existe un usuario con misma CURP O NSS");
        history.go(-1);

    }
    

</script>


<?php 
require './config.php';
require './functions.php';
$name=$_POST['name'];
$lastname=$_POST['lastname'];
$tel=$_POST['tel'];
$curp=$_POST['curp'];
$address=$_POST['address'];
$puesto=$_POST['puesto'];
$fecha=$_POST['fecha'];
$jornada=$_POST['jornada'];
$NSS=$_POST['NSS'];
$pw=$_POST['pw'];
$rpw=$_POST['rpw'];
if($pw!=$rpw){
    echo '<script>alerta1();</script>';
}else{
    $conexion = connect($server,$port,$db,$user,$pass);
    $sql="SELECT * FROM Empleados WHERE NSS='$NSS' OR CURP='$curp';";
    $Muestreo = $conexion->prepare($sql);
    $Muestreo->execute();
    $r_muestreo = $Muestreo->fetchAll();
    if(count($r_muestreo)>0){
        echo '<script>alerta2();</script>';
    }else{
    $sql="INSERT INTO Empleados (Nombre,Apellido,Telefono,CURP,Direccion,Puesto,Jornada,FechaDeIngreso,NSS,pw) VALUES ('$name','$lastname','$tel','$curp','$address','$puesto','$jornada','$fecha','$NSS','$pw')";
    $consulta=$conexion->prepare($sql);
    $consulta->execute();
    $sql="SELECT * FROM Empleados WHERE CURP='$curp'";
    $consulta=$conexion->prepare($sql);
    $consulta->execute();
    $r=$consulta->fetchAll();
    $ID=$r[0]['idEmpleados'];
    
    echo '<script>
    function alerta(){
        alert("Empleado agregado correctamente su ID es: '.$ID.'");
    }
    alerta();
    </script>';

   switch ($puesto) {
       case 'Administrador':
            // -- insert PS

            $sql="INSERT INTO PS (Sueldo_Base,Vales_Despensa,FidEmpleados) VALUES (50,300,$ID);";
            $consulta=$conexion->prepare($sql);
            $consulta->execute();

            // -- Insert PSN 
            $sql="INSERT INTO PNS (Vacaciones,Transporte,GastosMaterial,Complementos,C_Transporte,C_Gasto,C_Complemento,FidEmpleados) VALUES
            (0,200,200,200,'Pago de transporte base','Gastos De material base','Complemento base',$ID);";
            $consulta=$conexion->prepare($sql);
            $consulta->execute();


           break;
       case 'Gerente':
            // -- insert PS

            $sql="INSERT INTO PS (Sueldo_Base,Vales_Despensa,FidEmpleados) VALUES (40,250,$ID);";
            $consulta=$conexion->prepare($sql);
            $consulta->execute();

            // -- Insert PSN 
            $sql="INSERT INTO PNS (Vacaciones,Transporte,GastosMaterial,Complementos,C_Transporte,C_Gasto,C_Complemento,FidEmpleados) VALUES
            (0,200,200,200,'Pago de transporte base','Gastos De material base','Complemento base',$ID);";
            $consulta=$conexion->prepare($sql);
            $consulta->execute();

           break;
       case 'Soldador':
            // -- insert PS

            $sql="INSERT INTO PS (Sueldo_Base,Vales_Despensa,FidEmpleados) VALUES (30,200,$ID);";
            $consulta=$conexion->prepare($sql);
            $consulta->execute();

            // -- Insert PSN 
            $sql="INSERT INTO PNS (Vacaciones,Transporte,GastosMaterial,Complementos,C_Transporte,C_Gasto,C_Complemento,FidEmpleados) VALUES
            (0,200,200,200,'Pago de transporte base','Gastos De material base','Complemento base',$ID);";
            $consulta=$conexion->prepare($sql);
            $consulta->execute();

           break;   
      
   }
     // -- Insertar presatmo
     $sql="INSERT INTO Prestamo (Fecha,Concepto,Cantidad,CobroQuincenal,FidEmpleados) VALUES
     ('0000-00-00','',0,0,$ID);";
     $consulta=$conexion->prepare($sql);
     $consulta->execute();
     
     $sql="SELECT * FROM PNS WHERE FidEmpleados=$ID";
    $consulta=$conexion->prepare($sql);
    $consulta->execute();
    $r=$consulta->fetchAll();
    $IDPNS=$r[0]['idPNS'];
     // -- Insert Indemnizacion
     $sql="INSERT INTO Indemnizaciones (Concepto,Indemnizacion,FidPNS) VALUES
     ('',0,$IDPNS);";
     $consulta=$conexion->prepare($sql);
     $consulta->execute();


    $sql="SELECT * FROM PS WHERE FidEmpleados=$ID";
    $consulta=$conexion->prepare($sql);
    $consulta->execute();
    $r=$consulta->fetchAll();
    $IDPS=$r[0]['idPS'];

     // -- Insert incentivos
     $sql="INSERT INTO Incentivos (Concepto,Incentivo,FidPS) VALUES
     ('',0,$IDPS);";
     $consulta=$conexion->prepare($sql);
     $consulta->execute();


     // -- Insert deducciones
     $sql="INSERT INTO Deducciones (IRPF,IMSS,ISR,FidPS) VALUES
     (1.92,7.2,25,$IDPS);";
     $consulta=$conexion->prepare($sql);
     $consulta->execute();

     header("Location: ./../Muestreo.php");
}
}


?>