<?php
if (!empty($_SESSION['num_doc'])) {
?>
    <section class="space"></section>
    <main id="menu-category">
        <div class="info">
            <h5 class="tt-3">Configuraciones</h5>
        </div>
        <div class="buttons">
            <a class="btn blue" href="?ctrll=categoria&&func=crud">Agregar categoria</a>
            <a class="btn blue" href="?ctrll=producto&&func=crud">Agregar producto</a>
        </div>
    </main>
<?php
}
?>
<section class="space"></section>
<h5 class="tt-4 title-space">Categorias</h5>
<main id="category">
    <?php
    if ($countCtg > 0) {
        foreach ($listCtg as $rowCtg) {
    ?>
            <a class="category<?= ($rowCtg['fk_etd_ctg'] != 1 ? ' disabled' : '') ?>" href="?ctrll=producto&&func=view&&ctg=<?= $rowCtg['pk_id_ctg'] ?>">
                <div class="image">
                    <img src="public/uploads/categoria/<?= $rowCtg['img_ctg'] ?>" onerror="this.onerror=null; this.src='public/images/fondos/noImage.png'">
                </div>
                <div class="info">
                    <h5 class="tt-2 center"><?= $rowCtg['nom_ctg'] ?></h5>
                    <p><?= $rowCtg['des_ctg'] ?></p>
                </div>
            </a>
    <?php
        }
    } else {
        echo '<h5 class="notFound tt-4">No se encontró ninguna categoria</h5>';
    }
    ?>
</main>
<section class="space"></section>