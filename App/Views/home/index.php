<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Pagina Inicial</h3>

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

            <form action="http://<?php echo APP_HOST; ?>/usuario/login" method="post" id="form_cadastro">
                <div class="form-group">
                    <label for="nome">Usuario</label>
                    <input type="text" class="form-control" name="nomeUsuario" placeholder="Seu Nome de usuario" value="">

                </div>
                <div class="form-group">
                    <label for="email">Senha</label>
                    <input type="password" class="form-control" name="senha" placeholder="Senha" value="">
                </div>
                <button type="submit" class="btn btn-success btn-sm">Entrar</button>
                <a href="http://<?php echo APP_HOST; ?>/usuario/cadastro" class="btn btn-info btn-sm">Cadastrar</a>
            </form>
        </div>
        <div class=" col-md-3"></div>
    </div>
</div>