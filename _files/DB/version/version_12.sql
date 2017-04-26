/************ Update: Tables ***************/

/******************** Update Table: company_branch ************************/

ALTER TABLE company_branch ADD monthly_price MONEY NULL;

ALTER TABLE company_branch ADD daily_price MONEY NULL;


/******************** Add Table: control_monthly ************************/

/* Build Table Structure */
CREATE TABLE control_monthly
(
	id NUMERIC(20, 0) NOT NULL,
	start_date TIMESTAMP NOT NULL,
	final_date TIMESTAMP NOT NULL,
	id_customer NUMERIC(20, 0) NOT NULL
);

/* Add Primary Key */
ALTER TABLE control_monthly ADD CONSTRAINT pkcontrol_monthly
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "control_monthly_id_Idx" ON control_monthly (id);

CREATE INDEX "control_monthly_id_customer_Idx" ON control_monthly (id_customer);

CREATE UNIQUE INDEX "control_monthly_start_date_final_date_Idx" ON control_monthly (start_date, final_date);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_control_monthly_customer */
ALTER TABLE control_monthly ADD CONSTRAINT fk_control_monthly_customer
	FOREIGN KEY (id_customer) REFERENCES customer (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;