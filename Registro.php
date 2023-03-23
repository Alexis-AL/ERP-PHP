<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="preload" href="./styles/formulario.css" as="style">
    <link rel="stylesheet" href="./styles/registro.css">
    <link
    href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet"/>
    
</head>

<body>
    

    <section>
        <div class="h2for">
        <h2 >Registro <a href="./muestreo.php">CAMM</a></h2>
       
        </div>
        

        <form class="formulario" action="./config/Registro.php" method="post">
            <fieldset>
                <legend>Registrese</legend>
                <div class="contenedor-campos">

                    <div class="campo">
                        <label>Nombre</label>
                            <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><span class="material-icons">
person
</span>
</span>
                            <input type="text" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping" placeholder="Tu nombre" required id="name" name="name">
                            </div>
                        
                    </div>

                    <div class="campo">
                        <label>Apellido</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><span class="material-icons">
drive_file_rename_outline
</span></span>
                            <input type="text" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping" placeholder="Tu apellido" required id="lastname" name="lastname">
                            </div>
                      
                    </div>

                    <div class="campo">
                        <label>Teléfono</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><span class="material-icons">
call
</span></span>
                            <input type="text" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping" placeholder="Tu teléfono" required id="tel" name="tel">
                            </div>
                      
                    </div>

                    <div class="campo">
                        <label>CURP</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><span class="material-icons">
badge
</span></span>
                            <input type="text" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping" placeholder="Tu CURP" required id="curp" name="curp">
                            </div>
                     
                    </div>

                    <div class="campo">
                        <label>Dirección</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><span class="material-icons">
place
</span></span>
                            <input type="text" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping" placeholder="Tu dirección" required id="address" name="address">
                            </div>
                   
                    </div>
                    <div class="campo">
                        <label>Fecha de ingreso</label>
                        <input type="date" name="fecha"></input>
                    </div>

                    <div class="campo">
                        <label class="campo1" id="pais">Puesto de trabajo</label><br>
                        <select name="puesto" id="puesto" >
                        <option disabled selected value=""> --- SELECCIONA ---</option>
                            <option value="Administrador" id="AD">Administrador</option>
                            <option value="Gerente" id="GE">Gerente</option>
                            <option value="Soldador" id="US">Usuario</option>
                        </select><br>
                    </div>

                    <div class="campo">
                        <label class="campo1" id="jornada">Jornada laboral</label><br>
                        <select name="jornada" id="jornada" >
                        <option disabled selected value=""> --- SELECCIONA ---</option>
                            <option value="Jornada Completa" id="JC">Media Jornada Jornada</option>
                            <option value="Media Jornada" id="MJ">Jornada Completa</option>
                        </select><br>
                    </div>

                    <div class="campo">
                        <label>Número de Seguro Social</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><span class="material-icons">
123
</span></span>
                            <input type="text" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping" placeholder="Tu NSS" id="NSS" name="NSS">
                            </div>
                  
                    </div>


                    <div class="campo">
                        <label>Contraseña</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><span class="material-icons">
lock
</span></span>
                            <input type="password" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping" placeholder="Tu contraseña" id="pw" name="pw">
                            </div>
                    </div>

                    <div class="campo">
                        <label>Repite tu Contraseña</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><span class="material-icons">
password
</span></span>
                            <input type="password" class="form-control"  aria-label="Username" aria-describedby="addon-wrapping" placeholder="Repite tu Contraseña" id="rpw" name="rpw">
                            </div>
                    </div>

                </div>    <!-- contenedor de los campos -->  
                

                    <div class="alinear">
                        <input class="boton" type="submit" value="Enviar">
                    </div>
                

            </fieldset>
        </form>
    </section>



    <footer class="footer">
        <div>
            <p>Todos los derechos reservados. 2022</p>
        </div>
    </footer>

    </div>
    <!-- Script para evitar reenvio de formulario -->
    <script src="./scripts/evitarReenvio.js"></script>
</body>

</html>