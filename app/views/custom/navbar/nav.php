<nav id="navbar">
    <div class="content-nav">
        <div class="toggle-nav">
            <button class="btn-menu">
                <i class="fa-solid fa-bars title tt-4"></i>
            </button>
            <div class="name-app">
                <h5 class="tt-2">BOTIQUINES</h5>
                <p>SALUD & BIENESTAR</p>
            </div>
        </div>
        <ul class="list-nav">
            <li>
                <a href="?ctrll=paginas&&func=nosotros">Nosotros</a>
            </li>
            <?php
            if (!empty($_SESSION['num_doc'])) {
            ?>
                <li>
                    <a href="?ctrll=administrador&&func=view">Administradores</a>
                </li>
            <?php
            }
            ?>
            <li>
                <a href="?ctrll=paginas&&func=inicio">Inicio</a>
            </li>
            <li>
                <a href="?ctrll=categoria&&func=view">Productos</a>
            </li>
            <?php
            if (!empty($_SESSION['num_doc'])) {
            ?>
                <li>
                    <a href="?ctrll=paginas&&func=paperBin">Papelera</a>
                </li>
            <?php
            } else {
            ?>
                <li>
                    <a href="?ctrll=paginas&&func=signIn">Ingresar</a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <?php
    if (!empty($_SESSION['num_doc'])) {
        echo '<div class="icons"><a href="?ctrll=paginas&&func=signOut"><i class="fa-solid fa-right-to-bracket"></i></a></div>';
    }
    ?>
</nav>