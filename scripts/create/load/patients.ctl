load data infile 'data/patients.csv'
insert into table patients
fields terminated by ','
(patient_id,first_name,last_name,dob date "YYYY-MM-DD",gender,race,pref_language,phone,street1,street2,city,state,zip)