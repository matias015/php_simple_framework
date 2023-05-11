<header style="display:flex;">
    <nav>
        <li><a href="<?php echo Route::route("/alumno/informacion") ?>">Mi informacion</a></li>
        <li><a href="<?php echo Route::route("/alumno/cursadas") ?>">Mis cursadas</a></li>
        <li><a href="<?php echo Route::route("/alumno/examenes") ?>">Mis examenes</a></li>
        <li><a href="<?php echo Route::route("/alumno/inscripciones") ?>">Inscribir a mesa</a></li>
        <li><a href="<?php echo Route::route("/admin/dias") ?>">dias habiles</a></li>
        <hr>
        <li><?php echo Auth::user() -> nombre ?></li>
        <li><a href="<?php echo Route::route("/logout") ?>">Cerrar sesion</a></li>
    </nav>

    

</header>