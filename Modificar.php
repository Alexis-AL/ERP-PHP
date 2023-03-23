<?php
require_once 'config/config.php';
require_once 'config/functions.php';
$conexion = connect($server, $port, $db, $user, $pass);
$id = $_GET['id'];

// ************** TABLA DE EMPLEADOS ********************
// Seleccionar la informacion del empleado por id
$empleado = "SELECT * FROM empleados WHERE idEmpleados=" . $id . ";";
$empleado = $conexion->prepare($empleado);
$empleado->execute();
$r_empleado = $empleado->fetchAll();
foreach ($r_empleado as $keyEmpleado) :
    $idEmpleado = $keyEmpleado['idEmpleados'];
    $nombre = $keyEmpleado['Nombre'];
    $apellido = $keyEmpleado['Apellido'];
    $telefono = $keyEmpleado['Telefono'];
    $curp = $keyEmpleado['CURP'];
    $direccion = $keyEmpleado['Direccion'];
    $puesto = $keyEmpleado['Puesto'];
    $jornada = $keyEmpleado['Jornada'];
    $fechadeingreso = $keyEmpleado['FechaDeIngreso'];
    $nss = $keyEmpleado['NSS'];
endforeach;

// Modificar empleado al dar click en el boton
if (isset($_POST['modificarEmpleado'])) {
    $nombre = $_POST['empNombre'];
    $apellido = $_POST['empApellido'];
    $telefono = $_POST['empTelefono'];
    $curp = $_POST['empCurp'];
    $direccion = $_POST['empDireccion'];
    $puesto = $_POST['empPuesto'];
    $jornada = $_POST['empJornada'];
    $fechadeingreso = $_POST['empFechaDeIngreso'];
    $nss = $_POST['empNss'];

    $sql = "UPDATE empleados SET Nombre= '" . $nombre . "' , Apellido= '" . $apellido . "' , Telefono= '" . $telefono . "' , CURP= '" . $curp . "' , Direccion= '" . $direccion . "' , Puesto= '" . $puesto . "' , Jornada= '" . $jornada . "' , FechaDeIngreso= '" . $fechadeingreso . "' , NSS= '" . $nss . "' WHERE idEmpleados= '" . $idEmpleado . "'";
    $sql = $conexion->prepare($sql);
    $sql->execute();
}
// *************** FIN TABLA DE EMPLEADOS ********************


// **************** TABLA DE PS / PRESTACIONES SALARIALES ********************
// Seleccionar la informacion del ps
$ps = "SELECT * FROM ps WHERE FidEmpleados=" . $id . ";";
$ps = $conexion->prepare($ps);
$ps->execute();
$r_ps = $ps->fetchAll();
foreach ($r_ps as $keyPS) :
    $idPS = $keyPS['idPS'];
    $Sueldo_Base = $keyPS['Sueldo_Base'];
    $HorasExtras = $keyPS['HorasExtras'];
    $HorasTotales = $keyPS['HORAS_TOTALES'];
    $Vales_Despensa = $keyPS['Vales_Despensa'];
    $Festivo_laborado = $keyPS['Festivo_laborado'];
    $FidEmpleados = $keyPS['FidEmpleados'];
endforeach;

// Modificar ps al dar click en el boton
if (isset($_POST['modificarPS'])) {
    $Sueldo_Base = $_POST['psSueldoBase'];
    $HorasExtras = $_POST['psHorasExtras'];
    $HorasTotales = $_POST['psHorasTotales'];
    $Vales_Despensa = $_POST['psValesDespensa'];
    $Festivo_laborado = $_POST['psDiasFestivosLaborados'];

    $sql = "UPDATE ps SET Sueldo_Base= '" . $Sueldo_Base . "' , HorasExtras= '" . $HorasExtras . "' , HORAS_TOTALES= '" . $HorasTotales . "' , Vales_Despensa= '" . $Vales_Despensa . "' , Festivo_laborado= '" . $Festivo_laborado . "' WHERE FidEmpleados= '" . $idEmpleado . "'";
    $sql = $conexion->prepare($sql);
    $sql->execute();
}
// ******************* FIN TABLA DE PS / PRESTACIONES SALARIALES ********************

// ******************* TABLA DE INCENTIVOS ********************
// Seleccionar la informacion del incentivo
$incentivo = "SELECT idIncentivos, Incentivo, concepto, FidPS FROM incentivos, ps WHERE ps.FidEmpleados = " . $id . " AND incentivos.FidPS = ps.idPS;";
$incentivo = $conexion->prepare($incentivo);
$incentivo->execute();
$r_incentivo = $incentivo->fetchAll();
foreach ($r_incentivo as $keyIncentivo) :
    $idIncentivo = $keyIncentivo['idIncentivos'];
    $Incentivo = $keyIncentivo['Incentivo'];
    $concepto = $keyIncentivo['concepto'];
    $FidPS = $keyIncentivo['FidPS'];
endforeach;

// Modificar incentivo al dar click en el boton
if (isset($_POST['modificarIncentivo'])) {
    $Incentivo = $_POST['incIncentivo'];
    $concepto = $_POST['incConcepto'];

    $sql = "UPDATE incentivos SET Incentivo= '" . $Incentivo . "' , concepto= '" . $concepto . "'  WHERE idIncentivos= '" . $idIncentivo . "'";
    $sql = $conexion->prepare($sql);
    $sql->execute();
}
// ***************** FIN TABLA DE INCENTIVOS ********************

// ***************** TABLA DE DEDUCCIONES ********************
// Seleccionar la informacion de las deducciones
$deduccion = "SELECT idDeducciones, IRPF, IMSS, ISR, FidPS FROM deducciones, ps WHERE ps.FidEmpleados = '" . $id . "' AND deducciones.FidPS = ps.idPS;";
$deduccion = $conexion->prepare($deduccion);
$deduccion->execute();
$r_deduccion = $deduccion->fetchAll();
foreach ($r_deduccion as $keyDeduccion) :
    $idDeduccion = $keyDeduccion['idDeducciones'];
    $IRPF = $keyDeduccion['IRPF'];
    $IMSS = $keyDeduccion['IMSS'];
    $ISR = $keyDeduccion['ISR'];
    $FidPS = $keyDeduccion['FidPS'];
endforeach;

// Modificar deduccion al dar click en el boton
if (isset($_POST['modificarDeduccion'])) {
    $IRPF = $_POST['deduccionIRPF'];
    $IMSS = $_POST['deduccionIMSS'];
    $ISR = $_POST['deduccionISR'];

    $sql = "UPDATE deducciones SET IRPF= '" . $IRPF . "' , IMSS= '" . $IMSS . "' , ISR= '" . $ISR . "' WHERE idDeducciones= '" . $idDeduccion . "'";
    $sql = $conexion->prepare($sql);
    $sql->execute();
}
// ***************** FIN TABLA DE DEDUCCIONES ********************

// ***************** TABLA DE PERCEPCIONES NO SALARIALES ********************
// Seleccionar la informacion de las percepciones no salariales
$pns = "SELECT idPNS, Vacaciones, FidEmpleados, Transporte, GastosMaterial, Complementos, C_Gasto, C_Complemento, C_Transporte FROM pns WHERE FidEmpleados = '" . $id . "';";
$pns = $conexion->prepare($pns);
$pns->execute();
$r_pns = $pns->fetchAll();
foreach ($r_pns as $keyPNS) :
    $idPNS = $keyPNS['idPNS'];
    $Vacaciones = $keyPNS['Vacaciones'];
    $Transporte = $keyPNS['Transporte'];
    $GastosMaterial = $keyPNS['GastosMaterial'];
    $Complementos = $keyPNS['Complementos'];
    $C_Gasto = $keyPNS['C_Gasto'];
    $C_Complemento = $keyPNS['C_Complemento'];
    $C_Transporte = $keyPNS['C_Transporte'];
    $FidEmpleados = $keyPNS['FidEmpleados'];
endforeach;

// Modificar pns al dar click en el boton
if (isset($_POST['modificarPNS'])) {
    $Vacaciones = $_POST['pnsVacaciones'];
    $Transporte = $_POST['pnsTransporte'];
    $GastosMaterial = $_POST['pnsGastosMaterial'];
    $Complementos = $_POST['pnsComplementos'];
    $C_Gasto = $_POST['pnsC_Gasto'];
    $C_Complemento = $_POST['pnsC_Complemento'];
    $C_Transporte = $_POST['pnsC_Transporte'];

    $sql = "UPDATE pns SET Vacaciones= '" . $Vacaciones . "' , Transporte= '" . $Transporte . "' , GastosMaterial= '" . $GastosMaterial . "' , Complementos= '" . $Complementos . "' , C_Gasto= '" . $C_Gasto . "' , C_Complemento= '" . $C_Complemento . "' , C_Transporte= '" . $C_Transporte . "' WHERE idPNS= '" . $idPNS . "'";
    $sql = $conexion->prepare($sql);
    $sql->execute();
}
// ***************** FIN TABLA DE PERCEPCIONES NO SALARIALES ********************

// ******************* TABLA DE INDEMNIZACIONES ********************
// Seleccionar la informacion de las indemnizaciones
$indemnizacion = "SELECT idIndemnizaciones, indemnizacion, Concepto, FidPNS, FidEmpleados, idPNS FROM indemnizaciones, pns WHERE FidEmpleados = '" . $id . "' AND FidPNS = idPNS";
$indemnizacion = $conexion->prepare($indemnizacion);
$indemnizacion->execute();
$r_indemnizacion = $indemnizacion->fetchAll();
foreach ($r_indemnizacion as $keyIndemnizacion) :
    $idIndemnizacion = $keyIndemnizacion['idIndemnizaciones'];
    $indemnizacion = $keyIndemnizacion['indemnizacion'];
    $Concepto = $keyIndemnizacion['Concepto'];
    $FidPNS = $keyIndemnizacion['FidPNS'];
    $FidEmpleados = $keyIndemnizacion['FidEmpleados'];
    $idPNS = $keyIndemnizacion['idPNS'];
endforeach;

// Modificar indemnizacion al dar click en el boton
if (isset($_POST['modificarIndemnizacion'])) {
    $indemnizacion = $_POST['indemnizacion'];
    $Concepto = $_POST['concepto'];

    $sql = "UPDATE indemnizaciones SET indemnizacion= '" . $indemnizacion . "' , Concepto= '" . $Concepto . "' WHERE idIndemnizaciones= '" . $idIndemnizacion . "'";
    $sql = $conexion->prepare($sql);
    $sql->execute();
}
// ******************* FIN TABLA DE INDEMNIZACIONES ********************

// ****************** TABLA DE PRESTAMOS ********************
// Seleccionar la informacion de los prestamos
$prestamos = "SELECT * FROM prestamo WHERE FidEmpleados = '" . $id . "'";
$prestamos = $conexion->prepare($prestamos);
$prestamos->execute();
$r_prestamos = $prestamos->fetchAll();
foreach ($r_prestamos as $keyPrestamos) :
    $idPrestamo = $keyPrestamos['idPrestamo'];
    $Fecha = $keyPrestamos['Fecha'];
    $Concepto = $keyPrestamos['Concepto'];
    $Cantidad = $keyPrestamos['Cantidad'];
    $CobroQuincenal = $keyPrestamos['CobroQuincenal'];
    $FidEmpleado = $keyPrestamos['FidEmpleados'];
endforeach;

// Modificar prestamos al dar click en el boton
if (isset($_POST['modificarPrestamo'])) {
    $Fecha = $_POST['prestamosFecha'];
    $Concepto = $_POST['prestamosConcepto'];
    $Cantidad = $_POST['prestamosCantidad'];
    $CobroQuincenal = $_POST['prestamosCobroQuincenal'];

    $sql = "UPDATE prestamo SET Fecha= '" . $Fecha . "' , Concepto= '" . $Concepto . "' , Cantidad= '" . $Cantidad . "' , CobroQuincenal= '" . $CobroQuincenal . "' WHERE idPrestamo= '" . $idPrestamo . "'";
    $sql = $conexion->prepare($sql);
    $sql->execute();
}
// ****************** FIN TABLA DE PRESTAMOS ********************

// ****************** TABLA DE Dias ********************
$sql = "SELECT * FROM dia WHERE FidEmpleados = '" . $id . "'";
$sql = $conexion->prepare($sql);
$sql->execute();
$r_dias = $sql->fetchAll();

if (isset($_POST['modificarDia'])) {
    $entrada = $_POST['entrada'];
    $salida = $_POST['salida'];
    $dia = $_POST['dia'];
    $sql = "UPDATE dia SET H_Entrada = '" . $entrada . "', H_Salida = '" . $salida . "' WHERE idDia = '" . $dia . "'";
    $sql = $conexion->prepare($sql);
    $sql->execute();
    header("Refresh:1");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/muestreo.css">
    <link rel="stylesheet" href="./styles/modificar.css">
</head>

<body>
    <!-- Pruebas -->
    <!-- Seccion para ver la informacion  una tabla -->
    <!-- <section>
        <div>
            <div>
                <h1>Empleado</h1> -->
    <!-- Imprime los datos del empleado con php -->
    <!-- <?php
            foreach ($r_empleado as $key) :
                echo "<br> ID: " . $key['idEmpleados'] . "<br>";
                echo "<br> Nombre: " . $key['Nombre'] . "<br>";
                echo "<br> Apellido: " . $key['Apellido'] . "<br>";
                echo "<br> Telefono: " . $key['Telefono'] . "<br>";
                echo "<br> CURP: " . $key['CURP'] . "<br>";
                echo "<br> Direccion: " . $key['Direccion'] . "<br>";
                echo "<br> Puesto: " . $key['Puesto'] . "<br>";
                echo "<br> Jornada: " . $key['Jornada'] . "<br>";
                echo "<br> FechaDeIngreso: " . $key['FechaDeIngreso'] . "<br>";
                echo "<br> NSS: " . $key['NSS'] . "<br>";
                echo "<br> HORAS_TOTALES: " . $key['HORAS_TOTALES'] . "<br>";
                echo "<br> HORAS_EXTRA: " . $key['HORAS_EXTRA'] . "<br>";
            endforeach;
            ?>
            </div>
        </div>
    </section> -->
    <header class="topbar">
        <div class="left-side">
            <h2>CAMM Nómina</h2>
        </div>
        <div class="right-side">
            <a href="./muestreo.php" class="topbar-link">
                Atrás
            </a>

        </div>
    </header>
    <div class="main-content">
        <!-- Seccion para el grupo de botones que abren modales para modificaciones -->
        <!-- <section>

            <div>
                <div>
                    <h1>Botones para abrir modales</h1>
                    <button>
                        Modificar Empleado
                    </button>
                    <button>
                        Modificar Percepciones Salariales
                    </button>
                    <button>
                        Modificar Incentivos
                    </button>
                    <button>
                        Modificar Deducciones
                    </button>
                    <button>
                        Modificar Percepciones No Salariales
                    </button>
                    <button>
                        Modificar Indemnizaciones
                    </button>
                    <button>
                        Modificar Prestamos
                    </button>
                </div>
            </div>
        </section> -->

        <!-- Formulario para modificar al empleado -->
        <section>
            <div>
                <div>
                    <h1>Modificar Empleado</h1>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <label for="empNombre">Nombre</label><br>
                        <input type="text" name="empNombre" id="empNombre" value="<?php echo $keyEmpleado['Nombre']; ?>" required><br>

                        <label for="empApellido">Apellido</label><br>
                        <input type="text" name="empApellido" id="empApellido" value="<?php echo $keyEmpleado['Apellido']; ?>" required><br>

                        <label for="empTelefono">Telefono</label><br>
                        <input type="number" name="empTelefono" id="empTelefono" value="<?php echo $keyEmpleado['Telefono']; ?>"><br>

                        <label for="empCurp">CURP</label><br>
                        <input type="text" name="empCurp" id="empCurp" value="<?php echo $keyEmpleado['CURP']; ?>"><br>

                        <label for="empDireccion">Direccion</label><br>
                        <input type="text" name="empDireccion" id="empDireccion" value="<?php echo $keyEmpleado['Direccion']; ?>"><br>

                        <label for="empPuesto">Puesto</label><br>
                        <input type="text" name="empPuesto" id="empPuesto" value="<?php echo $keyEmpleado['Puesto']; ?>" required><br>

                        <label for="empJornada">Jornada</label><br>
                        <input type="text" name="empJornada" id="empJornada" value="<?php echo $keyEmpleado['Jornada']; ?>" required><br>

                        <label for="empFechaDeIngreso">FechaDeIngreso</label><br>
                        <input type="date" name="empFechaDeIngreso" id="empFechaDeIngreso" value="<?php echo $keyEmpleado['FechaDeIngreso']; ?>" required><br>

                        <label for="empNss">NSS</label><br>
                        <input type="text" name="empNss" id="empNss" value="<?php echo $keyEmpleado['NSS']; ?>" required><br> <br>

                        <!-- Modificar la informacion del empleado al dar click en el boton -->
                        <button type="submit" name="modificarEmpleado">Modificar</button </form>
                </div>
            </div>
        </section>

        <!-- Formulario para modificar las percepciones salariales -->
        <section>
            <div>
                <div>
                    <h1>Modificar Percepciones Salariales</h1>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <label for="psSueldoBase">Sueldo Base</label><br>
                        <input type="number" name="psSueldoBase" id="psSueldoBase" value="<?php echo $keyPS['Sueldo_Base']; ?>" required><br>

                        <label for="psHorasExtras">Horas Extras</label><br>
                        <input type="number" name="psHorasExtras" id="psHorasExtras" value="<?php echo $keyPS['HorasExtras']; ?>"><br>

                        <label for="psHorasTotales">Horas Totales</label><br>
                        <input type="number" name="psHorasTotales" id="psHorasTotales" value="<?php echo $keyPS['HORAS_TOTALES']; ?>"><br>

                        <label for="psValesDespensa">Vales Despensa</label><br>
                        <input type="number" name="psValesDespensa" id="psValesDespensa" value="<?php echo $keyPS['Vales_Despensa']; ?>"><br>

                        <label for="psDiasFestivosLaborados">Días Festivos Laborados</label><br>
                        <input type="number" name="psDiasFestivosLaborados" id="psDiasFestivosLaborados" value="<?php echo $keyPS['Festivo_laborado']; ?>"><br><br>

                        <button type="submit" name="modificarPS">Modificar</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Formulario para modificar los incentivos -->
        <section>
            <div>
                <div>
                    <h1>Modificar Incentivos</h1>
                    <form method="POST">

                        <label for="incIncentivo">Incentivo</label><br>
                        <input type="number" name="incIncentivo" id="incIncentivo" value="<?php echo $keyIncentivo['Incentivo']; ?>"><br>

                        <!-- Concepto -->
                        <label for="incConcepto">Concepto</label><br>
                        <input type="text" name="incConcepto" id="incConcepto" value="<?php echo $keyIncentivo['concepto']; ?>"><br><br>

                        <button type="submit" name="modificarIncentivo">Modificar</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Formulario para modificar las deducciones -->
        <section>
            <div>
                <div>
                    <h1>Modificar Deducciones</h1>
                    <form method="POST">
                        <label for="deduccionIRPF">IRPF</label><br>
                        <input type="number" name="deduccionIRPF" id="deduccionIRPF" value="<?php echo $keyDeduccion['IRPF']; ?>"><br>

                        <label for="deduccionIMSS">IMSS</label><br>
                        <input type="number" name="deduccionIMSS" id="deduccionIMSS" value="<?php echo $keyDeduccion['IMSS']; ?>"><br>

                        <label for="deduccionISR">ISR</label><br>
                        <input type="number" name="deduccionISR" id="deduccionISR" value="<?php echo $keyDeduccion['ISR']; ?>"><br><br>

                        <button type="submit" name="modificarDeduccion">Modificar</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Formulario para modificar las percepciones no salariales -->
        <section>
            <div>
                <div>
                    <h1>Modificar Percepciones No Salariales</h1>
                    <form method="POST">

                        <label for="pnsVacaciones">Vacaciones</label><br>
                        <input type="number" name="pnsVacaciones" id="pnsVacaciones" value="<?php echo $keyPNS['Vacaciones']; ?>"><br>

                        <label for="pnsTransporte">Transporte</label><br>
                        <input type="number" name="pnsTransporte" id="pnsTransporte" value="<?php echo $keyPNS['Transporte']; ?>"><br>

                        <label for="pnsGastosMaterial">GastosMaterial</label><br>
                        <input type="number" name="pnsGastosMaterial" id="pnsGastosMaterial" value="<?php echo $keyPNS['GastosMaterial']; ?>"><br>

                        <label for="pnsComplementos">Complementos</label><br>
                        <input type="number" name="pnsComplementos" id="pnsComplementos" value="<?php echo $keyPNS['Complementos']; ?>"><br>

                        <label for="pnsC_Gasto">C_Gasto</label><br>
                        <input type="text" name="pnsC_Gasto" id="pnsC_Gasto" value="<?php echo $keyPNS['C_Gasto']; ?>"><br>

                        <label for="pnsC_Complemento">C_Complemento</label><br>
                        <input type="text" name="pnsC_Complemento" id="pnsC_Complemento" value="<?php echo $keyPNS['C_Complemento']; ?>"><br>

                        <label for="pnsC_Transporte">C_Transporte</label><br>
                        <input type="text" name="pnsC_Transporte" id="pnsC_Transporte" value="<?php echo $keyPNS['C_Transporte']; ?>"><br><br>

                        <button type="submit" name="modificarPNS">Modificar</button>
                    </form>
                </div>
            </div>

        </section>

        <!-- Formulario para modificar las indemnizaciones -->
        <section>
            <div>
                <div>
                    <h1>Modificar Indemnizaciones</h1>
                    <form method="POST">

                        <label for="indIndemnizacion">Indemnizacion</label><br>
                        <input type="number" name="indIndemnizacion" id="indIndemnizacion" value="<?php echo $keyIndemnizacion['indemnizacion']; ?>"><br>

                        <label for="indConcepto">Concepto</label><br>
                        <input type="text" name="indConcepto" id="indConcepto" value="<?php echo $keyIndemnizacion['Concepto']; ?>"><br><br>

                        <button type="submit" name="modificarIndemnizacion">Modificar</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Formulario para modificar los prestamos -->
        <section>
            <div>
                <div>
                    <h1>Modificar Prestamos</h1>
                    <form method="POST">

                        <label for="prestamosFecha">Fecha</label><br>
                        <input type="date" name="prestamosFecha" id="prestamosFecha" value="<?php echo $keyPrestamos['Fecha']; ?>"><br>

                        <label for="prestamosConcepto">Concepto</label><br>
                        <input type="text" name="prestamosConcepto" id="prestamosConcepto" value="<?php echo $keyPrestamos['Concepto']; ?>"><br>

                        <label for="prestamosCantidad">Cantidad</label><br>
                        <input type="number" name="prestamosCantidad" id="prestamosCantidad" value="<?php echo $keyPrestamos['Cantidad']; ?>"><br>

                        <label for="prestamosCobroQuincenal">Cobro Quincenal</label><br>
                        <input type="number" name="prestamosCobroQuincenal" id="prestamosCobroQuincenal" value="<?php echo $keyPrestamos['CobroQuincenal']; ?>"><br><br>

                        <button type="submit" name="modificarPrestamo">Modificar</button>
                    </form>
                </div>
            </div>
        </section>
        <!-- Formulario para modificar los dias -->

        <section>
            <div>
                <div>
                    <h1>Modificar Dias</h1>
                    <tr>
                        <td>ID</td>
                        <td>Fecha</td>
                        <td>Hora entrada</td>
                        <td>Hora salida</td>
                        <td>Actualizar</td>
                    </tr>

                    <?php
                    foreach ($r_dias as $keyDias) {

                        $idDia = $keyDias['idDia'];
                        $fecha = $keyDias['Fecha'];
                        $H_Entrada = $keyDias['H_Entrada'];
                        $H_Salida = $keyDias['H_Salida'];

                    ?>
                        <form method="POST">

                            <tr>
                                <td><input type="text" name="dia" id="dia" value="<?php echo $idDia; ?>" readonly></td>
                                <td><input type="text" name="fecha" id="fecha" value="<?php echo $fecha; ?>" readonly></td>
                                <td><input type="text" name="entrada" id="entrada" value="<?php echo $H_Entrada; ?>"></td>
                                <td><input type="text" name="salida" id="salida" value="<?php echo $H_Salida; ?>"></td>
                                <td><button type="submit" name="modificarDia">Modificar</button></td>
                            </tr>
                        </form>
                    <?php } ?>

                </div>
            </div>
    </div>
    <!-- Script para evitar reenvio de formulario -->
    <script src="./scripts/evitarReenvio.js"></script>
</body>

</html>