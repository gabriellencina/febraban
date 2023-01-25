<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerador parcelas e layout BB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
    .ajustaform {
            display: block;
            margin: auto;
            padding-top: 5em;
        }
    h1, h2 { 
        text-align: center;
        font-size: 2.5em;
    }
    .container-header {
        padding: 3.5em;
    }
    .ajustaform {
        margin-block: -6em;
    }
    </style>
</head>
<body>
    <div class="container-header">
        <h1>Gerador de parcelas BB</h1>
            <h2>Produção</h2>
    </div>
    <div class="container text-center">
        <div class="row center">
            <div class="col-md-3 ajustaform">
                <form action="manipula_bb.php" method="POST">
                    <div class="row mb-3">
                        <label class="form-label" for="data">Data de vencimento: </label>
                        <input type="date" class="form-control" name="data">
                    </div>
                    <div class="row mb-3">
                        <label class="form-label" for="data">Dia inicial: </label>
                        <input type="number" class="form-control" name="dia_inicial">
                    </div>
                    <div class="row mb-3">
                        <label class="form-label" for="data">Dia final: </label>
                        <input type="number" class="form-control" name="dia_final">
                    </div>
                    <div class="row mb-3">
                        <label class="form-label" for="data">Código do convênio: </label>
                        <input type="text" class="form-control" name="convenio">
                    </div>
                    <div class="row mb-3">
                    <label class="form-label" for="data">Id do vendedor: </label>
                        <input type="text" class="form-control" name="vendedor">
                    </div>
                   
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="submit" name="gera_parcela" value="1">Gerar parcelas</button>
                    </div>
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="submit" name="gera_arquivo_debito" value="2">Gerar arquivo debito</button>
                    </div>
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="submit" name="gera_arquivo_optante" value="3">Gerar arquivo optante</button>
                    </div>
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="submit" name="gera_arquivo_cancelamento" value="4">Gerar arquivo cancelamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
