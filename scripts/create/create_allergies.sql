drop table allergies cascade constraints;

create table allergies (
    patient_id number
        constraint all_patient_id_fk references patients (patient_id),
    allergy varchar(50),
    constraint allergies_pk primary key (patient_id, condition)
);