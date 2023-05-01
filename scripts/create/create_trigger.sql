drop sequence patient_id_seq;
create sequence patient_id_seq
    start with 100
    increment by 1;

create or replace trigger patient_on_insert
    before insert on patients 
    for each row
begin
    select patient_id_seq.nextval
    into :new.patient_id
    from dual;
end;
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