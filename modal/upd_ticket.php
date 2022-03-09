<?php
$projects = mysqli_query($con, "select * from project");
$priorities = mysqli_query($con, "select * from priority");
$statuses = mysqli_query($con, "select * from status");
$kinds = mysqli_query($con, "select * from kind");
$categories = mysqli_query($con, "select * from category");
?>
<!-- Modal -->
<div class="modal fade bs-example-modal-lg-udp text-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Editar Ticket</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd">
                    <div id="result2"></div>

                    <input type="hidden" name="mod_id" id="mod_id">

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="kind_id" required id="mod_kind_id">
                                <option selected="" value="">Seleccione Tipo</option>
                                <?php foreach ($kinds as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="title" class="form-control" placeholder="Título" id="mod_title" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea name="description" id="mod_description" class="form-control col-md-7 col-xs-12" placeholder="Descripción" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="project_id" required id="mod_project_id">
                                <option selected="" value="">Seleccione Proyecto</option>
                                <?php foreach ($projects as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="category_id" required id="mod_category_id">
                                <option selected="" value="">Seleccione Categoría</option>
                                <?php foreach ($categories as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="priority_id" required id="mod_priority_id">
                                <option selected="" value="">Seleccione Prioridad</option>
                                <?php foreach ($priorities as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="status_id" required id="mod_status_id">
                                <option selected="" value="">Seleccione Estado</option>
                                <?php foreach ($statuses as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <button id="upd_data" type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>

            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div> -->

        </div>
    </div>
</div> <!-- /Modal -->