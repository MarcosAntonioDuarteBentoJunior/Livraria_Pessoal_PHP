<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <h3>Editar Livro</h3>

            <?php if ($Sessao::retornaErro()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php foreach ($Sessao::retornaErro() as $key => $mensagem) { ?>
                        <?php echo $key . ': ' . $mensagem; ?> <br>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ($Sessao::retornaMensagem()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $Sessao::retornaMensagem(); ?>
                </div>
            <?php } ?>

            <form action="http://<?php echo APP_HOST; ?>/livro/atualizar" method="post" id="form_cadastro">
                <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $viewVar['livro']->getIdLivro(); ?>">

                <div class="form-group">
                    <label for="nome">Titulo</label>
                    <input type="text" class="form-control" name="titulo" placeholder="Titulo do Livro" value="<?php echo $viewVar['livro']->getTitulo(); ?>">

                </div>
                <div class="form-group">
                    <label for="preco">Ediçao</label>
                    <input type="text" class="form-control" name="edicao" placeholder="Ediçao" value="<?php echo $viewVar['livro']->getEdicao(); ?>">

                </div>
                <div class="form-group">
                    <label for="anoPublicacao">Editora</label>
                    <input type="text" class="form-control" name="editora" placeholder="Editora" value="<?php echo $viewVar['livro']->getEditora(); ?>">

                </div>
                <div class="form-group">
                    <label for="descricao">Autor</label>
                    <input type="text" class="form-control" name="autor" placeholder="Autor" value="<?php echo $viewVar['livro']->getAutor(); ?>">

                </div>

                <div class="form-group">
                    <label for="idcategoria">Categoria</label>
                    <select class="form-control" name="idcategoria" required>
                        <?php foreach ($viewVar['listaCategorias'] as $Categoria) : ?>
                            <option value="<?php echo $Categoria->getIdCategoria(); ?>" <?php echo ($viewVar['livro']->getCategoria()->getIdCategoria() == $Categoria->getIdCategoria()) ? "selected" : ""; ?>><?php echo $Categoria->getNomeCategoria(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-sm">Salvar</button>
            </form>
        </div>
        <div class=" col-md-3"></div>
    </div>
</div>