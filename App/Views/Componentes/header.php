<header style="display:flex;">
    <nav>
        <li><a href="/alumno/informacion">Mi informacion</a></li>
        <li><a href="/alumno/cursadas">Mis cursadas</a></li>
        <li><a href="/alumno/examenes">Mis examenes</a></li>
        <li><a href="/alumno/inscripciones">Inscribir a mesa</a></li>
        <li><a href="/admin/dias">dias habiles</a></li>
        <hr>
        <li><?php echo Auth::user() -> nombre ?></li>
        <li><a href="/logout">Cerrar sesion</a></li>
    </nav>

    

</header>