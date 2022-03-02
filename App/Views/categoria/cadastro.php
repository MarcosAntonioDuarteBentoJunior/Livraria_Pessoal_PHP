<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Cadastro de Categoria</h3>

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
                    <?php echo $Sessao::retornaMensagem(); ?> <br>
                </div>
            <?php } ?>

            <form action="http://<?php echo APP_HOST; ?>/categoria/salvar" method="post" id="form_cadastro">

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" name="categoria" placeholder="Nome da Categoria" value="<?php echo $Sessao::retornaValorFormulario('categoria'); ?>">

                </div>

                <div class="form-group">
                    <label for="descricao">Descricao</label>
                    <textarea class="form-control" name="descricao" placeholder="Descrição da categoria (opcional)"><?php echo $Sessao::retornaValorFormulario('descricao'); ?></textarea>

                </div>

                <button type="submit" class="btn btn-success btn-sm">Salvar</button>
            </form>
        </div>
        <div class=" col-md-3"></div>
    </div>
</div>