/************ Remove Foreign Keys ***************/

ALTER TABLE catalog DROP CONSTRAINT catalog_id_catalog_type_fkey;

ALTER TABLE company_branch DROP CONSTRAINT company_branch_id_ciudad_fkey;

ALTER TABLE company_branch DROP CONSTRAINT company_branch_id_company_fkey;

ALTER TABLE module DROP CONSTRAINT module_id_parent_fkey;

ALTER TABLE permission DROP CONSTRAINT permission_id_module_fkey;

ALTER TABLE person DROP CONSTRAINT person_id_ciudad_fkey;

ALTER TABLE profile DROP CONSTRAINT profile_id_rol_fkey;

ALTER TABLE profile_permission DROP CONSTRAINT profile_permission_id_permission_fkey;

ALTER TABLE profile_permission DROP CONSTRAINT profile_permission_id_profile_fkey;

ALTER TABLE rol_module DROP CONSTRAINT rol_module_id_module_fkey;

ALTER TABLE rol_module DROP CONSTRAINT rol_module_id_rol_fkey;

ALTER TABLE session_activity DROP CONSTRAINT session_activity_id_user_profile_fkey;

ALTER TABLE "user" DROP CONSTRAINT user_id_person_fkey;

ALTER TABLE user_log DROP CONSTRAINT user_log_id_user_fkey;

ALTER TABLE user_profile DROP CONSTRAINT user_profile_id_profile_fkey;

ALTER TABLE user_profile DROP CONSTRAINT user_profile_id_user_fkey;

ALTER TABLE user_profile__company_branch DROP CONSTRAINT user_profile__company_branch_id_company_branch_fkey;

ALTER TABLE user_profile__company_branch DROP CONSTRAINT user_profile__company_branch_id_user_profile_fkey;



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





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_catalog_catalog_type */
ALTER TABLE catalog ADD CONSTRAINT fk_catalog_catalog_type
	FOREIGN KEY (id_catalog_type) REFERENCES catalog_type (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_company_branch_ciudad */
ALTER TABLE company_branch ADD CONSTRAINT fk_company_branch_ciudad
	FOREIGN KEY (id_ciudad) REFERENCES ciudad (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_company_branch_company */
ALTER TABLE company_branch ADD CONSTRAINT fk_company_branch_company
	FOREIGN KEY (id_company) REFERENCES company (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_module_module */
ALTER TABLE module ADD CONSTRAINT fk_module_module
	FOREIGN KEY (id_parent) REFERENCES module (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_permission_module */
ALTER TABLE permission ADD CONSTRAINT fk_permission_module
	FOREIGN KEY (id_module) REFERENCES module (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_person_ciudad */
ALTER TABLE person ADD CONSTRAINT fk_person_ciudad
	FOREIGN KEY (id_ciudad) REFERENCES ciudad (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_profile_rol */
ALTER TABLE profile ADD CONSTRAINT fk_profile_rol
	FOREIGN KEY (id_rol) REFERENCES rol (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_profile_permission_permission */
ALTER TABLE profile_permission ADD CONSTRAINT fk_profile_permission_permission
	FOREIGN KEY (id_permission) REFERENCES permission (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_profile_permission_profile */
ALTER TABLE profile_permission ADD CONSTRAINT fk_profile_permission_profile
	FOREIGN KEY (id_profile) REFERENCES profile (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_rol_module_module */
ALTER TABLE rol_module ADD CONSTRAINT fk_rol_module_module
	FOREIGN KEY (id_module) REFERENCES module (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_rol_module_rol */
ALTER TABLE rol_module ADD CONSTRAINT fk_rol_module_rol
	FOREIGN KEY (id_rol) REFERENCES rol (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_session_activity_user_profile */
ALTER TABLE session_activity ADD CONSTRAINT fk_session_activity_user_profile
	FOREIGN KEY (id_user_profile) REFERENCES user_profile (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_user_person */
ALTER TABLE "user" ADD CONSTRAINT fk_user_person
	FOREIGN KEY (id_person) REFERENCES person (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_user_log_user */
ALTER TABLE user_log ADD CONSTRAINT fk_user_log_user
	FOREIGN KEY (id_user) REFERENCES "user" (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_user_profile_profile */
ALTER TABLE user_profile ADD CONSTRAINT fk_user_profile_profile
	FOREIGN KEY (id_profile) REFERENCES profile (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_user_profile_user */
ALTER TABLE user_profile ADD CONSTRAINT fk_user_profile_user
	FOREIGN KEY (id_user) REFERENCES "user" (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_user_profile__company_branch_company_branch */
ALTER TABLE user_profile__company_branch ADD CONSTRAINT fk_user_profile__company_branch_company_branch
	FOREIGN KEY (id_company_branch) REFERENCES company_branch (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_user_profile__company_branch_user_profile */
ALTER TABLE user_profile__company_branch ADD CONSTRAINT fk_user_profile__company_branch_user_profile
	FOREIGN KEY (id_user_profile) REFERENCES user_profile (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;