<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/normalize/normalize.css">

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/estilos.css">
    <title>Document</title>
</head>

<body>
    <div class="local_container">
        <form class=" border border-1 rounded p-5 m-0 opacity-75">
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="UserName" class="form-label">Nombres</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" id="UserName"
                        aria-describedby="errorHelp" required>
                    <div id="errorHelp" class="form-text visually-hidden">We'll never share your email with anyone else.
                    </div>
                </div>
                <div class="mb-1 col">
                    <label for="LastName" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" id="LastName"
                        aria-describedby="errorHelp" required>
                    <div id="errorHelp" class="form-text visually-hidden">We'll never share your email with anyone else.
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Phone" class="form-label">Numero Telefónico</label>
                    <input type="number" class="form-control" id="Phone" pattern="[0-9]{10}"
                        aria-describedby="errorHelp" required>
                    <div id="errorHelp" class="form-text visually-hidden">We'll never share your email with anyone else.
                    </div>
                </div>
                <div class="mb-1 col">
                    <label for="genero" class="form-label">Genero <span><em>(requerido para fines
                                estadisticos)</em></span></label>
                    <select type="text" id="genero" class="form-control" required>
                        <option value="mujer">Mujer</option>
                        <option value="hombre">Hombre</option>
                        <option value="nobinario">No binario</option>
                    </select>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Email" class="form-label">Correo Electrónico</label>
                    <input type="email" style="text-transform: lowercase;" class="form-control" id="UserName"
                        aria-describedby="errorHelp" required>
                    <div id="errorHelp" class="form-text visually-hidden">We'll never share your email with anyone else.
                    </div>
                </div>
                <div class="mb-1 col">
                    <label for="ConfirmEmail" class="form-label">Confirmar Correo Electrónico</label>
                    <input type="email" style="text-transform: lowercase;" class="form-control" id="ConfirmEmail"
                        aria-describedby="errorHelp" required>
                    <div id="errorHelp" class="form-text visually-hidden">We'll never share your email with anyone else.
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Razones" class="form-label">Menciona las razones por las cuales desea ser integrante del
                        Observatorio Anticorrupción</label>
                    <textarea class="form-control" id="Razones" rows="2"></textarea>
                    <div id="errorHelp" class="form-text visually-hidden">We'll never share your email with anyone else.
                    </div>
                </div>

            </div>
            <div class="row align-items-center mt-5">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <script src="./assets/js/bootstrap.min.js"></script>

    </script>
</body>

</html>