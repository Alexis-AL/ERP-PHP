<script>
    
    function fin(){
        alert("Se ha borrado la quincena");
        window.location.href="../muestreo.php";
    }

</script>

<?php
    require './config.php';
    require './functions.php';
    $conexion = connect($server,$port,$db,$user,$pass);
    $sql="DELETE FROM dia";
    $borrar=$conexion->prepare($sql);
    $borrar->execute();
    $sql="UPDATE ps  SET HORAS_TOTALES=0,HorasExtras=0";
    $borrar=$conexion->prepare($sql);
    $borrar->execute();
    $sql="SELECT * FROM prestamo";
    $borrar=$conexion->prepare($sql);
    $borrar->execute();
    $r_borrar=$borrar->fetchAll();
    foreach ($r_borrar as $key) :
        $cantidad=$key['Cantidad'];
        $pago=$key['CobroQuincenal'];
        $total=$cantidad-$pago;
        if($cantidad<=0){
        $sql="UPDATE prestamo SET Cantidad=0,CobroQuincenal=0 WHERE idPrestamo=".$key['idPrestamo'].";";

        }else{
        $sql="UPDATE prestamo SET Cantidad=".$total." WHERE idPrestamo=".$key['idPrestamo'].";";
        $borrar=$conexion->prepare($sql);
        $borrar->execute();
        }
        
    endforeach;
    echo "<script>fin(); </script>";
   

?>