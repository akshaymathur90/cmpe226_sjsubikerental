DELIMITER //

CREATE PROCEDURE create_customer_dimension()
BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE customerid INT(11);
  DECLARE name VARCHAR(100);
  DECLARE zipcode INT(11);
  DECLARE customerkeyval INT(11);
  DECLARE cur1 CURSOR FOR SELECT p.personid,p.name,a.Zipcode FROM person p,customer c, address a WHERE p.personid = c.personid and p.addressid = a.AddressID;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  OPEN cur1;

  SELECT max(customerkey) into customerkeyval from customer_dimension;

  read_loop: LOOP
      FETCH cur1 INTO customerid, name,zipcode;
      IF done THEN
          LEAVE read_loop;
        END IF;
        SET customerkeyval = customerkeyval + 1;
        Insert into customer_dimension values(customerkeyval,customerid,name,zipcode);
    END LOOP read_loop;
  CLOSE cur1;
END; //

DELIMITER;