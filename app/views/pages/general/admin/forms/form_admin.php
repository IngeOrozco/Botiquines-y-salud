<section class="space"></section>
<h5 class="title-space tt-6">Agregar administradores</h5>
<main id="form-admin">
    <form class="ajax-form" action="?ajax=administrador&&func=crud" data-redirect=".alert" method="POST" novalidate>
        <div class="image-content">
            <img src="public/images/fondos/usuario.png">
        </div>
        <div class="info">
            <div class="alert danger"></div>
            <div class="col">
                <label class="title" for="nom_adm">Nombre/s *</label>
                <input type="text" id="nom_adm" name="nom_adm" placeholder="Escribe tu nombre" <?= !empty($rowAdm) ? 'value="' . $rowAdm['nom_adm'] . '"' : '' ?> required>
            </div>
            <br>
            <div class="col">
                <label class="title" for="ape_adm">Apellido/s *</label>
                <input type="text" id="ape_adm" name="ape_adm" placeholder="Escribe tu apellido" <?= !empty($rowAdm) ? 'value="' . $rowAdm['ape_adm'] . '"' : '' ?> required>
            </div>
            <br>
            <div class="col">
                <label class="title" for="usu_adm">Usuario *</label>
                <input type="text" id="usu_adm" name="usu_adm" placeholder="@Usuario123" <?= !empty($rowAdm) ? 'value="' . $rowAdm['usu_adm'] . '"' : '' ?> required>
            </div>
            <br>
            <div class="col">
                <label class="title" for="ema_adm">Correo *</label>
                <input type="email" id="ema_adm" name="ema_adm" placeholder="usuario@gmail.com" <?= !empty($rowAdm) ? 'value="' . $rowAdm['ema_adm'] . '"' : '' ?> required>
            </div>
            <br>
            <div class="col">
            <?php
                if (empty($countAdm) || $countAdm == 0) {
                    echo '<label class="title" for="pass_adm">Contraseña *</label>
                            <input type="password" id="pass_adm" name="pass_adm" placeholder="* * * * * * * *" required>
                        </div>
                        <br>
                        <div class="col">
                            <label class="title" for="pass_vrf">Confirmar contraseña *</label>
                            <input type="password" id="pass_vrf" name="pass_vrf" placeholder="* * * * * * * *" required>';
                } else {
                    echo '<label class="title" for="fk_etd_adm">Estado *</label>
                            <select name="fk_etd_adm" id="fk_etd_adm">
                                <option value="1" ' . ($rowAdm['fk_etd_adm'] == 1 ? 'selected' : '') . '>Activo</option>
                                <option value="2" ' . ($rowAdm['fk_etd_adm'] == 2 ? 'selected' : '') . '>Inactivo</option>
                            </select>';
                }
                ?>
            </div>
            <p class="info-text">Si está activo funcionará normal, de lo contrario no será autorizado a ingresar al aplicativo.</p>
            <br>
            <div class="buttons">
                <?php
                if (!empty($countAdm) && $countAdm > 0) {
                    echo '<input type="hidden" name="pk_id_adm" value="' . $rowAdm['pk_id_adm'] . '" readonly>
                            <button name="btn-adm-mod" class="green">Modificar</button>
                            <button type="button" class="red" data-ajax="?ajax=administrador&&func=eliminar" data-redirect=".confirmar">Mover a la papelera</button>';
                } else {
                    echo '<button name="btn-adm-add" class="blue">Agregar</button>';
                }
                ?>
            </div>
            <div class="confirmar"></div>
        </div>
    </form>
</main>
<section class="space"></section>