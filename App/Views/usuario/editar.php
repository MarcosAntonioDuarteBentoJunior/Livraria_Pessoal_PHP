<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Editar Meu perfil</h3>

            <?php if ($Sessao::retornaMensagem()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $Sessao::retornaMensagem(); ?> <br>
                </div>
            <?php } ?>

            <?php if ($Sessao::retornaErro()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php foreach ($Sessao::retornaErro() as $key => $mensagem) { ?>
                        <?php echo $key . ': ' . $mensagem; ?> <br>
                    <?php } ?>
                </div>
            <?php } ?>

            <form action="http://<?php echo APP_HOST; ?>/usuario/atualizar" method="post" id="form_cadastro">
                <input type="hidden" class="form-control" name="idusuario" id="id" value="<?php echo $viewVar['usuario']->getIdUsuario(); ?>">

                <div class="form-group">
                    <label for="nome">Usuario</label>
                    <input type="text" class="form-control" name="nomeUsuario" placeholder="Nome de Usuario" value="<?php echo $viewVar['usuario']->getNomeUsuario(); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $viewVar['usuario']->getEmail(); ?>">
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="text" class="form-control" name="senha" placeholder="Crie uma senha" value="<?php echo $viewVar['usuario']->getSenha(); ?>">
                </div>
                <button type="submit" class="btn btn-success btn-sm">Atualizar</button>
            </form>
        </div>
        <div class=" col-md-3"></div>
    </div>
</div>