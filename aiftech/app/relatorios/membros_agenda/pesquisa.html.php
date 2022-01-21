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
        <th class="">Local</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Telefone"><?= e(\bd\Formatos::telefoneApp($ret["fone"])) ?></td>
            <td data-titulo="Celular"><?= e(\bd\Formatos::telefoneApp($ret["cel"])) ?></td>
            <td data-titulo="Email" class=""><?= e($ret["email"]) ?></td>
            <td data-titulo="Logradouro" class=""><?= e($ret['logradouro']) ?></td>
            <td data-titulo="Número" class=""><?= e($ret['enderecos_numero']) ?></td>
            <td data-titulo="Bairro" class=""><?= e($ret['bairro']) ?></td>
            <td data-titulo="Município" class=""><?= e($ret['municipio']) ?></td>
            <td data-titulo="Estado" class=""><?= e($ret['estado']) ?></td>
            <td data-titulo="Complemento" class=""><?= e($ret["enderecos_complemento"]) ?></td>
            <td data-titulo="CEP" class="">
                <a title=" Ver endereço no Google Maps" href="https://www.google.com.br/maps/search/<?= e($ret['logradouro']. ' ' . $ret['enderecos_numero'] . ' ' . $ret['bairro'] . ' ' . $ret['municipio'] . ' ' . $ret['estado']) ?>" target="_blank"><?= e($ret["cep"]) ?></a>
            </td>
            <td data-titulo="Local" class=""><?= e($ret["local"]) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>