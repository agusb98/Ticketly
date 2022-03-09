<?php
$kinds = mysqli_query($con, "select * from kind_user");
?>

<div class="modal fade bs-example-modal-lg-upd text-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Editar Usuario</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" id="upd_user" name="upd_user">
                    <div id="result_user2"></div>

                    <input type="hidden" id="mod_id" name="mod_id">

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="mod_name" id="mod_name" type="text" class="form-control" required>
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input name="mod_email" id="mod_email" type="text" class="form-control has-feedback-left" required>
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <select class="form-control" required name="mod_status" id="mod_status">
                            <option value="" selected>Seleccione Estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <select class="form-control" required name="mod_kind" id="mod_kind">
                            <option selected="" value="">Seleccione Tipo de Usuario</option>
                            <?php foreach ($kinds as $p) : ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo $p['kind']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="password" id="password" name="password" placeholder="Contraseña" class="form-control col-md-7 col-xs-12">
                        <p class="text-muted">La contraseña solo se modificara si escribes algo, en caso contrario no se modifica.</p>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <div class="form-group">
                            <button id="upd_data" type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>

                </form>
            </div>

            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div> -->

        </div>
    </div>
</div> <!-- /Modal -->