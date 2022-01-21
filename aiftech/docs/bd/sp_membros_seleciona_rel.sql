DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `membros_seleciona_rel`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `membros_seleciona_rel`(
    vempresa INT (11),
    vativo CHAR(1),
    vquorum CHAR(1)
)
BEGIN
    SELECT
        T1.*,
        CASE
            WHEN T1.estadocivil = 0
            THEN 'Solteiro(a)'
            WHEN T1.estadocivil = 1
            THEN 'Casado(a)'
            WHEN T1.estadocivil = 2
            THEN 'Divorciado(a)'
            WHEN T1.estadocivil = 3
            THEN 'Viúvo(a)'
            WHEN T1.estadocivil = 4
            THEN 'Separado(a)'
            ELSE ''
        END estado_civil,
        l.nome locais,
        en.cep,
        en.logradouro,
        en.bairro,
        en.localidade,
        es.sigla enderecos_estado,
        T2.sigla estado_descricao,
        T3.descricao escolaridade_descricao,
        T4.nome profissoes_descricao,
        ps.idade_quorum,
        mf.frequencia,
        mf.status,
        mf.quorum
    FROM membros T1
        LEFT JOIN estados T2
            ON T1.estado_id = T2.id
        LEFT JOIN escolaridades T3
            ON T1.escolaridade_id = T3.id
        LEFT JOIN profissoes T4
            ON T1.profissao_id = T4.id
        INNER JOIN membros_frequencia mf
            ON T1.frequencia_id = mf.id
        INNER JOIN parametros_sistema ps
            ON T1.empresa_id = ps.empresa_id
        LEFT JOIN enderecos en
            ON T1.enderecos_id = en.id
        LEFT JOIN estados es
            ON en.estado_id = es.id
        LEFT JOIN `local` l
            ON T1.local_id = l.id
    WHERE T1.empresa_id = vempresa
        AND mf.status = IFNULL(vativo, mf.status)
        AND mf.quorum = IFNULL(vquorum, mf.quorum)
    ORDER BY T1.modified DESC,
        T1.nome ASC;
END$$

DELIMITER ;