<div class="container">
    <div class="row">
        <br>
        <div class="col-md-12">
            <a href="http://<?php echo APP_HOST; ?>/categoria/cadastro" class="btn btn-success btn-sm">Adicionar</a>
            <hr>
        </div>
        <div class="col-md-12">
            <?php if ($Sessao::retornaMensagem()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $Sessao::retornaMensagem(); ?>
                </div>
            <?php } ?>

            <?php
            if (is_null($viewVar['listaCategorias'])) {
            ?>
                <div class="alert alert-info" role="alert">Nenhuma categoria cadastrada</div>
            <?php
            } else {
            ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td class="info">Categoria</td>
                            <td class="info">Descricao</td>
                            <td class="info">Opçoes</td>
                        </tr>
                        <?php
                        foreach ($viewVar['listaCategorias'] as $categoria) {
                        ?>
                            <tr>
                                <td><?php echo $categoria->getNomeCategoria(); ?></td>
                                <td><?php echo $categoria->getDescricao(); ?></td>
                                <td>
                                    <a href="http://<?php echo APP_HOST; ?>/categoria/edicao/<?php echo $categoria->getIdCategoria(); ?>" class="btn btn-info btn-sm">Editar</a>
                                    <a href="http://<?php echo APP_HOST; ?>/categoria/exclusao/<?php echo $categoria->getIdCategoria(); ?>" class="btn btn-danger btn-sm">Excluir</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>