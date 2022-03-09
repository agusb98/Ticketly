<?php
$title = "Tickets | ";
include "head.php";
include "sidebar.php";
?>

<div class="right_col" role="main">
    <!-- page content -->
    <div class="">
        <div class="page-title">
            <div class="clearfix"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
                include("modal/new_ticket.php");
                include("modal/upd_ticket.php");
                ?>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tareas</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-add">
                            <i class="fa fa-plus-circle"> Agregar</i>
                        </button>

                        <div class="">
                            <!-- form seach -->
                            <form role="form" id="gastos">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="q" placeholder="Nombre.." onkeyup='load(1);'>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-default" onclick='load(1);'>
                                            <span class="glyphicon glyphicon-search"></span> Buscar</button>
                                        <span id="loader"></span>
                                    </div>
                                </div>
                            </form>
                            <!-- end form seach -->
                        </div>
                    </div>

                    <div class="x_content">
                        <div class="table-responsive">
                            <!-- ajax -->
                            <div id="resultados"></div><!-- Carga los datos ajax -->
                            <div class='outer_div'></div><!-- Carga los datos ajax -->
                            <!-- /ajax -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /page content -->

<?php include "footer.php" ?>

<script type="text/javascript" src="js/ticket.js"></script>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script>
    // global variable
    var files_to_save = "";

    $("#add").submit(function(event) {
        $('#save_data').attr("disabled", true);
        var parametros = $(this).serialize();
        parametros += "&files=" + files_to_save;

        $.ajax({
            type: "POST",
            url: "action/addticket.php",
            data: parametros,
            beforeSend: function(objeto) {
                $("#result").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                $("#result").html(datos);
                $('#save_data').attr("disabled", false);
                load(1);
            }
        });

        event.preventDefault();
    })


    $("#upd").submit(function(event) {
        $('#upd_data').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/updticket.php",
            data: parametros,
            beforeSend: function(objeto) {
                $("#result2").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                $("#result2").html(datos);
                $('#upd_data').attr("disabled", false);
                load(1);
            }
        });
        event.preventDefault();
    })

    function obtener_datos(id) {
        var description = $("#description" + id).val();
        var title = $("#title" + id).val();
        var kind_id = $("#kind_id" + id).val();
        var project_id = $("#project_id" + id).val();
        var category_id = $("#category_id" + id).val();
        var priority_id = $("#priority_id" + id).val();
        var status_id = $("#status_id" + id).val();

        $("#mod_id").val(id);
        $("#mod_title").val(title);
        $("#mod_description").val(description);
        $("#mod_kind_id").val(kind_id);
        $("#mod_project_id").val(project_id);
        $("#mod_category_id").val(category_id);
        $("#mod_priority_id").val(priority_id);
        $("#mod_status_id").val(status_id);
    }

    $(function() {
        $("input[name='files']").on("change", function(e) {
            e.preventDefault();

            var formData = new FormData($("#add")[0]);
            var ruta = "action/check-file.php";

            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function(data) {
                    data = JSON.parse(data);

                    if (data["status"]) {
                        if (files_to_save) {
                            files_to_save += "|" + data["message"];
                        } else {
                            files_to_save = data["message"];
                        }

                        $("#container-success").show();
                        $("#result-file-success").html("<p>" + data["message"] + "</p>");
                    } else {
                        $("#container-error").show();
                        $("#result-file-error").html("<p>" + data["message"] + "</p>");
                    }
                }
            });
        });
    });
</script>