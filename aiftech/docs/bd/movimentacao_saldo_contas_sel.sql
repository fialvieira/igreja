DELIMITER $$

USE `igreja`$$

DROP PROCEDURE IF EXISTS `movimentacao_saldo_contas_sel`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `movimentacao_saldo_contas_sel`(
  vtipo_conta CHAR(1),
  vempresa_id INT (11)
)
BEGIN
  SELECT
    C.`id`,
    C.`nome`,
    IFNULL(MS.saldo, IFNULL(C.saldo_inicial, 0.00)) saldo
  FROM
    contas_financeira C
    LEFT JOIN
      (SELECT
        conta_financ_id,
        saldo,
        empresa_id
      FROM
        movimentacao_saldo
      ORDER BY created DESC
      LIMIT 1) AS MS
      ON C.id = MS.conta_financ_id
      AND C.`empresa_id` = MS.empresa_id
  WHERE C.tipo_conta = vtipo_conta
    AND C.empresa_id = vempresa_id
  ORDER BY C.`id`;
END$$

DELIMITER ;