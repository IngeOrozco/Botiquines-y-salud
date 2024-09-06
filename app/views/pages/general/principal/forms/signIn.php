<article id="sign">
    <div class="background">
        <div class="header-sign">
            <h5 class="title tt-9">Botiquines Salud<br>y<br>Bienestar</h5>
        </div>
        <div class="body-sign">
            <form class="sign ajax-form" action="?ajax=administrador&&func=validate" data-redirect=".alert" method="post">
                <h5 class="sign-title tt-6">Inicio de sesión</h5>
                <div class="alert danger" role="alert"></div>
                <div class="elements">
                    <div class="item user">
                        <label class="label" for="usu_adm"><i class="fa-solid fa-user title tt-8"></i></label>
                        <input type="text" id="usu_adm" name="usu_adm" class="input" placeholder="Usuario / Correo">
                    </div>
                    <div class="item lock">
                        <input type="password" id="pass_adm" name="pass_adm" class="input" placeholder="Contraseña">
                        <label class="label" for="pass_adm"><i class="fa-solid fa-lock title tt-8"></i></label>
                    </div>
                </div>
                <div class="sign-btn">
                    <button type="submit" name="btn-adm-in" class="btn">Iniciar sesión</button>
                </div>
            </form>
        </div>
    </div>
</article>