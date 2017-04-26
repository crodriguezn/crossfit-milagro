/************ Update: Tables ***************/

/******************** Update Table: company_branch ************************/

ALTER TABLE company_branch ADD id_ciudad NUMERIC(20, 0) NULL;

/* Add Indexes */
CREATE INDEX "company_branch_id_ciudad_Idx" ON company_branch (id_ciudad);


/******************** Update Table: person ************************/

/* Add Indexes */
CREATE INDEX "person_document_Idx" ON person (document);

CREATE INDEX "person_id_ciudad_Idx" ON person (id_ciudad);

CREATE INDEX "person_surname_Idx" ON person (surname);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_company_branch_ciudad */
ALTER TABLE company_branch ADD CONSTRAINT fk_company_branch_ciudad
	FOREIGN KEY (id_ciudad) REFERENCES ciudad (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;