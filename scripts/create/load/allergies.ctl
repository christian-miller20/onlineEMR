load data infile 'data/allergies.csv'
insert into table allergies
fields terminated by ','
(patient_id,allergy)