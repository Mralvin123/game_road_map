<main class="contenedor seccion">
    <h1>Registrar Estudiante</h1>
    <a href="listarestudiante.php" class="boton boton-verde">Volver</a>
    <form method="post" action="registrarestudiante.php" class="formulario">
        <fieldset>
            <legend>Información General</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nom" id="nom" placeholder="Nombre" required>

            <label for="paterno">Apellido Paterno:</label>
            <input type="text" name="pat" id="pat" placeholder="Apellido Paterno" required>

            <label for="materno">Apellido Materno:</label>
            <input type="text" name="mat" id="mat" placeholder="Apellido Materno" required>

            <label for="idcurso">ID Curso:</label>
            <input type="number" name="idcurso" id="idcurso" placeholder="ID del Curso" required>
        </fieldset>

        <input type="submit" value="Registrar Estudiante" class="boton boton-verde">
    </form>
</main>