DELIMITER $$

USE `igreja_hom`$$

DROP PROCEDURE IF EXISTS `movimentacao_membros_rel`$$

CREATE DEFINER=`root`@`%` PROCEDURE `movimentacao_membros_rel`(
  IN `vempresa_id`   INT(11),
  IN `vmembro_id`    INT(11) UNSIGNED,
  IN `vtipo_mm_id`   INT(11) UNSIGNED,
  IN `vata_id`       INT(11) UNSIGNED,
  IN `vdata_inicial` DATE,
  IN `vdata_final`   DATE
)
BEGIN
    SELECT DISTINCT
    m_membro.`id` membro_id,
    m_membro.`nome`,
    mm.`id`,
    IFNULL(a.data, doc.`data`) data_mov,
    emp.nome igreja,
    emp.abreviacao,
    m_pastor.`nome` pastor,
    tmm.`nome` tp_mov,
    tmm.`tipo_movimentacao`,
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
  FROM movimentacao_membros mm
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
    LEFT JOIN membros m_membro
      ON mm.`membro_id` = m_membro.`id`
     AND mm.`empresa_id` = m_membro.`empresa_id`
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
  WHERE mm.`empresa_id` = 1
    AND mm.`membro_id` = IFNULL(vmembro_id, mm.`membro_id`)
    AND mm.tipo_movimentacao_membro_id = IFNULL(vtipo_mm_id, mm.tipo_movimentacao_membro_id)
    AND IFNULL(a.`data`, doc.`data`) BETWEEN IFNULL(vdata_inicial, '2016-01-01') AND IFNULL(vdata_final, CURDATE())
    AND IFNULL(a.`id`, IFNULL(doc.`ata_id`, '')) = CASE IFNULL(a.`id`, IFNULL(doc.`ata_id`, ''))
							WHEN '' THEN ''
							ELSE IFNULL(vata_id, IFNULL(a.`id`, IFNULL(doc.`ata_id`, '')))
						   END
  ORDER BY tmm.`tipo_movimentacao`, m_membro.`nome`, IFNULL(a.`data`, doc.`data`);
END$$

DELIMITER ;