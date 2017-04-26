/************ Remove Foreign Keys ***************/

ALTER TABLE control_weight_height DROP CONSTRAINT fk_control_weight_height_customer;



/************ Update: Tables ***************/

/******************** Update Table: control_imc ************************/

/* Remove Indexes */
DROP INDEX "control_weight_height_id_Idx";

DROP INDEX "control_weight_height_id_customer_Idx";

/* Rename: control_weight_height */
ALTER TABLE control_weight_height RENAME TO control_imc;

/* Add Indexes */
CREATE INDEX "control_imc_id_Idx" ON control_imc USING btree (id);

CREATE INDEX "control_imc_id_customer_Idx" ON control_imc USING btree (id_customer);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_control_imc_customer */
ALTER TABLE control_imc ADD CONSTRAINT fk_control_imc_customer
	FOREIGN KEY (id_customer) REFERENCES customer (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;