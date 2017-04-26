/************ Update: Tables ***************/

/******************** Add Table: class_registration ************************/

/* Build Table Structure */
CREATE TABLE class_registration
(
	id NUMERIC(20, 0) NOT NULL,
	id_schedule NUMERIC(20, 0) NOT NULL,
	id_customer NUMERIC(20, 0) NOT NULL,
	date_registration TIMESTAMP NOT NULL
);

/* Add Primary Key */
ALTER TABLE class_registration ADD CONSTRAINT pkclass_registration
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "class_registration_date_registration_Idx" ON class_registration (date_registration);

CREATE INDEX "class_registration_id_Idx" ON class_registration (id);

CREATE INDEX "class_registration_id_customer_Idx" ON class_registration (id_customer);

CREATE INDEX "class_registration_id_schedule_Idx" ON class_registration (id_schedule);


/******************** Add Table: control_weight_height ************************/

/* Build Table Structure */
CREATE TABLE control_weight_height
(
	id NUMERIC(20, 0) NOT NULL,
	id_customer NUMERIC(20, 0) NOT NULL,
	weight NUMERIC(20, 0) NOT NULL,
	height NUMERIC(20, 0) NULL,
	update_date TIMESTAMP NOT NULL
);

/* Add Primary Key */
ALTER TABLE control_weight_height ADD CONSTRAINT pkcontrol_weight_height
	PRIMARY KEY (id);

/* Add Comments */
COMMENT ON COLUMN control_weight_height.weight IS 'libras';

COMMENT ON COLUMN control_weight_height.height IS 'centimetros';

/* Add Indexes */
CREATE INDEX "control_weight_height_id_Idx" ON control_weight_height (id);

CREATE INDEX "control_weight_height_id_customer_Idx" ON control_weight_height (id_customer);


/******************** Add Table: customer ************************/

/* Build Table Structure */
CREATE TABLE customer
(
	id NUMERIC(20, 0) NOT NULL,
	id_person NUMERIC(20, 0) NOT NULL,
	"code" VARCHAR(50) NOT NULL,
	registration_date TIMESTAMP NOT NULL
);

/* Add Primary Key */
ALTER TABLE customer ADD CONSTRAINT pkcustomer
	PRIMARY KEY (id);

/* Add Indexes */
CREATE UNIQUE INDEX "customer_code_Idx" ON customer ("code");

CREATE INDEX "customer_id_Idx" ON customer (id);

CREATE INDEX "customer_id_person_Idx" ON customer (id_person);


/******************** Add Table: schedule ************************/

/* Build Table Structure */
CREATE TABLE schedule
(
	id NUMERIC(20, 0) NOT NULL,
	start_time VARCHAR(25) NOT NULL,
	final_hour VARCHAR(25) NOT NULL,
	"isActive" SMALLINT NOT NULL
);

/* Add Primary Key */
ALTER TABLE schedule ADD CONSTRAINT pkschedule
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "schedule_id_Idx" ON schedule (id);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_class_registration_customer */
ALTER TABLE class_registration ADD CONSTRAINT fk_class_registration_customer
	FOREIGN KEY (id_customer) REFERENCES customer (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_class_registration_schedule */
ALTER TABLE class_registration ADD CONSTRAINT fk_class_registration_schedule
	FOREIGN KEY (id_schedule) REFERENCES schedule (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_control_weight_height_customer */
ALTER TABLE control_weight_height ADD CONSTRAINT fk_control_weight_height_customer
	FOREIGN KEY (id_customer) REFERENCES customer (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_customer_person */
ALTER TABLE customer ADD CONSTRAINT fk_customer_person
	FOREIGN KEY (id_person) REFERENCES person (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;