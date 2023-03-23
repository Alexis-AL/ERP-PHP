<?php
    require_once 'config/config.php';
    require_once 'config/functions.php';
    $id=$_GET['id'];
    print ($id);
    $conexion = connect($server,$port,$db,$user,$pass);
    if(!$conexion){
        die("Conexion fallida: " . mysqli_connect_error());
    }
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
    AND Empleados.idEmpleados = $id";
    $diaI="SELECT Fecha FROM Dia WHERE FidEmpleados=$id LIMIT 1";
    $diaF="SELECT Fecha FROM Dia WHERE FidEmpleados=$id ORDER BY Fecha DESC LIMIT 1";
    $dias="SELECT COUNT(Fecha)FROM Dia WHERE FidEmpleados=$id";

    $diaI1 = $conexion->prepare($diaI);
    $diaI1->execute();
    $diaIF = $diaI1->fetchAll();

    $diaF1 = $conexion->prepare($diaF);
    $diaF1->execute();
    $diaFF = $diaF1->fetchAll();

    $dias1 = $conexion->prepare($dias);
    $dias1->execute();
    $diasF = $dias1->fetchAll();

    $empleado1 = $conexion->prepare($empleado);
    $empleado1->execute();
    $empleadoF = $empleado1->fetchAll();


    $sueldo = (($empleadoF[0]['HORAS_TOTALES']*$empleadoF[0]['Sueldo_Base'])+
    ($empleadoF[0]['HorasExtras']*($empleadoF[0]['Sueldo_Base']*2))+$empleadoF[0]['indemnizacion']+
    $empleadoF[0]['Transporte']+$empleadoF[0]['GastosMaterial']+$empleadoF[0]['Complementos']+
    $empleadoF[0]['Incentivo']);

    $deduccion= ($sueldo*(($empleadoF[0]['IMSS']+$empleadoF[0]['ISR']+$empleadoF[0]['IRPF'])*.01))+
    $empleadoF[0]['Vales_Despensa']+$empleadoF[0]['CobroQuincenal'];

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomina</title>

    <link rel="stylesheet" href="styles/nomina.css">
</head>
<body>
    <section>
        <article>
            <h1 id="nomina">Nómina</h1><br>
           <img src="img/logo2.jpeg"> 
            <h1 id="nameEmpresa">CAMM</h1><br>
            <table class="empresa">
                <tr>
                    <td><b>Empresa:</b> CAMM</td>
                </tr>
              
                <tr>
                    <td><b>Dirección:</b> ????</td>
                </tr>
               
                <tr>
                    <td><b>Grupo de cotización S.S.:</b> 000</td>
                </tr>
            </table>

            
            <br><br><br>

            <table class="worker">
                <caption><h2>Datos generales</h2></caption>
                <tbody>
                    <tr>
                        <td><b>Nombre:</b></td>
                        <td><?php echo $empleadoF[0]['Nombre'] ?></td>
                        <td><b>Puesto:</b></td>
                        <td><?php echo $empleadoF[0]['Puesto'] ?></td>
                    </tr>

                    <tr>
                        <td><b>NSS:</b></td>
                        <td><?php echo $empleadoF[0]['NSS'] ?></td>
                        <td><b>Antiguedad:</b></td>
                        <td><?php echo $empleadoF[0]['FechaDeIngreso'] ?></td>
                    </tr>
                </tbody>
            </table><br>

            <table class="liquidacion">
                <caption><h2>Periodo Liquidación</h2></caption>
                <tbody>
                    <!-- este tambien -->
                    <tr>
                        <td><b>Fecha inicial:</b></td>
                        <td><?php echo $diaIF[0]['Fecha'] ?></td>
                        <!-- Poke fecha final -->
                        <td><b>Fecha final: </b></td>
                        <td><?php echo $diaFF[0]['Fecha'] ?></td>
                        <td id="totalDays"><b>Total días:</b> <?php echo $diasF[0]['COUNT(Fecha)']?></td>
                    </tr>
                </tbody>
            </table><br>


            <table class="devengos">
                <caption><h2>Devengos</h2></caption>
                <tbody>
                <table class="percep-Sal">
                    <caption id="percepSal"><h3>Percepciones Salariales</h3></caption>
                        <thead>
                            <tr class="encabezadoTable">
                                <th scope="col"></th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
    
                        <tbody>
                            <tr>
                                <td>Salario base</td>
                                <td>$<?php echo $empleadoF[0]['HORAS_TOTALES']?></td>
                                <td>$<?php echo $empleadoF[0]['Sueldo_Base']?></td>
                                <td>$<?php echo $empleadoF[0]['HORAS_TOTALES']*$empleadoF[0]['Sueldo_Base']?></td>
                            </tr>
    
                            <tr>
                                <td>Horas extra</td>
                                <td>$<?php echo $empleadoF[0]['HorasExtras']?></td>
                                <td>$<?php echo $empleadoF[0]['Sueldo_Base']*2?></td>
                                <td>$<?php echo $empleadoF[0]['HorasExtras']*($empleadoF[0]['Sueldo_Base']*2)?></td>
                            </tr>
    
                            <tr>
                                <td>Incentivos</td>
                                <td></td>
                                <td></td>
                                <td>$<?php echo $empleadoF[0]['Incentivo'] ?></td> 
                            </tr>
                    </tbody>
                </table>
    
    
                <table class="percep-NoSal">
                    <caption id="percepNo"><h3>Percepciones no salariales</h3></caption>
                    <tbody>
                        <tr>
                            <td>Indemnizaciones</td>
                            <td></td>
                            <td></td>
                            <td>$<?php echo $empleadoF[0]['indemnizacion'] ?></td>
                        </tr>
        
                       <tr>
    
                   <tr>
                       <td>Transporte</td>
                       <td></td>
                        <td></td>
                       <td>$<?php echo $empleadoF[0]['Transporte'] ?></td>
                   </tr> 
    
                   <tr>
                       <td>Gastos de Material</td>
                       <td></td>
                        <td></td>
                       <td>$<?php echo $empleadoF[0]['GastosMaterial'] ?></td>
                   </tr>
    
                   <tr>
                       <td>Complementos a cargo de la empresa</td>
                       <td></td>
                        <td></td>
                       <td>$<?php echo $empleadoF[0]['Complementos'] ?></td>
                   </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                          <th scope="row" colspan="3">Total Devengado</th>
                          <td colspan="3" class="totales">$<?php echo $sueldo?></td>
                        </tr><br>
                    </tfoot>
                </table>
            </tbody>
            </table>
            

            <table class="deducciones">
                <caption><h2>Deducciones</h2></caption>
                <tbody>
                    <tr>
                        <td><b>Vales de Despensa</b></td>
                        <td></td>
                        <td></td>
                        <td>$<?php echo $empleadoF[0]['Vales_Despensa'] ?></td>
                    </tr>

                    <tr>
                        <td><b>Préstamos</b></td>
                        <td></td>
                        <td></td>
                        <td>$<?php echo $empleadoF[0]['CobroQuincenal'] ?></td>
                    </tr>

                    <tr>
                        <td><b>Seguro Social</b></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $empleadoF[0]['IMSS'] ?>%</td>
                    </tr>

                    <tr>
                        <td><b>ISR</b></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $empleadoF[0]['ISR'] ?>%</td>
                    </tr>

                    <tr>
                        <td><b>IRPF</b></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $empleadoF[0]['IRPF'] ?>%</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                      <th scope="row" colspan="3">Total a Deducir</th>
                      <td colspan="3" class="totales">$<?php echo $deduccion?></td>
                    </tr><br>
                </tfoot>
            </table><br>

            <table class="dineroAPercibir">
                <tbody>
                    <tr>
                        <th scope="row" colspan="3">Dinero a percibir</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="3">$<?php echo $sueldo-$deduccion?></td>
                    </tr>
                </tbody>
            </table>

           <table class="firmasYSellos">
               <tbody>
                    <caption><h2>Firmas y sellos</h2></caption>
                    <tr>
                        <td><b>Lugar de emisión:</b></td>
                        <td></td>
                    </tr>
                    
                    <tr class="firma">
                        <td><br><b>Firma</b><br></td><br>
                    </tr>

                    <tr class="sello">
                        <td><br><br><b>Sello</b><br><br><br><br><br</td>
                    </tr>
               </tbody>
           </table> 


        <input type="submit" name="Submit" value="Imprimir" onclick="javascript:window.print()">

        </article>
    </section>
</body>
</html>
