drop sequence patient_id_seq;
create sequence patient_id_seq
    start with 100
    increment by 1;

CREATE OR REPLACE TRIGGER patient_on_insert
BEFORE INSERT ON patients 
FOR EACH ROW
BEGIN
    IF :new.patient_id IS NULL THEN
        SELECT patient_id_seq.nextval
        INTO :new.patient_id
        FROM dual;
    END IF;
END;
/

drop sequence treatment_id_seq;
create sequence treatment_id_seq
    start with 100
    increment by 1;

create or replace trigger treatment_on_insert
    before insert on treatments 
    for each row
begin
    select treatment_id_seq.nextval
    into :new.treatment_id
    from dual;
end;
/