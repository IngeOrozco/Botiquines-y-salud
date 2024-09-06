<section class="space"></section>
<main id="search">
    <div class="buscador">
        <label for="input-search">Buscar</label>
        <input type="text" name="input-search" id="input-search" data-url="?ajax=producto&&func=buscar&&ctg=<?= $_GET['ctg'] ?>">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>
    <?php
    if (!empty($_SESSION['num_doc'])) {
        echo '<div class="settings">
                    <a class="title" href="?ctrll=categoria&&func=crud&&ctg=' . $_GET['ctg'] . '"><i class="fa-solid fa-gear"></i>Configuración</a>
                    <a class="title" href="?ctrll=producto&&func=crud&&ctg=' . $_GET['ctg'] . '"><i class="fa-solid fa-plus"></i>Agregar producto</a>
                </div>';
    }
    ?>
</main>
<main id="product-list">
    <?php
    if ($countPrd > 0) {
        foreach ($listPrd as $rowPrd) {
            echo '<div class="product' . ($rowPrd['fk_etd_prd'] != 1 ? ' disabled' : '') . '"><div class="line"></div>';

            if (!empty($rowPrd['img_prd'])) {
                $imgPrd = json_decode($rowPrd['img_prd']);
                $countImg = count($imgPrd);

    ?>
                <div class="images">
                    <a class="content-img" target="_blank" href="public/uploads/producto/<?= $imgPrd[0] ?>">
                        <img src="public/uploads/producto/<?= $imgPrd[0] ?>" onerror="this.onerror=null; this.src='public/images/fondos/noImage.png'">
                    </a>
                    <div class="sub-images">
                        <?php
                        if ($countImg > 1) {
                            foreach ($imgPrd as $img) {
                        ?>
                                <div class="image">
                                    <img src="public/uploads/producto/<?= $img ?>" onerror="this.onerror=null; this.src='public/images/fondos/noImage.png'">
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="info">
                <div class="info-header">
                    <h5 class="tt-3 title-search"><?= $rowPrd['nom_prd'] ?></h5>
                    <p><?= $rowPrd['des_prd'] ?? '<i>Sin descripción</i>' ?></p>
                </div>
                <div class="info-footer">
                    <?php
                    if (!empty($_SESSION['num_doc'])) {
                        echo '<a class="btn blue" href="?ctrll=producto&&func=crud&&prd=' . $rowPrd['pk_id_prd'] . '">Ajustes</a>';
                    }
                    ?>
                    <a class="btn green" href="https://wa.me/573133299195" target="_blank"><i class="fa-brands fa-whatsapp"></i> Whatsapp</a>
                </div>
                <div class="date">
                    <h5>Fecha de creación: <?= $rowPrd['dCrt_prd'] ?></h5>
                    <?= $rowPrd['fk_etd_prd'] != 1 ? '<h5 class="inactivo">Estado: inactivo</h5>' : '' ?>
                </div>
            </div>
            </div>
        <?php
        }
        ?>
        <div class="notFound">
            <h5 class="tt-6">No se encuentra el producto</h5>
        </div>
    <?php
    } else {
        echo '<div class="notFound visible">
            <h5 class="tt-6">No se encuentran productos existentes en esta categoria</h5>
        </div>';
    }
    ?>
</main>
<section class="space"></section>