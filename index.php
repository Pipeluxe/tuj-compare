<?php


$enlace = mysqli_connect("newswire.theunderminejournal.com", "", "", "newsstand");

if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


?>
<!--

 CHUUUUUUUUUUUUU

 Developed by Felipe Villalon
 Exito ! 


 -->
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="plugins/flags/flags.css">
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.1.0/css/rowGroup.bootstrap4.min.css" rel="stylesheet">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css"
          rel="stylesheet"/>
</head>

<style>
    .icon {
        width: 56px;
        height: 56px;
        left: 6px;
        top: 6px;
    }

    tr.group,
    tr.group:hover {
        background-color: #000 !important;
    }

</style>

<div class="">
    <span class="float-right">Developed by Pipeluxe</span>

    <form id="FORM_COMPARE">
        <table>
            <tr>
                <td>
                    <h1>Compare Prices</h1>
                </td>
                <td>
                    <h1>
                    <select name="profession">
                        <option value="">Seleccione...</option>
                        <option value="herbalism">Herbalism</option>
                        <option value="mining">Mining</option>
                        <option value="cooking">Cooking</option>
                    </select>
                    </h1>
                </td>
                <td>
                    <h1>
                    <select name="expansion">
                        <option value="Battle for Azeroth">Battle for Azeroth</option>
                        <option value="Legion">Legion</option>
                        <option value="Warlords of Draenor">Warlords of Draenor</option>
                        <option value="Mists of Pandaria">Mists of Pandaria</option>
                        <option value="Cataclysm">Cataclysm</option>
                        <option value="Wrath of the Lich King">Wrath of the Lich King</option>
                        <option value="Burning Crusade">The Burning Crusade</option>
                        <option value="Classic">Classic</option>
                    </select>
                    </h1>
                </td>
                <td>
                    <h1>
                    <button class="btn btn-block btn-lg btn-primary" id="BTN_START_COMPARE"> COMPARE</button>
                    </h1>
                </td>
            </tr>
            <tr>
                <td >
                    Language of Mats
                    <select name="idioma" class="float-right">
                        <option value="">Seleccione...</option>
                        <option value="eses">Español</option>
                        <option value="enus">Ingles</option>
                        <option value="ptbr">Portuges</option>
                        <option value="dede">Aleman</option>
                        <option value="frf">Frances</option>
                        <option value="kokr">Koreano</option>
                        <option value="ruru">Ruso</option>
                        <option value="zhtw">Chino</option>
                    </select>
                </td>
                <td colspan="3"></td>
            </tr>
        </table>

    </form>
        <hr>


        <!--Accordion wrapper-->
        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

            <!-- Accordion card -->
            <div class="card">

                <!-- Card header -->
                <div class="card-header" role="tab" id="headingOne1">
                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true"
                       aria-controls="collapseOne1">
                        <h5 class="mb-0">
                            <i class="fa fa-globe faa-pulse animated faa-slow"></i> Realms List <i
                                    class="fas fa-angle-down rotate-icon"></i>

                        </h5>
                    </a>
                </div>

                <!-- Card body -->
                <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1"
                     data-parent="#accordionEx">
                    <div class="card-body">
                        <button class="btn btn-sm btn-danger" id="UNCHECK_ALL"> UNCHECK ALL</button>

                        <hr>
                        <table id="tableRealms" class="table table-sm table-dark" style="width:100%">
                            <thead>
                            <th>HOUSE</th>
                            <th>Realm</th>
                            <th>Locate</th>
                            </thead>
                            <tbody>
                            <?php


                            $sql = "SELECT * FROM `tblRealm` WHERE `locale` IN ('pt_BR','en_US','es_MX') AND `region` = 'US'  ORDER BY house,name";
                            $resultado = $enlace->query($sql);

                            while ($fila = $resultado->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>

                                        <b>HOUSE ID: <?php echo $fila['house'] ?> </b>

                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="house custom-control-input" id="customSwitches<?php echo $fila['id'] ?>" name="house[]" value="<?php echo $fila['house'] ?>">
                                            <label class="custom-control-label" for="customSwitches<?php echo $fila['id'] ?>"><?php echo $fila['name'] ?></label>
                                        </div>
                                    </td>
                                    <td><?php echo $fila['locale'] ?></td>

                                </tr>


                                <?php


                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- Accordion card -->


        </div>
        <!-- Accordion wrapper -->

        <div ID="AJAX_RESULTS"></div>


        <script
                src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/rowgroup/1.1.0/js/dataTables.rowGroup.min.js"></script>


        <script>
            $(document).ready(function () {

                var groupColumn = 0;
                var table = $('#tableRealms').DataTable({
                    "stateSave": true,
                    "pagingType": "full_numbers",
                    "columnDefs": [
                        {"visible": false, "targets": groupColumn},
                        {"orderable": false, "targets": [0,1,2]}
                    ],
                    "order": [[groupColumn, 'asc']],
                    "displayLength": 10,
                    "drawCallback": function (settings) {
                        var api = this.api();
                        var rows = api.rows({page: 'current'}).nodes();
                        var last = null;

                        api.column(groupColumn, {page: 'current'}).data().each(function (group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="3">' + group + '</td></tr>'
                                );

                                last = group;
                            }
                        });
                    }
                });

                $(document).on("change","input.house", function () {

                    var element = $(this);
                    table.$("input.house").each(function () {

                        if ($(this).val() == element.val()) {
                            $(this).closest("tr").find("input").prop("checked", false);
                        }

                    });
                    element.prop("checked", true);

                });


                $("#UNCHECK_ALL").on("click", function () {
                    table.$('input').prop( 'checked',false );
                });


                $(document).on("click", "#BTN_START_COMPARE", function (e) {
                    e.preventDefault();

                    var dataFromTable = table.$('input').serialize();
                    var dataFromForm = $("#FORM_COMPARE").serialize();
                    var filterdata =  dataFromTable + '&' + dataFromForm;
                    $("#AJAX_RESULTS").html("<h1><i class='fa fa-sync faa-spin animated'></i> LOADING ... </h1>");
                    $.ajax({
                        url: "ajax.php",
                        type: "GET",
                        data:   filterdata
                    }).done(function (html) {
                        $("#AJAX_RESULTS").html(html);
                    }).fail(function () {
                        $("#AJAX_RESULTS").html("Ocurrio un Error <i class=\"fa fa-exclamation-circle text-red faa-animated faa-flash\"></i>");
                    });

                });




                $('select[name="profession"]').val('<?php echo $_GET["profession"]?>');
                $('select[name="idioma"]').val('<?php echo $_GET["idioma"]?>');


            });
        console.log("YOU SHALL NOT PASS !!!");
        </script>
</html>