<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php if ($viewVar['nameController'] == "HomeController") { ?> class="active" <?php } ?>>
                    <a href="http://<?php echo APP_HOST; ?>">Home</a>
                </li>
                <li <?php if ($viewVar['nameController'] == "LivroController" && ($viewVar['nameAction'] == "" || $viewVar['nameAction'] == "index")) { ?> class="active" <?php } ?>>
                    <a href="http://<?php echo APP_HOST; ?>/livro">Lista de Livros</a>
                </li>
                <li <?php if ($viewVar['nameController'] == "CategoriaController" && ($viewVar['nameAction'] == "" || $viewVar['nameAction'] == "index")) { ?> class="active" <?php } ?>>
                    <a href="http://<?php echo APP_HOST; ?>/categoria">Lista de categorias</a>
                </li>
                <li <?php if ($viewVar['nameController'] == "LogCOntroller") { ?> class="active" <?php } ?>>
                    <a href="http://<?php echo APP_HOST; ?>/log">Meus Acessos</a>
                </li>
            </ul>
        </div>
    </div>
</nav>