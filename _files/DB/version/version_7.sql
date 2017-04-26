/************ Remove Foreign Keys ***************/

ALTER TABLE control_weight_height DROP CONSTRAINT fk_control_weight_height_customer;



/************ Update: Tables ***************/

/******************** Rebuild Table: control_weight_height ************************
Reasons:
Column: weight
	Data type scale changed.
	Server Column: weight, DT=Numeric, L=20, COM=libras, N=false, AN=false, DF=, SC=0, SI=true, EN=, ARR=false.
	Design Column: weight, DT=Numeric, L=20, COM=libras, N=false, AN=false, DF=, SC=2, SI=true, EN=, ARR=false.
Column: height
	Data type scale changed.
	Server Column: height, DT=Numeric, L=20, COM=centimetros, N=true, AN=false, DF=, SC=0, SI=true, EN=, ARR=false.
	Design Column: height, DT=Numeric, L=20, COM=centimetros, N=false, AN=false, DF=, SC=2, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: control_weight_height */
ALTER TABLE control_weight_height RENAME TO control_weight_height_old;

/* Build Table Structure */
CREATE TABLE control_weight_height
(
	id NUMERIC(20, 0) NOT NULL,
	id_customer NUMERIC(20, 0) NOT NULL,
	weight NUMERIC(20, 2) NOT NULL,
	height NUMERIC(20, 2) NOT NULL,
	update_date TIMESTAMP NOT NULL
) WITHOUT OIDS;

/* Repopulate Table Data */
INSERT INTO control_weight_height
	 (id, id_customer, weight, height, update_date)
SELECT id, id_customer, weight, height, update_date
FROM control_weight_height_old;

/* Remove Temp Table */
DROP TABLE control_weight_height_old CASCADE;

/* Add Primary Key */
ALTER TABLE control_weight_height ADD CONSTRAINT pkcontrol_weight_height
	PRIMARY KEY (id);

/* Add Comments */
COMMENT ON COLUMN control_weight_height.weight IS 'libras';

COMMENT ON COLUMN control_weight_height.height IS 'centimetros';

/* Add Indexes */
CREATE INDEX "control_weight_height_id_Idx" ON control_weight_height USING btree (id);

CREATE INDEX "control_weight_height_id_customer_Idx" ON control_weight_height USING btree (id_customer);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_control_weight_height_customer */
ALTER TABLE control_weight_height ADD CONSTRAINT fk_control_weight_height_customer
	FOREIGN KEY (id_customer) REFERENCES customer (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;