<?php
$enlace = mysqli_connect("newswire.theunderminejournal.com", "", "", "newsstand");

function profession_exp ($prof, $exp)
{
    if($prof=="herbalism")
    {
        return $exp. " Herbs";
    }
    if($prof=="mining")
    {
        return $exp. " Ore";
    }


}

if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$GET_IDIOMA = $_GET["idioma"];


if (!isset($GET_IDIOMA)) {
    $GET_IDIOMA = "eses";
}

if (!isset($_GET["expansion"])) {
    $_GET["expansion"] = "Battle for Azeroth";
}


if (isset($_GET["house"]) && isset($_GET["profession"])) {
    $jsonData = file_get_contents("".$_GET["profession"].".json"); // ARCHIVO CON LOS ICONOS , Nombres e IDs

    $obj = json_decode($jsonData);
    $largoReinos = count($_GET["house"]);


    echo "<h1>Ha Seleccionado $largoReinos reino/s</h1>";


    ?>


    <table class="table table-bordered table-hover" id="tableItems">
        <thead>
        <tr>
            <th colspan="2"></th>
            <?php
            foreach ($_GET["house"] as $idReino) {
                $sql = "SELECT name , slug  , region FROM `tblRealm` WHERE `house` = '" . $idReino . "'";
                $resultadoReino = $enlace->query($sql);

                $sql = "SELECT `when` 
                        FROM `tblItemHistoryDaily` WHERE `house` = '" . $idReino . "'  ORDER BY `when` DESC LIMIT 1";
                $resultado = $enlace->query($sql);
                $filaDataDate = $resultado->fetch_assoc();
                ?>
                <th colspan="3">
                    Realms:
                    <?php
                    while ($filaReino = $resultadoReino->fetch_assoc()) {
                        echo "<br>" . $filaReino["name"];
                        $region = $filaReino["region"];
                        $slug = $filaReino["slug"];
                    }
                    ?>

                    <br>
                    <a target="_blank"
                       href="https://theunderminejournal.com/#<?php echo $region ?>/<?php echo $slug ?>/category/herbalism">link
                        TUJ <i class="fa fa-external-link-alt"></i></a>
                    <br>
                    <small>DATA DATE <?php echo $filaDataDate['when']; ?></small></th>
            <?php } ?>
        </tr>
        <tr>
            <th>ICON</th>
            <th>Name</th>
            <?php
            foreach ($_GET["house"] as $idReino) { ?>
                <th>MIN</th>
                <th>MAX</th>
                <th>AVG</th>
            <?php } ?>
        </tr>

        </thead>
        <tbody>
        <?php


        foreach ($obj->results as $results) {

            foreach ($results->data->items as $items) {
                if ($results->data->name == profession_exp($_GET["profession"],$_GET["expansion"])) {


                    ?>
                    <tr>

                        <td>
                            <img class="icon"
                                 style="background-image: url('https://wow.zamimg.com/images/wow/icons/large/<?php echo $items->icon; ?>.jpg');"/><br>
                            <?php
                            echo $items->id; ?>
                        </td>

                        <td>

                            <?php
                            $name = "name_" . $GET_IDIOMA;
                            echo $items->$name; ?>

                        </td>
                        <?php

                        foreach ($_GET["house"] as $idReino) {
                            $sql = "SELECT `pricemin`,`priceavg`,`pricemax`,`quantitymin`,`quantityavg`,`quantitymax`,`when` 
                                            FROM `tblItemHistoryDaily` WHERE `house` = '" . $idReino . "' AND item = '$items->id' ORDER BY `when` DESC LIMIT 1";
                            $resultado = $enlace->query($sql);
                            $fila = $resultado->fetch_assoc();


                            $min = $fila['pricemin'] / 100;
                            $avg = $fila['priceavg'] / 100;
                            $max = $fila['pricemax'] / 100;


                            ?>
                            <td> <?php echo number_format($min, 2, ".", ""); ?> </td>
                            <td> <?php echo number_format($max, 2, ".", ""); ?> </td>
                            <td> <?php echo number_format($avg, 2, ".", ""); ?> </td>
                        <?php } ?>
                    </tr>

                    <?php
                }

            }
        }

        ?>

        </tbody>
    </table>

    </div>

    <hr>
    <?php


} else {

    echo "<h1>Seleccione Reino/s y  Profesion</h1>";
}


mysqli_close($enlace);
//print_r($jsonData);
?>

<script>

    var items = 0;

    $('#tableItems tbody tr').each(function () {
        var tabla = $(this);
        var data = [];

        <?php
        for($i = 1;$i <= $largoReinos;$i++){ ?>
        data.push(tabla.find('td:eq(<?php echo (3 * $i) + 1 ?>)').text());
        <?php
        } ?>

        var min = Math.min.apply(Math, data).toFixed(2);
        var max = Math.max.apply(Math, data).toFixed(2);

        $('#tableItems tbody tr:eq(' + items + ')').find(':contains(' + max + ')').css('background-color', '#99ffbb');
        $('#tableItems tbody tr:eq(' + items + ')').find(':contains(' + max + ')').css('font-size', 'x-large');

        $('#tableItems tbody tr:eq(' + items + ')').find(':contains(' + min + ')').css('background-color', '#ff9999');
        $('#tableItems tbody tr:eq(' + items + ')').find(':contains(' + min + ')').css('font-size', 'x-large');


        //console.log(data);
        //console.log("MIN " + min);
        //console.log("MAX " + max);
        items++;
    });
</script>
