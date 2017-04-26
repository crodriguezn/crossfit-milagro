/************ Remove Foreign Keys ***************/

ALTER TABLE company_branch DROP CONSTRAINT fk_company_branch_ciudad;

ALTER TABLE company_branch DROP CONSTRAINT fk_company_branch_company;

ALTER TABLE user_profile__company_branch DROP CONSTRAINT fk_user_profile__company_branch_company_branch;



/************ Update: Tables ***************/

/******************** Rebuild Table: company_branch ************************
Reasons:
Column: monthly_price
	Data type changed.
	Data type length changed.
	Data type scale changed.
	Server Column: monthly_price, DT=Money, L=, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: monthly_price, DT=Numeric, L=10, COM=, N=true, AN=false, DF=, SC=2, SI=true, EN=, ARR=false.
Column: daily_price
	Data type changed.
	Data type length changed.
	Data type scale changed.
	Server Column: daily_price, DT=Money, L=, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: daily_price, DT=Numeric, L=10, COM=, N=true, AN=false, DF=, SC=2, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: company_branch */
ALTER TABLE company_branch RENAME TO company_branch_old;

/* Build Table Structure */
CREATE TABLE company_branch
(
	id NUMERIC(20, 0) NOT NULL,
	id_company NUMERIC(20, 0) NOT NULL,
	name VARCHAR(150) NOT NULL,
	address TEXT NULL,
	phone VARCHAR(150) NULL,
	"isActive" SMALLINT NOT NULL,
	id_ciudad NUMERIC(20, 0) NULL,
	monthly_price NUMERIC(10, 2) NULL,
	daily_price NUMERIC(10, 2) NULL
) WITHOUT OIDS;

/* Repopulate Table Data */
INSERT INTO company_branch
	 (id, id_company, name, address, phone, "isActive", id_ciudad, monthly_price, daily_price)
SELECT id, id_company, name, address, phone, "isActive", id_ciudad, monthly_price, daily_price
FROM company_branch_old;

/* Remove Temp Table */
DROP TABLE company_branch_old CASCADE;

/* Add Primary Key */
ALTER TABLE company_branch ADD CONSTRAINT pkcompany_branch
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "company_branch_id_Idx" ON company_branch USING btree (id);

CREATE INDEX "company_branch_id_ciudad_Idx" ON company_branch USING btree (id_ciudad);

CREATE UNIQUE INDEX "company_branch_name_Idx" ON company_branch USING btree (name);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_company_branch_ciudad */
ALTER TABLE company_branch ADD CONSTRAINT fk_company_branch_ciudad
	FOREIGN KEY (id_ciudad) REFERENCES ciudad (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_company_branch_company */
ALTER TABLE company_branch ADD CONSTRAINT fk_company_branch_company
	FOREIGN KEY (id_company) REFERENCES company (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_user_profile__company_branch_company_branch */
ALTER TABLE user_profile__company_branch ADD CONSTRAINT fk_user_profile__company_branch_company_branch
	FOREIGN KEY (id_company_branch) REFERENCES company_branch (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;