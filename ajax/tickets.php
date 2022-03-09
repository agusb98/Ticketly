<?php

include "../config/config.php"; //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if (isset($_GET['id'])) {
    $id_del = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT * from ticket where id = '" . $id_del . "'");
    $count = mysqli_num_rows($query);

    if ($delete1 = mysqli_query($con, "DELETE FROM ticket WHERE id = '" . $id_del . "'")) {
?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                    &times;
                </span>
            </button>

            <strong>Aviso!</strong>
            Datos eliminados exitosamente.
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                    &times;
                </span>
            </button>
            <strong>Error!</strong>
            Lo siento algo ha salido mal intenta nuevamente.
        </div>
<?php
    } //end else
} //end if
?>

<?php
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('title'); //Columnas de busqueda
    $sTable = "ticket";
    $sWhere = "";

    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }

    $sWhere .= " ORDER BY created_at DESC";
    include 'pagination.php'; //include pagination file

    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = './expences.php';
    //main query to fetch the data

    $sql = "SELECT 
                t.id,
                t.title,
                t.files,
                t.description,
                t.created_at,
                ki.id as kind_id,
                ki.name as kind,
                us.name as user,
                pro.id as project_id,
                pro.name as project,
                ca.id as category_id,
                ca.name as category,
                pri.id as priority_id,
                pri.name as priority,
                st.id as status_id,
                st.name as status
            FROM `ticket` AS t JOIN kind AS ki
            ON t.kind_id = ki.id JOIN user AS us
            ON t.user_id = t.user_id JOIN project AS pro
            ON t.project_id = pro.id JOIN category AS ca
            ON t.category_id = ca.id JOIN priority AS pri
            ON t.priority_id = pri.id JOIN status AS st
            ON t.status_id = st.id 
            GROUP BY t.id
            ORDER BY t.created_at DESC
            LIMIT $offset, $per_page";

    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {
?>
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">Título </th>
                    <th class="column-title">Proyecto </th>
                    <th class="column-title">Prioridad </th>
                    <th class="column-title">Estado </th>
                    <th class="column-title">Usuario </th>
                    <th class="column-title">Archivo/s </th>
                    <th>Fecha</th>
                    <th class="column-title text-center" style="width: 9.5vw;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php

                while ($r = mysqli_fetch_array($query)) {
                ?>
                    <!-- me obtiene los datos, serán usados en la creacion o actualizacion de ticket -->
                    <input type="hidden" value="<?php echo $r['project_id']; ?>" id="project_id<?php echo $r['id']; ?>">
                    <input type="hidden" value="<?php echo $r['title']; ?>" id="title<?php echo $r['id']; ?>">
                    <input type="hidden" value="<?php echo $r['description']; ?>" id="description<?php echo $r['id']; ?>">
                    <input type="hidden" value="<?php echo $r['kind_id']; ?>" id="kind_id<?php echo $r['id']; ?>">
                    <input type="hidden" value="<?php echo $r['priority_id']; ?>" id="priority_id<?php echo $r['id']; ?>">
                    <input type="hidden" value="<?php echo $r['status_id']; ?>" id="status_id<?php echo $r['id']; ?>">
                    <input type="hidden" value="<?php echo $r['kind_id']; ?>" id="kind_id<?php echo $r['id']; ?>">
                    <input type="hidden" value="<?php echo $r['category_id']; ?>" id="category_id<?php echo $r['id']; ?>">

                    <tr class="even pointer">
                        <td><?php echo $r['title']; ?></td>
                        <td><?php echo $r['project']; ?></td>
                        <td><?php echo $r['priority']; ?></td>
                        <td><?php echo $r['status']; ?></td>
                        <td><?php echo $r['user']; ?></td>
                        <td>
                            <!-- https://stackoverflow.com/questions/1125730/split-a-comma-delimited-string-into-an-array -->
                            <?php foreach (explode('|', $r['files']) as $f) { ?>
                                <a href="#" onclick="window.open('https://c.tenor.com/yMO_H3sjur4AAAAC/02-zero-two.gif'); return false">
                                    <?php echo $f; ?>
                                </a>
                            <?php } ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($r['created_at'])); ?></td>
                        <td><span class="pull-right">
                                <a href="#" class='btn btn-warning btn-sm' title='Editar Ticket' onclick="obtener_datos('<?php echo $r['id']; ?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="#" class='btn btn-danger btn-sm' title='Borrar Ticket' onclick="eliminar('<?php echo $r['id']; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
                    </tr>
                <?php
                } //en while
                ?>
                <tr>
                    <td colspan=6>
                        <span class="pull-right">
                            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                        </span>
                    </td>
                </tr>
        </table>
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> No hay datos para mostrar!
        </div>
<?php
    }
}
?>