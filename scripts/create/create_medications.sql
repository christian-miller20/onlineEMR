drop table medications cascade constraints;

create table medications(
    patient_id number
        constraint med_patient_id_fk references patients (patient_id),
    medication varchar(50),
    active char(5),         -- Store 'Yes' or 'No'
    constraint medications_pk primary key (patient_id, medication)
);