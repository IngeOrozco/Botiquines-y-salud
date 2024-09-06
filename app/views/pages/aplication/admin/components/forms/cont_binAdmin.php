<h5 class="tt-8">Papelera de administradores</h5>
<br>
<?php
if ($countAdm > 0) {
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
                    <th>Apellido</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fila = 1;

                foreach ($funcAdm as $rowAdm) {
                    echo '<tr>
                    <td>
                        <div class="checkbox">
                            <input type="checkbox" name="bin[' . $rowAdm['pk_id_adm'] . ']"></td>
                        </div>
                    <td>' . $fila++ . '</td>
                    <td>' . $rowAdm['nom_adm'] . '</td>
                    <td>' . $rowAdm['ape_adm'] . '</td>
                    <td>' . $rowAdm['usu_adm'] . '</td>
                    <td>' . $rowAdm['ema_adm'] . '</td>
                <tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        <div class="buttons">
                            <button type="button" class="blue" data-ajax="?ajax=administrador&&func=eliminar" data-redirect=".confirmar" data-box="{'btn-adm-rts': ''}" disabled>Restaurar</button>
                            <button type="button" class="red" data-ajax="?ajax=administrador&&func=eliminar" data-redirect=".confirmar" data-box="{'btn-adm-del': ''}" disabled>Eliminar Permanentemente</button>
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
    echo '<h5 class="notFound tt-5">No se encuentran administradores en papelera</h5>';
}
?>