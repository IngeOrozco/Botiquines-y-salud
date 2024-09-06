<section class="space"></section>
<form id="crud-category" novalidate>
    <div class="image-category">
        <img <?= !empty($rowCtg['img_ctg']) ? 'src="public/uploads/categoria/' . $rowCtg['img_ctg'] . '"' : 'class="no-src"' ?> onerror="this.onerror=null; this.src='public/images/fondos/noImage.png'">
        <div class="info-img">
            <h5 class="title-img tt-3"><?= !empty($rowCtg['img_ctg']) ? 'Imagen añadida' : 'Sin imagen' ?></h5>
            <p class="text-img"><?= !empty($rowCtg['img_ctg']) ? $rowCtg['img_ctg'] : '...' ?></p>
        </div>
        <div class="remove-img">
            <h5>Remover imagen</h5>
        </div>
        <input type="file" name="img_ctg" accept="image/*" title="">
    </div>
    <div class="info-category">
        <h5 class="tt-3"><?= !empty($rowCtg) ? 'Modificación de categoria' : 'Agregación de categoria' ?></h5>
        <div class="alert danger"></div>
        <div class="cont">
            <label class="title" for="nom_ctg">Nombre *</label>
            <input type="text" name="nom_ctg" id="nom_ctg" maxlength="200" placeholder="Nombre de la categoria" <?= !empty($rowCtg) ? 'value="' . $rowCtg['nom_ctg'] . '"' : '' ?> required>
        </div>
        <?php
        if (!empty($_GET['ctg']) && $_GET['ctg'] == 1) {
            echo '<p>Esta es una categoria "por defecto", la cual si el producto no tiene categoria definida, se dirigirá a está.</p>';
        }
        ?>
        <br>
        <div class="cont">
            <label class="title" for="des_ctg">Descripción</label>
            <textarea name="des_ctg" id="des_ctg" maxlength="500" placeholder="Descripción de la categoria"><?= !empty($rowCtg) ? $rowCtg['des_ctg'] : '' ?></textarea>
        </div>
        <br>
        <div class="cont">
            <label class="title" for="fk_etd_ctg">Estado</label>
            <select name="fk_etd_ctg" id="fk_etd_ctg">
                <?php
                if (!empty($rowCtg)) {
                    echo '<option value="1" ' . ($rowCtg['fk_etd_ctg'] == 1 ? 'selected' : '') . '>Activo</option>';
                    echo '<option value="2" ' . ($rowCtg['fk_etd_ctg'] == 2 ? 'selected' : '') . '>Inactivo</option>';
                } else {
                    echo '<option value="1" selected>Activo</option>';
                    echo '<option value="2">Inactivo</option>';
                }
                ?>
            </select>
        </div>
        <p>Si está activo se mostrará en la página, de lo contrario será visible solo para los administradores en ultimo lugar, priorisando los activos, al igual que los productos pertenecientes al mismo.</p>
        <br>
        <div class="cont">
            <?php
            if (!empty($rowCtg)) {
                echo '<input type="hidden" name="pk_id_ctg" value="' . $rowCtg['pk_id_ctg'] . '" readonly>
                <button  name="btn-ctg-mod" class="mod-ctg green">Modificar Categoria</button>';

                if ($_GET['ctg'] != 1) {
                    echo '<button type="button" class="del-ctg red" data-ajax="?ajax=categoria&&func=eliminar" data-redirect=".confirmar">Mover a la Papelera</button>';
                }
            } else {
                echo '<button type="submit" name="btn-ctg-add" class="add-ctg blue">Agregar Categoria</button>';
            }
            ?>
        </div>
        <div class="confirmar"></div>
    </div>
</form>
<section class="space"></section>