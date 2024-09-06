<section class="space"></section>
<main id="list-admin" class="content-table">
    <table>
        <thead>
            <tr>
                <th class="max">#</th>
                <th>@Usuario</th>
                <th>Nombre/s</th>
                <th>Apellido/s</th>
                <th>Correo</th>
                <th>Estado</th>
                <th><a class="btn blue" href="?ctrll=administrador&&func=crud">Agregar</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($countAdm > 0) {
                $fila = 1;

                foreach ($listAdm as $rowAdm) {
            ?>
                    <tr>
                        <td class="center"><?= ($fila++) ?></td>
                        <td><?= $rowAdm['usu_adm'] ?></td>
                        <td><?= $rowAdm['nom_adm'] ?></td>
                        <td><?= $rowAdm['ape_adm'] ?></td>
                        <td><?= $rowAdm['ema_adm'] ?></td>
                        <td><?= $rowAdm['fk_etd_adm'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                        <td><a class="btn green" href="?ctrll=administrador&&func=crud&&adm=<?= $rowAdm['pk_id_adm'] ?>">Modificar</a></td>
                    </tr>
            <?php
                }
            } else {
                echo '<tr><td class="notFound" colspan="7"><h5 class="tt-4">Ningun usuario registrado hasta el momento</h5></td></tr>';
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6"></td>
                <td><a class="btn gray" href="?ctrll=administrador&&func=paperBin">Papelera</a></td>
            </tr>
        </tfoot>
    </table>
</main>
<section class="space"></section>