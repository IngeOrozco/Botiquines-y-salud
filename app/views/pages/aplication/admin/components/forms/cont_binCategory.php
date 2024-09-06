<h5 class="tt-8">Papelera de categorias</h5>
<br>
<?php
if ($countCtg > 0) {
?>
    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>
                        <div class="checkbox all-checks">
                            <input type="checkbox">
                        </div>
                    </th>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Descripción</th>
                    <th>Productos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fila = 1;

                foreach ($funcCtg as $rowCtg) {
                    echo '<tr>
                    <td>
                        <div class="checkbox">
                            <input type="checkbox" name="bin[' . $rowCtg['pk_id_ctg'] . ']"></td>
                        </div>
                    <td>' . $fila++ . '</td>
                    <td>' . $rowCtg['nom_ctg'] . '</td>
                    <td>';

                    if (!empty($rowCtg['img_ctg'])) {
                        echo '<a class="link" href="public/uploads/categoria/' . $rowCtg['img_ctg'] . '" target="_blank"><i class="fa-solid fa-image"></i> ' . $rowCtg['img_ctg'] . '</a>';
                    }

                    echo '</td>
                    <td>' . $rowCtg['des_ctg'] . '</td>
                    <td class="center">' . $rowCtg['count_prd'] . '</td>
                <tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        <div class="buttons">
                            <button type="button" class="blue" data-ajax="?ajax=categoria&&func=eliminar" data-redirect=".confirmar" data-box="{'btn-ctg-rts': ''}" disabled>Restaurar</button>
                            <button type="button" class="red" data-ajax="?ajax=categoria&&func=eliminar" data-redirect=".confirmar" data-box="{'btn-ctg-del': ''}" disabled>Eliminar Permanentemente</button>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="confirmar">
    </div>
<?php
} else {
    echo '<h5 class="notFound tt-5">No se encuentran categorias en papelera</h5>';
}
?>