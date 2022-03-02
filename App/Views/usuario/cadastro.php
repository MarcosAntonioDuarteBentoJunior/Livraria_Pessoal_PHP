<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Cadastro de Usuario</h3>


            <?php if ($Sessao::retornaMensagem()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $Sessao::retornaMensagem(); ?>
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

            <form action="http://<?php echo APP_HOST; ?>/usuario/salvar" method="post" id="form_cadastro">
                <div class="form-group">
                    <label for="nome">Nome de Usuario</label>
                    <input type="text" class="form-control" name="nomeUsuario" placeholder="Nome de Usuario" value="<?php echo $Sessao::retornaValorFormulario('nomeUsuario'); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $Sessao::retornaValorFormulario('email'); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Senha</label>
                    <input type="password" class="form-control" name="senha" placeholder="Crie uma senha" value="<?php echo $Sessao::retornaValorFormulario('senha'); ?>">
                </div>
                <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                <button type="reset" class="btn btn-success btn-sm">Limpar campos</button>
            </form>
        </div>
        <div class=" col-md-3"></div>
    </div>
</div>