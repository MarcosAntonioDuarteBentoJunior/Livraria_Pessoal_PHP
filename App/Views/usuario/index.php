<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Minha Pagina</h3>

            <?php if ($Sessao::retornaMensagem()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $Sessao::retornaMensagem(); ?>
                </div>
            <?php } ?>

            <div class="alert alert-warning" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo 'Ola, ' . $Sessao::retornaUsuarioLogado(); ?>
            </div>

            <div>
                <a href="http://<?php echo APP_HOST; ?>/usuario/logout/<?php echo $Sessao::retornaIdUsuario(); ?>" class="btn btn-info btn-sm">Sair</a>
                <a href="http://<?php echo APP_HOST; ?>/usuario/edicao/<?php echo $Sessao::retornaIdUsuario(); ?>" class="btn btn-info btn-sm">Editar Perfil</a>
                <a href="http://<?php echo APP_HOST; ?>/usuario/exclusao/<?php echo $Sessao::retornaIdUsuario(); ?>" class="btn btn-danger btn-sm">Excluir Conta</a>
            </div>
        </div>