<table>
    <thead>
    <tr>
        <th class="">Nome</th>
        <th class="">Telefone</th>
        <th class="">Celular</th>
        <th class="">Email</th>
        <th class="">Logradouro</th>
        <th class="">Número</th>
        <th class="">Bairro</th>
        <th class="">Município</th>
        <th class="">Estado</th>
        <th class="">Complemento</th>
        <th class="">CEP</th>
        <th class="">Associação</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Telefone"><?= e(\bd\Formatos::telefoneApp($ret["telefone"])) ?></td>
            <td data-titulo="Celular"><?= e(\bd\Formatos::telefoneApp($ret["celular"])) ?></td>
            <td data-titulo="Email" class=""><?= e($ret["email"]) ?></td>
            <td data-titulo="Logradouro" class=""><?= e($ret['logradouro']) ?></td>
            <td data-titulo="Número" class=""><?= e($ret['numero']) ?></td>
            <td data-titulo="Bairro" class=""><?= e($ret['bairro']) ?></td>
            <td data-titulo="Município" class=""><?= e($ret['municipio']) ?></td>
            <td data-titulo="Estado" class=""><?= e($ret['estado']) ?></td>
            <td data-titulo="Complemento" class=""><?= e($ret["complemento"]) ?></td>
            <td data-titulo="CEP" class="">
                <a title=" Ver endereço no Google Maps" href="https://www.google.com.br/maps/search/<?= e($ret['logradouro']. ' ' . $ret['numero'] . ' ' . $ret['bairro'] . ' ' . $ret['municipio'] . ' ' . $ret['estado']) ?>" target="_blank"><?= e($ret["cep"]) ?></a>
            </td>
            <td data-titulo="Associação" class=""><?= e($ret["associacao"]) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>