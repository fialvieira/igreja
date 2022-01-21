<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Celular</th>
            <th>Perfil</th>
            <?php if(Aut::temPerfil(Aut::PERFIL_MASTER, Aut::PRESIDENTE, Aut::ADMINISTRATIVO)): ?>
              <th></th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($usuarios as $usuario):?>
          <?php if($usuario['perfil']== Aut::PERFIL_MASTER):?>
            <?php if(Aut::temPerfil(Aut::PERFIL_MASTER)):?>
              <tr>
                  <td data-titulo="Nome"><?=e($usuario['nome'])?></a></td>
                  <td data-titulo="E-mail"><?=e($usuario['email'])?></td>
                  <td data-titulo="Celular"><?=e(bd\Formatos::telefoneApp($usuario['celular']))?></td>
                  <td data-titulo="Perfil"><?=e($perfis[$usuario['perfil']])?></td> 
                  <td class="acoes">
                      <div>
                          <a id="a_acao" title="Alterar dados" class="alterar" href="usuario.php?codigo=<?=hs($usuario['id'])?>"></a>
<!--                          <a id="e_acao" title="Excluir dados" class="excluir" onclick="excluirUsuario(<?=$usuario['id']?>)"></a>-->
                          <a id="s_acao" title="<?= ($usuario['ativo'] == 'S') ? 'Desativar usuário' : 'Ativar usuário' ?>" class="<?= ($usuario['ativo'] == 'S') ? 'ligado' : 'desligado' ?>" onclick="mudarStatus(<?=$usuario['id']?>, '<?= ($usuario['ativo'] == 'S') ? 'D' : 'A' ?>')"></a>
                      </div>
                  </td>   
              </tr>
            <?php endif;?>
          <?php else:?>
            <tr>
                <td data-titulo="Nome"><?=e($usuario['nome'])?></a></td>
                <td data-titulo="E-mail"><?=e($usuario['email'])?></td>
                <td data-titulo="Celular"><?=e(bd\Formatos::telefoneApp($usuario['celular']))?></td>
                <td data-titulo="Perfil"><?=e($perfis[$usuario['perfil']])?></td>
                <?php if(Aut::temPerfil(Aut::PERFIL_MASTER, Aut::PRESIDENTE, Aut::ADMINISTRATIVO)): ?>
                  <td class="acoes">
                      <div>
                          <a id="a_acao" title="Alterar dados" class="alterar" href="usuario.php?codigo=<?=hs($usuario['id'])?>"></a>
<!--                          <a id="e_acao" title="Excluir dados" class="excluir" onclick="excluirUsuario(<?=$usuario['id']?>)"></a>-->
                          <a id="s_acao" title="<?= ($usuario['ativo'] == 'S') ? 'Desativar usuário' : 'Ativar usuário' ?>" class="<?= ($usuario['ativo'] == 'S') ? 'ligado' : 'desligado' ?>" onclick="mudarStatus(<?=$usuario['id']?>, '<?= ($usuario['ativo'] == 'S') ? 'D' : 'A' ?>')"></a>
                      </div>
                  </td>
                <?php endif; ?>
            </tr>
          <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>