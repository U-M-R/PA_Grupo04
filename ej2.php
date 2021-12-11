<?php
function mostrarTabla($importe,$nmeses){
    $acum=0;
    $restante=$importe;
    $aportacion=$importe/$nmeses;
    $array = array();
    for($i=0;$i<$nmeses;$i++){
        if($i==0){
        $fecha=ucfirst(strftime("%B %Y")).' (actual)';

        }else{
        $fecha=ucfirst(strftime("%B %Y",strtotime(date("d-m-Y")."+ ".$i." month")));
        }

        $acum+=$aportacion;
        $restante-=$aportacion;
        $array[]=array($fecha,$aportacion,$acum,$restante);

     }
     return $array;
}


?>
    <html>
<head>

</head>
<body>
    <?php 
        if(!isset($_POST["submit"])){


    ?>
    <form name="form" method="POST">
        <label for="nombre">Nombre: </label>
        <input type="text" id="nombre" name="nombre"/> <br>
        <label for="dni">DNI: </label>

        <input type="text" id="dni" name="dni"/><br>

        <label for="deudat">Deuda total: </label>
        <input type="text" id="deudat" name="deudat"/><br>

        <label for="nmeses">Numero de meses: </label>
        <input type="text" id="nmeses" name="nmeses"/><br>
        <label for="anotaciones">Anotaciones o Comentarios</label>
        <input type="textarea" id="anotaciones" name="anotaciones"/>

        <br/><br/>

        <input type="radio" id="radio" value="retraso" name="retraso"/>Aplicar retraso en el pago<br>
        <input type="radio" id="radio" value="amortizacion" name="amortizacion"/>Aplicar amortización<br>
        <input type="radio" id="radio" value="nada" name="nada"/>No hacer nada<br>

        <input type="submit" id="submit" name="submit" value="submit"/>
    </form>
    <?php
     }else{ 
        if(preg_match("#d+(?:.d{1,2})?#",$_POST['deudat'])!=false){
            echo "ERROR en el valor";   
        }

        if(preg_match("/^[a-zA-Z'-]+$/",$_POST['nombre'])!=true){
            echo "ERROR en el nombre";
        }

        if($_POST['nmeses']<0){
            echo "ERROR en el nmeses";
        }
        if(preg_match('/^[0-9]{8}[A-Z]{1}$/', $_POST['dni'])!=true){
            echo "ERROR en el dni";
        }




        $dni=$_POST['dni'];
        $nombre=$_POST['nombre'];
        $importe=$_POST['deudat'];
        $nmeses=$_POST['nmeses'];
        $anotaciones=$_POST['anotaciones'];
        $array = mostrarTabla($importe,$nmeses);
    ?>
    <table border=2 width="50%">
    <tr>
        <td colspan="2">Presupuesto para: <?php echo $nombre ?></td>
        <td colspan="2">DNI: <?php echo $dni ?></td>
    </tr>
    <tr>
        <td>Importe total de la deuda</td>
        <td><?php echo $importe ?></td>
        <td>Total de meses</td>
        <td><?php echo $nmeses ?></td>
    </tr>
    <tr>
        <td>Anotaciones</td>
        <td colspan="3"><?php echo $anotaciones ?></td>
    </tr>
    <tr>
        <td>Otros escenarios</td>
        <td colspan="3">
            <p><?php if(isset($_POST['nada'])){echo 'X';}else{echo 'o';}?>  No hacer nada</p>
            <p><?php if(isset($_POST['retraso'])){echo 'X';}else{echo 'o';}?> Aplicar retraso en el pago</p>
            <p><?php if(isset($_POST['amortizacion'])){echo 'X';}else{echo 'o';}?> Aplicar amortización</p>
        </td>
    </tr>
    
    <tr>
            <td>Fecha </td>
            <td>Aportación</td>
            <td>Importe pagado</td>
            <td>Importe restante</td>
    </tr>
    <?php for($i=0;$i<$nmeses;$i++){?>
    <tr> 
        <?php for($j=0;$j<count($array[$i]);$j++){?>
        <td><?php echo $array[$i][$j] ?></td>
        <?php } ?>
    </tr>
    <?php } ?>
</table>
    <?php
        }
    ?>

   
   
<?php 
?>

</body>

</html>
