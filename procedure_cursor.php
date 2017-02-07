/**
 * Created by PhpStorm.
 * User: vipul
 * Date: 01-Jan-17
 * Time: 10:11 PM
 * Only supported by PHP/Mysql latest version
 */


BEGIN
 
 DECLARE v_finished INTEGER DEFAULT 0;
 DECLARE v_placeholder,v_id varchar(100) DEFAULT "";
 
 -- declare cursor for lables
 DEClARE label_cursor CURSOR FOR
    SELECT placeholder,id FROM ques_table;
 
 -- declare NOT FOUND handler
 DECLARE CONTINUE HANDLER
        FOR NOT FOUND SET v_finished = 1;
 
 OPEN label_cursor;
 
 get_label: LOOP
 
 FETCH label_cursor INTO v_placeholder,v_id;
 
 IF v_finished = 1 THEN
 LEAVE get_label;
 END IF;
 
             SET @realmID = (SELECT `label_id` from lable_table ORDER BY `label_id` desc limit 1);
            
          SET @label_id = @realmID+1;
          SET @label = v_placeholder;
      
          INSERT INTO lable_table VALUES(@label_id, @label);  
         
          UPDATE ques_table SET `label_id_placeholder`= @label_id WHERE id=v_id;
             
 END LOOP get_label;
 
 CLOSE label_cursor;
 
END