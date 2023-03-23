-- Insertar usuarios

INSERT INTO Empleados (nombre,Apellido,telefono,curp,Direccion,Puesto,jornada, FechaDeIngreso,nss,pw) VALUES 
('Diego','Barba','3787863610','BARD010226HJCRMGA3','Calle falsa 123','Administrador','Diurno','2019-01-01','123456789','1234'),
('Checo','Perez','3782044740','ChecoPerez123','Calle Real 123','Empleado','Diurno','2019-01-01','123456789','1234');


-- insertar horas
-- insertar horas
INSERT INTO dia (Fecha,H_Entrada,H_Salida,FidEmpleados,Rentrada,Rsalida) VALUES
("2022-5-2","08:12:15","20:03:54",2,1,1),
("2022-5-3","08:10:34","20:04:21",2,1,1),
("2022-5-4","08:04:20","20:02:03",2,1,1),
("2022-5-5","08:01:46","20:02:44",2,1,1),
("2022-5-6","08:03:57","20:03:12",2,1,1),
("2022-5-7","08:22:13","20:02:23",2,1,1),
("2022-5-8","08:18:45","20:02:34",2,1,1),
("2022-5-9","08:05:33","20:03:54",2,1,1),
("2022-5-10","08:20:20","20:03:27",2,1,1),
("2022-5-11","08:04:56","20:01:33",2,1,1),
("2022-5-12","08:19:02","20:01:10",2,1,1);
-- insert PS
INSERT INTO PS (Sueldo_Base,Vales_Despensa,FidEmpleados) VALUES
(120,223,2);

-- Insert PSN 
INSERT INTO PNS (Vacaciones,Transporte,GastosMaterial,Complementos,C_Transporte,C_Gasto,C_Complemento,FidEmpleados) VALUES
(10,200,300,400,'Transporte De ranfla','Gastos en el mamalon','Complemento para las papas',2);

-- Insertar presatmo
INSERT INTO Prestamo (Fecha,Concepto,Cantidad,CobroQuincenal,FidEmpleados) VALUES
("2022-4-7","Quiero sacar una moto en elektra",1200,250,2);

-- Insert Indemnizacion
INSERT INTO Indemnizaciones (Concepto,Indemnizacion,FidPNS) VALUES
("Se frego la cadera",320,1);

-- Insert incentivos
INSERT INTO Incentivos (Concepto,Incentivo,FidPS) VALUES
("Se le pago al empleado por el almuerzo",150,1);

-- Insert deducciones
INSERT INTO Deducciones (IRPF,IMSS,ISR,FidPS) VALUES
(6.5,3,3.5,1);