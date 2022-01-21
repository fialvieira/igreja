SELECT m.`nome`
			,m.`databatismo`
			,ig.`nome` igreja_batismo
			,pb.`nome` pastor_batismo
			,CASE IFNULL(m.`databatismo`, '')
				WHEN '' THEN ''
				ELSE 'Batismo'
			 END tp_mov_batismo
			,NULL ata_numero
			,NULL carta_id
			,NULL data_carta_envio
			,NULL data_carta_recebimento
			,NULL carta_recebimento_path
			,NULL secretario
			,NULL presidente
			,NULL observacao
FROM membros m
LEFT JOIN empresas ig
	ON m.`igrejas_id` = ig.`id`
LEFT JOIN pastores pb
	ON m.`pastorbatismo` = pb.`id`
WHERE m.`empresa_id` = 1
	AND m.`id` = 3995
UNION	
SELECT me.`nome`
			,mm.`data`
			,e.`nome` igreja
			,p.`nome` pastor
			,tmm.`nome` tp_mov_batismo
			,a.`num` ata_numero
			,mm.`carta_id`
			,mm.`data_carta_envio`
			,mm.`data_carta_recebimento`
			,mm.`carta_recebimento_path`
			,me_sec.`nome` secretario
			,me_pres.`nome` presidente
			,mm.`observacao`
FROM movimentacao_membros mm
LEFT JOIN membros me
	ON mm.`membro_id` = me.`id`
 AND mm.`empresa_id` = me.`empresa_id`
LEFT JOIN membros me_sec
	ON mm.`secretaria_id` = me_sec.`id`
 AND mm.`empresa_id` = me_sec.`empresa_id`
LEFT JOIN membros me_pres
	ON mm.`pastor_pres_id` = me_pres.`id`
 AND mm.`empresa_id` = me_pres.`empresa_id`
LEFT JOIN empresas e
	ON mm.`igreja_id` = e.`id`
LEFT JOIN pastores p
	ON mm.`pastor_id` = p.`id`
LEFT JOIN tipo_movimentacao_membro tmm
	ON mm.`tipo_movimentacao_membro_id` = tmm.`id`
LEFT JOIN atas a
	ON mm.`ata_id` = a.`id`
 AND mm.`empresa_id` = a.`empresa_id`
WHERE mm.`empresa_id` = 1
	AND mm.`membro_id` = 3995
