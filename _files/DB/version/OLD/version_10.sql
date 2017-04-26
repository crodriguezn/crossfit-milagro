/************ Update: Tables ***************/

/******************** Rebuild Table: configuration_system ************************
Reasons:
Column: logo
	Data type length changed.
	Server Column: logo, DT=VarChar, L=250, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: logo, DT=VarChar, L=450, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: configuration_system */
ALTER TABLE configuration_system RENAME TO configuration_system_old;

/* Build Table Structure */
CREATE TABLE configuration_system
(
	id NUMERIC(20, 0) NOT NULL,
	name_system VARCHAR(250) NOT NULL,
	logo VARCHAR(450) NULL,
	session_time_limit_min NUMERIC(20, 0) NULL,
	session_time_limit_max NUMERIC(20, 0) NULL,
	"isSaveBinnacle" SMALLINT NULL
) WITHOUT OIDS;

/* Repopulate Table Data */
INSERT INTO configuration_system
	 (id, name_system, logo, session_time_limit_min, session_time_limit_max, "isSaveBinnacle")
SELECT id, name_system, logo, session_time_limit_min, session_time_limit_max, "isSaveBinnacle"
FROM configuration_system_old;

/* Remove Temp Table */
DROP TABLE configuration_system_old CASCADE;

/* Add Primary Key */
ALTER TABLE configuration_system ADD CONSTRAINT pkconfiguration_system
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "configuration_system_id_Idx" ON configuration_system USING btree (id);

CREATE INDEX "configuration_system_name_system_Idx" ON configuration_system USING btree (name_system);