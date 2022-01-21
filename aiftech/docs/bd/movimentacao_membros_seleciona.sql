DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_membros_seleciona`$$

CREATE DEFINER=`root`@`%` PROCEDURE `movimentacao_membros_seleciona`(
  IN `vmembro_id` INT (11) UNSIGNED,
  IN `vempresa_id` INT (11)
)
BEGIN
  SELECT
    m.`id`,
    m.`databatismo` data_mov,
    ig.`nome` igreja,
    ig.`abreviacao`,
    pb.`nome` pastor,
    CASE
      IFNULL(m.`databatismo`, '')
      WHEN ''
      THEN ''
      ELSE 'Batismo'
    END tp_mov,
    a.id ata_id,
    a.num ata_numero,
    IFNULL(a_arq.path, '') ata_path,
    NULL carta_id,
    NULL carta_numero,
    NULL data_carta_envio,
    NULL data_carta_recebimento,
    NULL carta_recebimento_path,
    NULL carta_envio_path,
    NULL secretario,
    NULL presidente,
    NULL observacao,
    'N' exclusao,
    m.`created`
  FROM
    membros m
    LEFT JOIN empresas ig
      ON m.`igrejas_id` = ig.`id`
    LEFT JOIN pastores pb
      ON m.`pastorbatismo` = pb.`id`
    LEFT JOIN atas a
      ON m.ata_batismo = a.id
      AND m.empresa_id = a.empresa_id
    LEFT JOIN ata_arquivos a_arq
      ON a.id = a_arq.ata_id
      AND a.empresa_id = a_arq.empresa_id
  WHERE m.`empresa_id` = vempresa_id
    AND m.`id` = vmembro_id
  UNION
  SELECT DISTINCT
    mm.`id`,
    a.data data_mov,
    emp.nome igreja,
    emp.abreviacao,
    m_pastor.`nome` pastor,
    tmm.`nome` tp_mov,
    IFNULL(a.id, doc.ata_id) ata_id,
    IFNULL(a.`num`, a_doc.num) ata_numero,
    IFNULL(a_arq.path, '') ata_path,
    mm.`carta_id`,
    doc.num carta_numero,
    doc.data data_carta_envio,
    IFNULL(
      mm.`data_carta_recebimento`,
      doc.data_carta
    ) data_carta_recebimento,
    mm.`carta_recebimento_path`,
    doc.path_arquivo carta_envio_path,
    m_secretario.`nome` secretario,
    m_pres.`nome` presidente,
    mm.`observacao`,
    'S' exclusao,
    mm.`created`
  FROM
    movimentacao_membros mm
    LEFT JOIN tipo_movimentacao_membro tmm
      ON mm.tipo_movimentacao_membro_id = tmm.id
    LEFT JOIN atas a
      ON mm.`ata_id` = a.`id`
      AND mm.`empresa_id` = a.`empresa_id`
    LEFT JOIN ata_arquivos a_arq
      ON a.id = a_arq.ata_id
      AND a.empresa_id = a_arq.empresa_id
      AND a_arq.ata_digit = 'S'
    LEFT JOIN documentos doc
      ON mm.carta_id = doc.id
      AND mm.empresa_id = doc.empresa_id
    LEFT JOIN membros m_pres
      ON doc.presidencia = m_pres.id
      AND doc.`empresa_id` = m_pres.`empresa_id`
    LEFT JOIN membros m_pastor
      ON doc.pastor_destino_id = m_pastor.id
      AND doc.`empresa_id` = m_pastor.`empresa_id`
    LEFT JOIN membros m_secretario
      ON doc.secretario = m_secretario.id
      AND doc.`empresa_id` = m_secretario.`empresa_id`
    LEFT JOIN empresas emp
      ON doc.igreja_destino_id = emp.id
    LEFT JOIN atas a_doc
      ON doc.ata_id = a_doc.id
      AND doc.empresa_id = a_doc.empresa_id
  WHERE mm.`empresa_id` = vempresa_id
    AND mm.`membro_id` = vmembro_id;
END$$

DELIMITER ;