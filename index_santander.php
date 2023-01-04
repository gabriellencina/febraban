<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerador parcelas e layout Santander</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
    .ajustaform {
            display: block;
            margin: auto;
            padding-top: 5em;
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <div class="row center">
            <div class="col-md-3 ajustaform">
                <form action="manipula_santander.php" method="POST">
                    <div class="row mb-3">
                        <label class="form-label" for="data">Data de vencimento: </label>
                        <input type="date" class="form-control" name="data">
                    </div>
                    
                    <div class="row mb-3">
                        <label class="form-label" for="data">Código do convênio: </label>
                        <input type="text" class="form-control" name="convenio">
                    </div>
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="submit" name="gera_parcela" value="1">Gerar parcelas</button>
                    </div>
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="submit" name="gera_arquivo_optante" value="2">Gerar arquivo optante</button>
                    </div>
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="submit" name="gera_arquivo_debito" value="3">Gerar arquivo debito</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>