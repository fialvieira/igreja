DELIMITER $$

SET GLOBAL event_scheduler = ON$$     -- required for event to execute but not create    

CREATE	/*[DEFINER = { user | CURRENT_USER }]*/	EVENT `igreja`.`ajusta_cargos`

ON SCHEDULE
	 /* uncomment the example below you want to use */

	-- scheduleexample 1: run once

	   --  AT 'YYYY-MM-DD HH:MM.SS'/CURRENT_TIMESTAMP { + INTERVAL 1 [HOUR|MONTH|WEEK|DAY|MINUTE|...] }

	-- scheduleexample 2: run at intervals forever after creation

	   EVERY 1 MONTH

	-- scheduleexample 3: specified start time, end time and interval for execution
	   /*EVERY 1  [HOUR|MONTH|WEEK|DAY|MINUTE|...]

	   STARTS CURRENT_TIMESTAMP/'YYYY-MM-DD HH:MM.SS' { + INTERVAL 1[HOUR|MONTH|WEEK|DAY|MINUTE|...] }

	   ENDS CURRENT_TIMESTAMP/'YYYY-MM-DD HH:MM.SS' { + INTERVAL 1 [HOUR|MONTH|WEEK|DAY|MINUTE|...] } */

STARTS CURRENT_TIMESTAMP 
ON COMPLETION PRESERVE
ENABLE 

DO
	BEGIN
	    CALL ajusta_cargos(1, 'S', 'N', 37);
	END$$

DELIMITER ;