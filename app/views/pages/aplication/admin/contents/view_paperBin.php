<section class="space"></section>
<main id="paperBin">
    <div class="content-bar">
        <div class="form-bin content-table">
            <?php
            if (!empty($class)) {
                if ($class == 'Admin') {
                    $ctrll = 'administrador';
                } else if ($class == 'Category') {
                    $ctrll = 'categoria';
                } else if ($class == 'Product') {
                    $ctrll = 'producto';
                }
    
                if (!empty($ctrll)) {
            ?>
                    <form class="ajax-form paperBin" action="?ajax=<?= $ctrll ?>&&func=paperBin" data-redirect=".alert">
                        <div class="alert"></div>
                        <?php
                        require_once('app/views/pages/aplication/admin/components/forms/cont_bin' . $class . '.php');
                        ?>
                    </form>
            <?php
                } else {
                    echo '<h5 class="notFound tt-5">Contacta a los desarrolladores</h5>';
                }
            } else {
                echo '<h5 class="notFound tt-5">Ninguna visualización</h5>';
            }
            ?>
            <br>
            <p class="tx">Si no se alcanzan a ver los datos, por favor mover hacia la izquierda para ver los demás.</p>
        </div>
        <div class="slide-menu">
            <ul>
                <li>
                    <a href="?ctrll=categoria&&func=paperBin">Categorias</a>
                </li>
                <li>
                    <a href="?ctrll=producto&&func=paperBin">Productos</a>
                </li>
                <li>
                    <a href="?ctrll=administrador&&func=paperBin">Administradores</a>
                </li>
            </ul>
        </div>
    </div>
</main>
<section class="space"></section>