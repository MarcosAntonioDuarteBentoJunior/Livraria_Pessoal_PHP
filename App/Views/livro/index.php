<div class="container">
    <div class="row">
        <div class="row">
            <form action="http://<?php echo APP_HOST; ?>/livro/" method="get" class="form-inline ">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <a href="http://<?php echo APP_HOST; ?>/livro/cadastro" class="btn btn-success btn-sm">Adicionar</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group pull-right">
                        <div class="input-group">
                            <span class="input-group-addon input-sm" id="basic-addon1">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </span>
                            <input type="text" placeholder="Buscar conteudo" required value="<?php echo $viewVar['buscaLivro']; ?>" class="form-control input-sm" name="buscaLivro" />

                            <div class="input-group-btn">
                                <button class="btn btn-success btn-sm" type="submit">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12 col-lg-12">
            <hr>
            <div class="col-md-12">
                <?php if ($Sessao::retornaMensagem()) { ?>
                    <div class="alert alert-warning" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo $Sessao::retornaMensagem(); ?>
                    </div>
                <?php } ?>

                <?php
                if (is_null($viewVar['listaLivros'])) {
                ?>
                    <div class="alert alert-info" role="alert">Nenhum livro encontrado. Efetue uma busca</div>
                <?php
                } else {
                ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <td class="info">Titulo</td>
                                <td class="info">Autor</td>
                                <td class="info">Edicao</td>
                                <td class="info">Editora</td>
                                <td class="info">Categoria</td>
                                <td class="info">Opçoes</td>
                            </tr>
                            <?php
                            foreach ($viewVar['listaLivros'] as $livro) {
                            ?>
                                <tr>
                                    <td><?php echo $livro->getTitulo(); ?></td>
                                    <td><?php echo $livro->getAutor(); ?></td>
                                    <td><?php echo $livro->getEdicao(); ?></td>
                                    <td><?php echo $livro->getEditora(); ?></td>
                                    <td><?php echo $livro->getCategoria()->getNomeCategoria(); ?></td>
                                    <td>
                                        <a href="http://<?php echo APP_HOST; ?>/livro/edicao/<?php echo $livro->getIdLivro(); ?><?php echo $viewVar['queryString']; ?>" class="btn btn-info btn-sm">Editar</a>
                                        <a href="http://<?php echo APP_HOST; ?>/livro/exclusao/<?php echo $livro->getIdLivro(); ?><?php echo $viewVar['queryString']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div align="center"><?php echo $viewVar['paginacao'] ?></div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>