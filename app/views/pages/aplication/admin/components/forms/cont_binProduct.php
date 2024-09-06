<h5 class="tt-8">Papelera de productos</h5>
<br>
<?php
if ($countPrd > 0) {
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
                    <th>Descripción</th>
                    <th>Imágenes</th>
                    <th>Fch. Creación</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fila = 1;

                foreach ($funcPrd as $rowPrd) {
                    echo '<tr>
                    <td>
                        <div class="checkbox">
                            <input type="checkbox" name="bin[' . $rowPrd['pk_id_prd'] . ']"></td>
                        </div>
                    <td>' . $fila++ . '</td>
                    <td>' . $rowPrd['nom_prd'] . '</td>
                    <td>' . $rowPrd['des_prd'] . '</td>
                    <td>';

                    if (!empty($rowPrd['img_prd'])) {
                        $json_img_prd = json_decode($rowPrd['img_prd']);
                        $img_prd = $json_img_prd[0];
                        $countImg = count($json_img_prd) > 1 ? ' + ' . count($json_img_prd) - 1 : '';

                        echo '<a class="link" href="public/uploads/productod/' . $img_prd . '" target="_blank"><i class="fa-solid fa-image"></i> ' . $img_prd . $countImg . '</a>';
                    }

                    echo '</td>
                    <td class="center">' . $rowPrd['dCrt_prd'] . '</td>
                    <td>' . $rowPrd['nom_ctg'] . '</td>
                <tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="buttons">
                            <button type="button" class="blue" data-ajax="?ajax=producto&&func=eliminar" data-redirect=".confirmar" data-box="{'btn-prd-rts': ''}" disabled>Restaurar</button>
                            <button type="button" class="red" data-ajax="?ajax=producto&&func=eliminar" data-redirect=".confirmar" data-box="{'btn-prd-del': ''}" disabled>Eliminar Permanentemente</button>
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
    echo '<h5 class="notFound tt-5">No se encuentran productos en papelera</h5>';
}
?>