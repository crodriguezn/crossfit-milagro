/************ Update: Tables ***************/

/******************** Update Table: class_registration ************************/

/* Remove Indexes */
DROP INDEX "class_registration_date_registration_Idx";

ALTER TABLE class_registration ADD id_employee NUMERIC(20, 0) NULL;

/* Add Indexes */
CREATE INDEX "class_registration_date_registration_Idx" ON class_registration (date_registration);

CREATE INDEX "class_registration_id_employee_Idx" ON class_registration (id_employee);


/******************** Update Table: control_monthly ************************/

ALTER TABLE control_monthly ADD monthly_price NUMERIC(10, 2) NULL;

ALTER TABLE control_monthly ADD total NUMERIC(10, 2) NULL;


/******************** Add Table: employee ************************/

/* Build Table Structure */
CREATE TABLE employee
(
	id NUMERIC(20, 0) NOT NULL,
	id_person NUMERIC(20, 0) NOT NULL,
	date_registration TIMESTAMP NOT NULL
);

/* Add Primary Key */
ALTER TABLE employee ADD CONSTRAINT pkemployee
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "employee_id_Idx" ON employee (id);

CREATE INDEX "employee_id_person_Idx" ON employee (id_person);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_class_registration_employee */
ALTER TABLE class_registration ADD CONSTRAINT fk_class_registration_employee
	FOREIGN KEY (id_employee) REFERENCES employee (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_employee_person */
ALTER TABLE employee ADD CONSTRAINT fk_employee_person
	FOREIGN KEY (id_person) REFERENCES person (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;