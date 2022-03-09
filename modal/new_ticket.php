<?php
$projects = mysqli_query($con, "SELECT * FROM project");
$priorities = mysqli_query($con, "SELECT * FROM priority");
$statuses = mysqli_query($con, "SELECT * FROM status");
$kinds = mysqli_query($con, "SELECT * FROM kind");
$categories = mysqli_query($con, "SELECT * FROM category");
?>

<div class="modal fade bs-example-modal-lg-add text-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Agregar Ticket</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal form-label-center input_mask" method="post" id="add" name="add" enctype="multipart/form-data">
                    <div style="display: flex; justify-content: space-between;">
                        <div style="width: 50%;">
                            <div id="result"></div>

                            <div class="form-group">
                                <select class="form-control" name="kind_id">
                                    <option selected="" value="">Seleccione Tipo</option>
                                    <?php foreach ($kinds as $p) : ?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" name="title" class="form-control" placeholder="Título">
                            </div>

                            <div class="form-group">
                                <textarea name="description" class="form-control col-md-7 col-xs-12" placeholder="Descripción"></textarea>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="project_id">
                                    <option selected="" value="">Seleccione Proyecto</option>
                                    <?php foreach ($projects as $p) : ?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="category_id">
                                    <option selected="" value="">Seleccione Categoría</option>
                                    <?php foreach ($categories as $p) : ?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="priority_id">
                                    <option selected="" value="">Seleccione Prioridad</option>
                                    <?php foreach ($priorities as $p) : ?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="status_id">
                                    <option selected="" value="">Seleccione Estado</option>
                                    <?php foreach ($statuses as $p) : ?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div id="respuesta"></div>
                        </div>

                        <div style="width: 40%; display: flex; flex-direction: column; align-content: center; justify-content: center; align-items: center;">
                            <span>Puede subir uno o más archivos</span>
                            <span class="btn btn-my-button btn-file">
                                Subir
                                <input type="file" name="files" multiple="multiple">
                            </span>

                            <div id="container-success" class='alert alert-success' role='alert' hidden>
                                <p id="result-file-success"></p>
                            </div>

                            <div id="container-error" class='alert alert-error' role='alert' hidden>
                                <p id="result-file-error"></p>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <button id="save_data" type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>

            <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div> -->

        </div>
    </div>
</div> <!-- /Modal -->