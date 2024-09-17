<section class="space"></section>
<form id="crud-product" novalidate>
    <div class="image-product">
        <div class="input-file image-content">
            <img <?= !empty($rowImg) ? 'src="public/uploads/producto/' . end($rowImg) . '"' : 'class="no-src"' ?> onerror="this.onerror=null; this.src='public/images/fondos/noImage.png'">
            <div class="info-img">
                <h5 class="title-img tt-3"><?= !empty($rowImg) ? 'Imágenes añadidas (' . $countImg . ')' : 'Sin imágenes' ?></h5>
                <p class="text-img"><?= !empty($rowImg) ? end($rowImg) : '...' ?></p>
            </div>
            <input type="file" accept="image/*" title="" multiple>
        </div>
        <div class="sub-images">
            <div class="images-content">
                <?php
                if (!empty($rowImg)) {
                    foreach ($rowImg as $img) {
                ?>
                        <div class="image">
                            <img src="public/uploads/producto/<?= $img ?>" onerror="this.onerror=null; this.src='public/images/fondos/noImage.png'">
                            <div class="remove">
                                <i class="fa-solid fa-x"></i>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="images-info">
                <p class="cantidad"><?= !empty($rowImg) ? $countImg : '0' ?> imágenes de 5</p>
            </div>
        </div>
    </div>
    <div class="info-product">
        <h5 class="tt-3"><?= !empty($rowPrd) ? 'Modificar producto' : 'Agregar producto' ?></h5>
        <div class="alert danger"></div>
        <div class="cont">
            <label class="title" for="nom_prd">Nombre *</label>
            <input type="text" name="nom_prd" id="nom_prd" maxlength="200" placeholder="Nombre del producto" <?= !empty($rowPrd) ? 'value="' . $rowPrd['nom_prd'] . '"' : '' ?> required>
        </div>
        <br>
        <div class="cont">
            <label class="title" for="des_prd">Descripción</label>
            <textarea name="des_prd" id="des_prd" maxlength="500" placeholder="Descripción del producto"><?= !empty($rowPrd) ? $rowPrd['des_prd'] : '' ?></textarea>
        </div>
            <br>
            <div class="cont">
                <label class="title" for="fk_ctg_prd">Sección</label>
        <?php
        if ($countCtg > 0) {
        ?>
                <select name="fk_ctg_prd" id="fk_ctg_prd">
                    <option style="color: gray" value="1" <?= (!empty($rowPrd) && $rowPrd['fk_ctg_prd'] == 1) ? 'selected' : '' ?>>Sin especificar</option>
                    <?php
                    foreach ($listCtg as $rowCtg) {
                        if (!empty($rowPrd)) {
                            echo '<option value="' . $rowCtg['pk_id_ctg'] . '" ' . (($rowPrd['fk_ctg_prd'] == $rowCtg['pk_id_ctg']) ? 'selected' : '') . '>' . $rowCtg['nom_ctg'] . '</option>';
                        } else {
                            if ($_GET['ctg']) {
                                echo '<option value="' . $rowCtg['pk_id_ctg'] . '" ' . (($_GET['ctg'] == $rowCtg['pk_id_ctg']) ? 'selected' : '') . '>' . $rowCtg['nom_ctg'] . '</option>';
                            } else {
                                echo '<option value="' . $rowCtg['pk_id_ctg'] . '">' . $rowCtg['nom_ctg'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
        <?php
        } else {
            echo '<br><h5 style="color: red;">Para poder añadir un producto, debes agregar al menos una categoria</h5>';
        }
        ?>
            </div>
        <br>
        <div class="cont">
            <label class="title" for="fk_etd_prd">Estado</label>
            <select name="fk_etd_prd" id="fk_etd_prd">
                <?php
                if (!empty($rowPrd)) {
                    echo '<option value="1" ' . ($rowPrd['fk_etd_prd'] == 1 ? 'selected' : '') . '>Activo</option>';
                    echo '<option value="2" ' . ($rowPrd['fk_etd_prd'] == 2 ? 'selected' : '') . '>Inactivo</option>';
                } else {
                    echo '<option value="1" selected>Activo</option>';
                    echo '<option value="2">Inactivo</option>';
                }
                ?>
            </select>
        </div>
        <p>Si está activo se mostrará en la página, de lo contrario será visible solo para los administradores.</p>
        <br>
        <div class="cont">
            <?php
            if (!empty($rowPrd)) {
                $img_prd = $rowPrd['img_prd'];

                echo "<input type='hidden' name='save_img' value='" . $img_prd . "' readonly>";

                echo '<input type="hidden" name="pk_id_prd" value="' . $rowPrd['pk_id_prd'] . '" readonly>
                <button name="btn-prd-mod" class="mod-prd green">Modificar Producto</button>
                <button type="button" class="del-prd red" data-ajax="?ajax=producto&&func=eliminar" data-redirect=".confirmar">Mover a la Papelera</button>';
            } else {
                if ($countCtg > 0) {
                    echo '<button name="btn-prd-add" class="add-prd blue">Agregar Producto</button>';
                } else {
                    echo '<button type="button" class="add-prd blue" disabled>Agregar Producto</button>';
                }
            }
            ?>
        </div>
        <div class="confirmar"></div>
    </div>
</form>
<section class="space"></section>