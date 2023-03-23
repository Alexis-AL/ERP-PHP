<script>
    function confirmar(){
       const  variable = window.confirm("Esta seguro de borrar la quincena?");
         if(variable == true){
              window.location.href="./borrar_confirmado.php";}
              else{
                  window.location.href="../muestreo.php";
              }
    }
</script>

<?php 
echo "<script>confirmar();</script>";
?>