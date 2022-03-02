<div class="container">
    <div class="row">
        <br>
        <div class="col-md-12">
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
            if (!count($viewVar['info'])) {
            ?>
                <div class="alert alert-info" role="alert">Nenhum registro encontrado</div>
            <?php
            } else { ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td class="info">ID Do Registro </td>
                            <td class="info">Usuario</td>
                            <td class="info">Email</td>
                            <td class="info">Açao</td>
                            <td class="info">Data/Hora</td>
                        </tr>
                        <?php
                        foreach ($viewVar['info'] as $log) {
                        ?>
                            <tr>
                                <td><?php echo $log->getIdLog(); ?></td>
                                <td><?php echo $log->getUsuario(); ?></td>
                                <td><?php echo $log->getEmail(); ?></td>
                                <td><?php echo $log->getAcao(); ?></td>
                                <td><?php echo $log->getHorario(); ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>