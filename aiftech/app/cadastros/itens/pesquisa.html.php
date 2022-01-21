<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="">Isbn</th>
      <th class="">Titulo</th>
      <th class="">Foto</th>
      <th class="centro">Paginas</th>
      <th class="direita">Preco</th>
      <th class="">Comentarios</th>
      <th class="centro">Estoque</th>
      <th class="">Autor</th>
      <th class="">Categoria</th>
      <th class="">Editora</th>
      <th class="">Tipo</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Isbn" class=""><?= e($ret["isbn"]) ?></td>
      <td data-titulo="Titulo" class=""><?= e($ret["titulo"]) ?></td>
      <td data-titulo="Foto" class=""><?= e($ret["foto"]) ?></td>
      <td data-titulo="Paginas" class="centro"><?= e(\bd\Formatos::inteiro($ret["paginas"])) ?></td>
      <td data-titulo="Preco" class="direita"><?= e(\bd\Formatos::real($ret["preco"])) ?></td>
      <td data-titulo="Comentarios" class=""><?= e($ret["comentarios"]) ?></td>
      <td data-titulo="Estoque" class="centro"><?= e(\bd\Formatos::inteiro($ret["estoque"])) ?></td>
      <td data-titulo="Autor" class=""><?= e($ret["autor_descricao"]) ?></td>
      <td data-titulo="Categoria" class=""><?= e($ret["categoria_descricao"]) ?></td>
      <td data-titulo="Editora" class=""><?= e($ret["editora_descricao"]) ?></td>
      <td data-titulo="Tipo" class=""><?= e($ret["tipobiblioteca_descricao"]) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="item.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="item.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>