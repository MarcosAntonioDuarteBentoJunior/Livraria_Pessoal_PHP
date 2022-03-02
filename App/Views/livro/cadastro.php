<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Cadastro de Livro</h3>

            <?php if ($Sessao::retornaErro()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php foreach ($Sessao::retornaErro() as $key => $mensagem) { ?>
                        <?php echo $key . ': ' . $mensagem; ?> <br>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php
            if (is_null($viewVar['listaCategorias'])) {
            ?>
                <div class="alert alert-info" role="alert">Nao e possivel cadastrar um livro sem que exista pelo menos uma categoria.</div>
            <?php
            } else {
            ?>

                <form action="http://<?php echo APP_HOST; ?>/livro/salvar" method="post" id="form_cadastro">
                    <div class="form-group">
                        <label for="nome">Titulo</label>
                        <input type="text" class="form-control" name="titulo" placeholder="Titulo do Livro" value="<?php echo $Sessao::retornaValorFormulario('titulo'); ?>">

                    </div>
                    <div class="form-group">
                        <label for="preco">Ediçao</label>
                        <input type="text" class="form-control" name="edicao" placeholder="Ediçao" value="<?php echo $Sessao::retornaValorFormulario('edicao'); ?>">

                    </div>
                    <div class="form-group">
                        <label for="anoPublicacao">Editora</label>
                        <input type="text" class="form-control" name="editora" placeholder="Editora" value="<?php echo $Sessao::retornaValorFormulario('editora'); ?>">

                    </div>
                    <div class="form-group">
                        <label for="paginas">Autor</label>
                        <input type="text" class="form-control" name="autor" placeholder="Autor" value="<?php echo $Sessao::retornaValorFormulario('autor'); ?>">

                    </div>
                    <div class="form-group">
                        <label for="descricao">Categoria</label>
                        <select class="form-control" name="idcategoria" required>
                            <?php foreach ($viewVar['listaCategorias'] as $categoria) : ?>
                                <option value="<?php echo $categoria->getIdCategoria(); ?>" <?php echo ($Sessao::retornaValorFormulario('idcategoria') == $categoria->getIdCategoria()) ? "selected" : ""; ?>><?php echo $categoria->getNomeCategoria(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                </form>
            <?php } ?>
        </div>
        <div class=" col-md-3"></div>
    </div>
</div>