<header>
    <nav>
        <li><a href="/alumno/informacion">Mi informacion</a></li>
        <li><a href="/alumno/cursadas">Mis cursadas</a></li>
        <li><a href="/alumno/examenes">Mis examenes</a></li>
        <li><a href="/alumno/inscripciones">Inscribir a mesa</a></li>
        <?php if(Auth::isLogin()){ ?>
            <li><a href="/logout">Cerrar sesion</a></li>
        <?php } ?>
        </nav>
</header>