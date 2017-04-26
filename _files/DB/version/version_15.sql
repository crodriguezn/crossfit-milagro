/************ Remove Foreign Keys ***************/

ALTER TABLE control_monthly DROP CONSTRAINT fk_control_monthly_customer;



/************ Update: Tables ***************/

/******************** Rebuild Table: control_monthly ************************
Reasons:
Column: start_date
	Data type changed.
	Server Column: start_date, DT=TimeStamp, L=, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: start_date, DT=Date, L=, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
Column: final_date
	Data type changed.
	Server Column: final_date, DT=TimeStamp, L=, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: final_date, DT=Date, L=, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: control_monthly */
ALTER TABLE control_monthly RENAME TO control_monthly_old;

/* Build Table Structure */
CREATE TABLE control_monthly
(
	id NUMERIC(20, 0) NOT NULL,
	id_customer NUMERIC(20, 0) NOT NULL,
	start_date DATE NOT NULL,
	final_date DATE NOT NULL,
	"isActive" SMALLINT NOT NULL,
	date_registration TIMESTAMP NOT NULL
);

/* Repopulate Table Data */
INSERT INTO control_monthly
	 (id, start_date, final_date, id_customer)
SELECT id, start_date, final_date, id_customer
FROM control_monthly_old;

/* Remove Temp Table */
DROP TABLE control_monthly_old CASCADE;

/* Add Primary Key */
ALTER TABLE control_monthly ADD CONSTRAINT pkcontrol_monthly
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "control_monthly_date_registration_Idx" ON control_monthly (date_registration);

CREATE INDEX "control_monthly_id_Idx" ON control_monthly (id);

CREATE INDEX "control_monthly_id_customer_Idx" ON control_monthly (id_customer);

CREATE UNIQUE INDEX "control_monthly_id_customer_start_date_final_date_Idx" ON control_monthly (id_customer, start_date, final_date);


/******************** Add Table: detail_invoce ************************/

/* Build Table Structure */
CREATE TABLE detail_invoce
(
	id NUMERIC(20, 0) NOT NULL,
	id_head_invoce NUMERIC(20, 0) NOT NULL,
	id_product NUMERIC(20, 0) NOT NULL,
	price NUMERIC(10, 2) NOT NULL,
	quantity INTEGER NOT NULL,
	sub_total NUMERIC(10, 2) NOT NULL
);

/* Add Primary Key */
ALTER TABLE detail_invoce ADD CONSTRAINT pkdetail_invoce
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "detail_invoce_id_Idx" ON detail_invoce (id);

CREATE INDEX "detail_invoce_id_head_invoce_Idx" ON detail_invoce (id_head_invoce);

CREATE INDEX "detail_invoce_id_product_Idx" ON detail_invoce (id_product);


/******************** Add Table: head_invoce ************************/

/* Build Table Structure */
CREATE TABLE head_invoce
(
	id NUMERIC(20, 0) NOT NULL,
	invoce_date TIMESTAMP NOT NULL,
	id_customer NUMERIC(20, 0) NOT NULL,
	id_employee NUMERIC(20, 0) NOT NULL,
	total NUMERIC(10, 2) NOT NULL
);

/* Add Primary Key */
ALTER TABLE head_invoce ADD CONSTRAINT pkhead_invoce
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "head_invoce_id_Idx" ON head_invoce (id);

CREATE INDEX "head_invoce_id_customer_Idx" ON head_invoce (id_customer);

CREATE INDEX "head_invoce_id_employee_Idx" ON head_invoce (id_employee);

CREATE INDEX "head_invoce_invoce_date_Idx" ON head_invoce (invoce_date);


/******************** Add Table: product ************************/

/* Build Table Structure */
CREATE TABLE product
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(50) NOT NULL,
	sale_price NUMERIC(10, 2) NOT NULL,
	quantity INTEGER NOT NULL,
	descripcion VARCHAR(150) NULL,
	"isValidateQuantity" SMALLINT NOT NULL,
	"isEditable" SMALLINT NOT NULL
);

/* Add Primary Key */
ALTER TABLE product ADD CONSTRAINT pkproduct
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "product_id_Idx" ON product (id);

CREATE UNIQUE INDEX "product_name_Idx" ON product (name);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_control_monthly_customer */
ALTER TABLE control_monthly ADD CONSTRAINT fk_control_monthly_customer
	FOREIGN KEY (id_customer) REFERENCES customer (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_detail_invoce_head_invoce */
ALTER TABLE detail_invoce ADD CONSTRAINT fk_detail_invoce_head_invoce
	FOREIGN KEY (id_head_invoce) REFERENCES head_invoce (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_detail_invoce_product */
ALTER TABLE detail_invoce ADD CONSTRAINT fk_detail_invoce_product
	FOREIGN KEY (id_product) REFERENCES product (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_head_invoce_customer */
ALTER TABLE head_invoce ADD CONSTRAINT fk_head_invoce_customer
	FOREIGN KEY (id_customer) REFERENCES customer (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_head_invoce_employee */
ALTER TABLE head_invoce ADD CONSTRAINT fk_head_invoce_employee
	FOREIGN KEY (id_employee) REFERENCES employee (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;