<?php

  function insertar(){
        // -- Insertar presatmo
        $sql="INSERT INTO Prestamo (Fecha,Concepto,Cantidad,CobroQuincenal,FidEmpleado) VALUES
        ('0000-00-00','',0,0,.$id.);";
        $consulta=$conexion->prepare($sql);
        $consulta->execute();

        // -- Insert Indemnizacion
        $sql="INSERT INTO Indemnizaciones (Concepto,Indemnizacion,FidPNS) VALUES
        ('',0,.$id.);";
        $consulta=$conexion->prepare($sql);
        $consulta->execute();


        // -- Insert incentivos
        $sql="INSERT INTO Incentivos (Concepto,Incentivo,FidPS) VALUES
        ('',0,.$id.);";
        $consulta=$conexion->prepare($sql);
        $consulta->execute();


        // -- Insert deducciones
        $sql="INSERT INTO Deducciones (IRPF,IMSS,ISR,FidPS) VALUES
        (6.5,3,3.5,.$id.);";
        $consulta=$conexion->prepare($sql);
        $consulta->execute();}
?>