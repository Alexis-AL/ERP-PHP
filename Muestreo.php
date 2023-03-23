<?php
    require_once './config/config.php';
    require_once './config/functions.php';
   
    $conexion = connect($server,$port,$db,$user,$pass);
    if(!$conexion){
        die("Conexion fallida: " . mysqli_connect_error());
    }
    
    //consulta de horas tabla dia
    $dia = "SELECT * FROM dia;";
    $Horas = $conexion->prepare($dia);
    $Horas->execute();
    $r_horas = $Horas->fetchAll();

    //Establece las horas que se ha trabajado por dia para generar la tabla
    foreach ($r_horas as $key) :
        $h_e=date_create($key['H_Entrada']);
        $h_s=date_create($key['H_Salida']);
        $h_t=date_diff($h_e,$h_s);
        $H_total="UPDATE Dia SET H_Normales=".$h_t->h." WHERE idDia=".$key['idDia'].";";
        $H_total=$conexion->prepare($H_total);
        $H_total->execute();
        endforeach;    
    //echo "<br>-------Bienvenido Empleado\n---------";

    

    //Hace el total de horas trabajadas por
    $dia = "SELECT FidEmpleados,SUM(H_Normales) FROM dia GROUP BY FidEmpleados;";

    $Horas = $conexion->prepare($dia);
    $Horas->execute();
    $r_horas = $Horas->fetchAll();
    // Una vez generadas las horas se guardan en la tabla empleados
    foreach ($r_horas as $key) :
    $ACTUALIZAR="UPDATE ps SET HORAS_TOTALES=".$key['SUM(H_Normales)']." WHERE FidEmpleados=".$key['FidEmpleados'].";";
    $ACTUALIZAR=$conexion->prepare($ACTUALIZAR);
    $ACTUALIZAR->execute();
    endforeach;

    // Consulta general de los empleados

    $sql = "SELECT * FROM ps ;";
    $Muestreo = $conexion->prepare($sql);
    $Muestreo->execute();
    $r_muestreo = $Muestreo->fetchAll();

    //for para establecer las horas extra, este permite que,
    //si un empleado pasa las 120 horas base, las extra se pagen a mejor precio
    foreach ($r_muestreo as $key) :
        if($key["HORAS_TOTALES"]>120){
            $he=$key["HORAS_TOTALES"]-120;
            $EXTRAS="UPDATE PS SET HorasExtras=".$he." WHERE idPS=".$key['idPS'].";";
            $EXTRAS=$conexion->prepare($EXTRAS);
            $EXTRAS->execute();
            $hN="UPDATE ps SET HORAS_TOTALES=120 WHERE idPS=".$key['idPS'].";";
            $hN=$conexion->prepare($hN);
            $hN->execute();
        
        }
    endforeach;


    //ACTUALIZACION DE DATOS
    $sql = "SELECT * FROM empleados as e, ps WHERE e.idEmpleados=ps.FidEmpleados;";
    $Muestreo = $conexion->prepare($sql);
    $Muestreo->execute();
    $r_muestreo = $Muestreo->fetchAll();
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/root.css">
    <link rel="stylesheet" href="./styles/muestreo.css">
    <title>Información</title>
</head>
<body>
    <section class="main">
        <header class="topbar">
            <div class="left-side">
            <a href="./index.php"><h2>CAMM Nómina</h2></a>
            </div>
           <div class="right-side">
           <a href="./registro.php" class="topbar-link">
           Registrar Nuevo Empleado
            </a>
            <a href="./config/borrar.php" class="topbar-link">Borrar quincena</a>
           </div>
        </header>
        <article class='datos'>
            <h1 class="title" >Bienvenido al sistema de nómina</h1><br/>
            <h1 class="subtitle">Empleados Actuales</h1>
            <table Border>
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Nombre</td>
                    <td>Sueldo</td>
                    <td>H. Base</td>
                    <td>H. EXTRA</td>
                    <td>$$$$$</td>
                    <td>H. Totales</td>
                    <td>Modificar</td>
                    <td>Mas info</td>
                </tr>
                </thead>
                <tbody>
                <?php
                //imprime los empleados de la base de datos
                foreach($r_muestreo as $fila){

                    $empleado = "SELECT Nombre, Apellido, Puesto, NSS, FechaDeIngreso, idPNS, 
                    Transporte, GastosMaterial, Complementos,
                    idPS, Sueldo_Base, HorasExtras, Vales_Despensa, HORAS_TOTALES,
                    Incentivo, CobroQuincenal, indemnizacion, IMSS, IRPF, ISR
                    FROM Empleados 
                    INNER JOIN PNS ON Empleados.idEmpleados = PNS.FidEmpleados 
                    INNER JOIN PS ON Empleados.idEmpleados = PS.FidEmpleados
                    INNER JOIN Incentivos ON PS.idPS = Incentivos.FidPS
                    INNER JOIN Indemnizaciones ON PNS.idPNS = Indemnizaciones.FidPNS
                    INNER JOIN Deducciones ON PS.idPS = Deducciones.FidPS
                    INNER JOIN Prestamo ON Empleados.idEmpleados = Prestamo.FidEmpleados
                    AND Empleados.idEmpleados = $fila[FidEmpleados]";
                    $empleado1 = $conexion->prepare($empleado);
                    $empleado1->execute();
                    $empleadoF = $empleado1->fetchAll();
   


                    $sueldo = (($empleadoF[0]['HORAS_TOTALES']*$empleadoF[0]['Sueldo_Base'])+
                    ($empleadoF[0]['HorasExtras']*($empleadoF[0]['Sueldo_Base']*2))+$empleadoF[0]['indemnizacion']+
                    $empleadoF[0]['Transporte']+$empleadoF[0]['GastosMaterial']+$empleadoF[0]['Complementos']+
                    $empleadoF[0]['Incentivo']);
                
                    $deduccion= ($sueldo*(($empleadoF[0]['IMSS']+$empleadoF[0]['ISR']+$empleadoF[0]['IRPF'])*.01))+
                    $empleadoF[0]['Vales_Despensa']+$empleadoF[0]['CobroQuincenal'];
                    echo "<tr>";
                    echo "<td>".$fila['idEmpleados']."</td>";
                    echo "<td>".$fila['Nombre']." ".$fila['Apellido']."</td>";
                    echo "<td>".$fila['Sueldo_Base']."</td>";
                    echo "<td>".$fila['HORAS_TOTALES']."</td>";
                    echo "<td>".$fila['HorasExtras']."</td>";
                    echo "<td>".$sueldo-$deduccion."</td>";
                    echo "<td>".$fila['HORAS_TOTALES']+$fila['HorasExtras']."</td>";
                    echo "<td><a href='Modificar.php?id=".$fila['idEmpleados']."'>Modificar</a></td>";
                    echo "<td><a href='Nomina.php?id=".$fila['idEmpleados']."'>Desglose</a></td>";
                }
                ?>
                </tbody>
            </table>
        </article>
    </section>

</body>
</html>