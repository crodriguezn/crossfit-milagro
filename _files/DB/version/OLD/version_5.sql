/************ Remove Foreign Keys ***************/

ALTER TABLE ciudad DROP CONSTRAINT ciudad_id_pais_fkey;

ALTER TABLE ciudad DROP CONSTRAINT ciudad_id_provincia_fkey;

ALTER TABLE provincia DROP CONSTRAINT provincia_id_pais_fkey;



/************ Update: Tables ***************/

/******************** Rebuild Table: ciudad ************************
Reasons:
Column: id
	Data type changed.
	Data type length changed.
	Data type scale changed.
	Server Column: id, DT=Integer, L=, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: id, DT=Numeric, L=20, COM=, N=false, AN=false, DF=, SC=0, SI=true, EN=, ARR=false.
Column: id_pais
	Data type changed.
	Data type length changed.
	Data type scale changed.
	Server Column: id_pais, DT=Integer, L=, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: id_pais, DT=Numeric, L=20, COM=, N=true, AN=false, DF=, SC=0, SI=true, EN=, ARR=false.
Column: id_provincia
	Data type changed.
	Data type length changed.
	Data type scale changed.
	Server Column: id_provincia, DT=Integer, L=, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: id_provincia, DT=Numeric, L=20, COM=, N=true, AN=false, DF=, SC=0, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: ciudad */
ALTER TABLE ciudad RENAME TO ciudad_old;

/* Build Table Structure */
CREATE TABLE ciudad
(
	id NUMERIC(20, 0) NOT NULL,
	id_pais NUMERIC(20, 0) NULL,
	id_provincia NUMERIC(20, 0) NULL,
	nombre VARCHAR(255) NULL,
	"Latitude" VARCHAR(255) NULL,
	"Longitude" VARCHAR(255) NULL,
	"TimeZone" VARCHAR(255) NULL,
	"DmaId" VARCHAR(255) NULL,
	"Code" VARCHAR(255) NULL
) WITHOUT OIDS;

/* Repopulate Table Data */
INSERT INTO ciudad
	 (id, id_pais, id_provincia, nombre, "Latitude", "Longitude", "TimeZone", "DmaId", "Code")
SELECT id, id_pais, id_provincia, nombre, "Latitude", "Longitude", "TimeZone", "DmaId", "Code"
FROM ciudad_old;

/* Remove Temp Table */
DROP TABLE ciudad_old CASCADE;

/* Add Primary Key */
ALTER TABLE ciudad ADD CONSTRAINT ciudad_pkey
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "ciudad_id_Idx" ON ciudad (id);

CREATE INDEX "ciudad_id_pais_Idx" ON ciudad (id_pais);

CREATE INDEX "ciudad_id_provincia_Idx" ON ciudad (id_provincia);

CREATE INDEX "ciudad_nombre_Idx" ON ciudad (nombre);


/******************** Rebuild Table: pais ************************
Reasons:
Column: id
	Data type changed.
	Data type length changed.
	Data type scale changed.
	Server Column: id, DT=Integer, L=, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: id, DT=Numeric, L=20, COM=, N=false, AN=false, DF=, SC=0, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: pais */
ALTER TABLE pais RENAME TO pais_old;

/* Build Table Structure */
CREATE TABLE pais
(
	id NUMERIC(20, 0) NOT NULL,
	nombre VARCHAR(255) NULL,
	"FIPS104" VARCHAR(255) NULL,
	"ISO2" VARCHAR(255) NULL,
	"ISO3" VARCHAR(255) NULL,
	"ISON" VARCHAR(255) NULL,
	"Internet" VARCHAR(255) NULL,
	"Capital" VARCHAR(255) NULL,
	"MapReference" VARCHAR(255) NULL,
	"NationalitySingular" VARCHAR(255) NULL,
	"NationalityPlural" VARCHAR(255) NULL,
	"Currency" VARCHAR(255) NULL,
	"CurrencyCode" VARCHAR(255) NULL,
	"Population" VARCHAR(255) NULL,
	"Title" VARCHAR(255) NULL,
	"Comment" VARCHAR(255) NULL
) WITHOUT OIDS;

/* Repopulate Table Data */
INSERT INTO pais
	 (id, nombre, "FIPS104", "ISO2", "ISO3", "ISON", "Internet", "Capital", "MapReference", "NationalitySingular", "NationalityPlural", "Currency", "CurrencyCode", "Population", "Title", "Comment")
SELECT id, nombre, "FIPS104", "ISO2", "ISO3", "ISON", "Internet", "Capital", "MapReference", "NationalitySingular", "NationalityPlural", "Currency", "CurrencyCode", "Population", "Title", "Comment"
FROM pais_old;

/* Remove Temp Table */
DROP TABLE pais_old CASCADE;

/* Add Primary Key */
ALTER TABLE pais ADD CONSTRAINT pais_pkey
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "pais_id_Idx" ON pais (id);

CREATE INDEX "pais_nombre_Idx" ON pais (nombre);


/******************** Update Table: person ************************/

ALTER TABLE person ADD id_ciudad NUMERIC(20, 0) NULL;


/******************** Rebuild Table: provincia ************************
Reasons:
Column: id
	Data type changed.
	Data type length changed.
	Data type scale changed.
	Server Column: id, DT=Integer, L=, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: id, DT=Numeric, L=20, COM=, N=false, AN=false, DF=, SC=0, SI=true, EN=, ARR=false.
Column: id_pais
	Data type changed.
	Data type length changed.
	Data type scale changed.
	Server Column: id_pais, DT=Integer, L=, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: id_pais, DT=Numeric, L=20, COM=, N=true, AN=false, DF=, SC=0, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: provincia */
ALTER TABLE provincia RENAME TO provincia_old;

/* Build Table Structure */
CREATE TABLE provincia
(
	id NUMERIC(20, 0) NOT NULL,
	id_pais NUMERIC(20, 0) NULL,
	nombre VARCHAR(255) NULL,
	"Code" VARCHAR(255) NULL,
	"ADM1Code" VARCHAR(255) NULL
) WITHOUT OIDS;

/* Repopulate Table Data */
INSERT INTO provincia
	 (id, id_pais, nombre, "Code", "ADM1Code")
SELECT id, id_pais, nombre, "Code", "ADM1Code"
FROM provincia_old;

/* Remove Temp Table */
DROP TABLE provincia_old CASCADE;

/* Add Primary Key */
ALTER TABLE provincia ADD CONSTRAINT provincia_pkey
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "provincia_id_Idx" ON provincia (id);

CREATE INDEX "provincia_id_pais_Idx" ON provincia (id_pais);

CREATE INDEX "provincia_nombre_Idx" ON provincia (nombre);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: ciudad_id_pais_fkey */
ALTER TABLE ciudad ADD CONSTRAINT ciudad_id_pais_fkey
	FOREIGN KEY (id_pais) REFERENCES pais (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: ciudad_id_provincia_fkey */
ALTER TABLE ciudad ADD CONSTRAINT ciudad_id_provincia_fkey
	FOREIGN KEY (id_provincia) REFERENCES provincia (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_person_ciudad */
ALTER TABLE person ADD CONSTRAINT fk_person_ciudad
	FOREIGN KEY (id_ciudad) REFERENCES ciudad (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: provincia_id_pais_fkey */
ALTER TABLE provincia ADD CONSTRAINT provincia_id_pais_fkey
	FOREIGN KEY (id_pais) REFERENCES pais (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;