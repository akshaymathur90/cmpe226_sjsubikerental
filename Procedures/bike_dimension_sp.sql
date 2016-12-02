DELIMITER //

CREATE PROCEDURE create_bike_dimension()
BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE bikeid INT(11);
  DECLARE bikemodel VARCHAR(100);
  DECLARE biketype VARCHAR(100);
  DECLARE location VARCHAR(100);
  DECLARE registeryear DATE;
  DECLARE age INT(11);
  DECLARE bikekeyval INT(11);
  DECLARE cur1 CURSOR FOR select b.bikeid,m.bike_model,b.age,t.bike_type,l.branch_name from bike b,bike_model m,bike_type t,location l where m.bike_model_id = b.model and t.bike_type_id = b.bike_type and l.locationid=b.locationid;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  OPEN cur1;

  SELECT max(bikekey) into bikekeyval from bike_dimension;

  read_loop: LOOP
      FETCH cur1 INTO bikeid, bikemodel,age,biketype,location;
      IF done THEN
          LEAVE read_loop;
        END IF;
        SET bikekeyval = bikekeyval + 1;
        SET registeryear = SYSDATE();
        Insert into bike_dimension values(bikekeyval,bikeid,bikemodel,biketype,location,registeryear);
    END LOOP read_loop;
  CLOSE cur1;
END; //
DELIMITER;
