DELIMITER //

CREATE PROCEDURE create_bookings_fact()
BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE bookingidval INT(11);
  DECLARE bikekeyval INT(11);
  DECLARE bookingbikeid INT(11);
  DECLARE calendarkeyval INT(11);
  DECLARE customerkeyval INT(11);
  DECLARE daysbookedfor INT(11);
  DECLARE priceperhour INT(11);
  DECLARE bookingkeyval,dayofmonth,quarter,yearval INT(11);
  DECLARE personid INT(11);
  DECLARE currentDate,fulldateval DATE;
  DECLARE dayofweek,monthval VARCHAR(100);

  DECLARE cur1 CURSOR FOR SELECT b.booking_id, DATEDIFF(b.end_time,b.start_time), b.personid from booking b, contains c, bike bk where b.booking_id = c.booking_id and c.BikeID = bk.BikeID GROUP BY b.booking_id,b.start_time, b.end_time, b.personid;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  OPEN cur1;

  SELECT max(bookingid) into bookingkeyval from booking_fact;
  SELECT max(calendarkey) into calendarkeyval from calendar_dimension;

  SET calendarkeyval = calendarkeyval + 1;
  SET currentDate = SYSDATE();
  Select Date(currentDate) into fulldateval;
  Select DAYNAME(currentDate) into dayofweek;
  Select DAY(currentDate) into dayofmonth;
  Select MONTHNAME(currentDate) into monthval;
  Select QUARTER(currentDate) into quarter;
  Select YEAR(currentDate) into yearval;
  Insert into calendar_dimension values(calendarkeyval,fulldateval,dayofweek,dayofmonth,monthval,quarter,yearval);


  read_loop: LOOP
      FETCH cur1 INTO bookingidval,daysbookedfor,personid;
      IF done THEN
          LEAVE read_loop;
      END IF;
      SELECT customerkey into customerkeyval from customer_dimension where customerid = personid limit 1;
      SELECT bikeid into bookingbikeid from contains where booking_id = bookingidval limit 1;
      SELECT bikekey into bikekeyval from bike_dimension where bikeid = bookingbikeid limit 1;
      SET bookingkeyval = bookingkeyval + 1;
      

      Insert into booking_fact values(bookingkeyval,calendarkeyval,customerkeyval,bikekeyval,daysbookedfor,10);
  END LOOP read_loop;
  CLOSE cur1;
END; //
DELIMITER;