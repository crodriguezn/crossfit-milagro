/************ Update: Tables ***************/

/******************** Add Table: app_version ************************/

/* Build Table Structure */
CREATE TABLE app_version
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(50) NOT NULL,
	name_key VARCHAR(50) NOT NULL,
	update_time TIMESTAMP NOT NULL,
	"isActive" SMALLINT NOT NULL,
	"isDataBase" SMALLINT NOT NULL,
	"isProject" SMALLINT NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE app_version ADD CONSTRAINT pkapp_version
	PRIMARY KEY (id);

/* Add Indexes */
CREATE UNIQUE INDEX "app_version_id_Idx" ON app_version USING btree (id);


/******************** Add Table: catalog ************************/

/* Build Table Structure */
CREATE TABLE catalog
(
	id NUMERIC(20, 0) NOT NULL,
	id_catalog_type NUMERIC(20, 0) NOT NULL,
	name VARCHAR(150) NOT NULL,
	"code" VARCHAR(50) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE catalog ADD CONSTRAINT pkcatalog
	PRIMARY KEY (id);

/* Add Indexes */
CREATE UNIQUE INDEX "catalog_code_Idx" ON catalog USING btree ("code");

CREATE INDEX "catalog_id_Idx" ON catalog USING btree (id);

CREATE INDEX "catalog_id_catalog_type_Idx" ON catalog USING btree (id_catalog_type);


/******************** Add Table: catalog_type ************************/

/* Build Table Structure */
CREATE TABLE catalog_type
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(150) NOT NULL,
	"code" VARCHAR(50) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE catalog_type ADD CONSTRAINT pkcatalog_type
	PRIMARY KEY (id);

/* Add Indexes */
CREATE UNIQUE INDEX "catalog_type_code_Idx" ON catalog_type USING btree ("code");

CREATE INDEX "catalog_type_id_Idx" ON catalog_type USING btree (id);


/******************** Add Table: company ************************/

/* Build Table Structure */
CREATE TABLE company
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(150) NOT NULL,
	name_key VARCHAR(50) NOT NULL,
	description TEXT NULL,
	phone VARCHAR(150) NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE company ADD CONSTRAINT pkcompany
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "company_id_Idx" ON company USING btree (id);

CREATE UNIQUE INDEX "company_name_Idx" ON company USING btree (name);

CREATE UNIQUE INDEX "company_name_key_Idx" ON company USING btree (name_key);


/******************** Add Table: company_branch ************************/

/* Build Table Structure */
CREATE TABLE company_branch
(
	id NUMERIC(20, 0) NOT NULL,
	id_company NUMERIC(20, 0) NOT NULL,
	name VARCHAR(150) NOT NULL,
	address TEXT NULL,
	phone VARCHAR(150) NULL,
	"isActive" SMALLINT NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE company_branch ADD CONSTRAINT pkcompany_branch
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "company_branch_id_Idx" ON company_branch USING btree (id);

CREATE UNIQUE INDEX "company_branch_name_Idx" ON company_branch USING btree (name);


/******************** Add Table: configuration_system ************************/

/* Build Table Structure */
CREATE TABLE configuration_system
(
	id NUMERIC(20, 0) NOT NULL,
	name_system VARCHAR(250) NOT NULL,
	favicon VARCHAR(250) NULL,
	logo VARCHAR(250) NULL,
	session_time_limit_min NUMERIC(20, 0) NULL,
	session_time_limit_max NUMERIC(20, 0) NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE configuration_system ADD CONSTRAINT pkconfiguration_system
	PRIMARY KEY (id);


/******************** Add Table: module ************************/

/* Build Table Structure */
CREATE TABLE module
(
	id NUMERIC(20, 0) NOT NULL,
	id_parent NUMERIC(20, 0) NULL,
	name VARCHAR(50) NOT NULL,
	description VARCHAR(100) NOT NULL,
	name_key VARCHAR(50) NOT NULL,
	num_order SMALLINT NOT NULL,
	"isAdmin" SMALLINT NOT NULL,
	"isActive" SMALLINT NOT NULL,
	name_icon VARCHAR(100) NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE module ADD CONSTRAINT pkmodule
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "module_id_Idx" ON module USING btree (id);

CREATE INDEX "module_id_parent_Idx" ON module USING btree (id_parent);

CREATE UNIQUE INDEX "module_name_Idx" ON module USING btree (name);

CREATE UNIQUE INDEX "module_name_key_Idx" ON module USING btree (name_key);


/******************** Add Table: permission ************************/

/* Build Table Structure */
CREATE TABLE permission
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(50) NOT NULL,
	description VARCHAR(100) NOT NULL,
	name_key VARCHAR(50) NOT NULL,
	id_module NUMERIC(20, 0) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE permission ADD CONSTRAINT pkpermission
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "permission_id_Idx" ON permission USING btree (id);

CREATE INDEX "permission_id_module_Idx" ON permission USING btree (id_module);

CREATE INDEX "permission_name_Idx" ON permission USING btree (name);

CREATE INDEX "permission_name_key_Idx" ON permission USING btree (name_key);


/******************** Add Table: person ************************/

/* Build Table Structure */
CREATE TABLE person
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(100) NOT NULL,
	surname VARCHAR(100) NOT NULL,
	tipo_documento VARCHAR(50) NOT NULL,
	document VARCHAR(20) NOT NULL,
	birthday DATE NOT NULL,
	gender VARCHAR(50) NOT NULL,
	address TEXT NULL,
	phone_cell VARCHAR(80) NULL,
	email VARCHAR(100) NOT NULL,
	estado_civil VARCHAR(50) NOT NULL,
	tipo_sangre VARCHAR(50) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE person ADD CONSTRAINT pkperson
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "person_id_Idx" ON person USING btree (id);


/******************** Add Table: profile ************************/

/* Build Table Structure */
CREATE TABLE profile
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(100) NOT NULL,
	description VARCHAR(150) NULL,
	"isAdmin" SMALLINT NOT NULL,
	"isSuperAdmin" SMALLINT NOT NULL,
	"isActive" SMALLINT NOT NULL,
	"isEditable" SMALLINT NOT NULL,
	id_rol NUMERIC(20, 0) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE profile ADD CONSTRAINT pkprofile
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "profile_id_Idx" ON profile USING btree (id);

CREATE INDEX "profile_id_rol_Idx" ON profile USING btree (id_rol);

CREATE UNIQUE INDEX "profile_name_Idx" ON profile USING btree (name);


/******************** Add Table: profile_permission ************************/

/* Build Table Structure */
CREATE TABLE profile_permission
(
	id NUMERIC(20, 0) NOT NULL,
	id_profile NUMERIC(20, 0) NOT NULL,
	id_permission NUMERIC(20, 0) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE profile_permission ADD CONSTRAINT pkprofile_permission
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "profile_permission_id_Idx" ON profile_permission USING btree (id);

CREATE INDEX "profile_permission_id_permission_Idx" ON profile_permission USING btree (id_permission);

CREATE INDEX "profile_permission_id_profile_Idx" ON profile_permission USING btree (id_profile);


/******************** Add Table: rol ************************/

/* Build Table Structure */
CREATE TABLE rol
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(100) NOT NULL,
	name_key VARCHAR(100) NOT NULL,
	"isEditable" SMALLINT NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE rol ADD CONSTRAINT pkrol
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "rol_id_Idx" ON rol USING btree (id);

CREATE UNIQUE INDEX "rol_name_Idx" ON rol USING btree (name);

CREATE UNIQUE INDEX "rol_name_key_Idx" ON rol USING btree (name_key);


/******************** Add Table: rol_module ************************/

/* Build Table Structure */
CREATE TABLE rol_module
(
	id NUMERIC(20, 0) NOT NULL,
	id_rol NUMERIC(20, 0) NOT NULL,
	id_module NUMERIC(20, 0) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE rol_module ADD CONSTRAINT pkrol_module
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "rol_module_id_Idx" ON rol_module USING btree (id);

CREATE INDEX "rol_module_id_module_Idx" ON rol_module USING btree (id_module);

CREATE INDEX "rol_module_id_rol_Idx" ON rol_module USING btree (id_rol);


/******************** Add Table: session_activity ************************/

/* Build Table Structure */
CREATE TABLE session_activity
(
	id NUMERIC(20, 0) NOT NULL,
	id_user_profile NUMERIC(20, 0) NULL,
	session_id VARCHAR(150) NOT NULL,
	last_activity TIMESTAMP NULL,
	"inUse" NUMERIC(20, 0) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE session_activity ADD CONSTRAINT pksession_activity
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "session_activity_id_Idx" ON session_activity USING btree (id);

CREATE INDEX "session_activity_id_user_Idx" ON session_activity USING btree (id_user_profile);

CREATE INDEX "session_activity_session_id_Idx" ON session_activity USING btree (session_id);


/******************** Add Table: "user" ************************/

/* Build Table Structure */
CREATE TABLE "user"
(
	id NUMERIC(20, 0) NOT NULL,
	id_person NUMERIC(20, 0) NULL,
	username VARCHAR(50) NOT NULL,
	password VARCHAR(200) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE "user" ADD CONSTRAINT pkuser
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "user_id_Idx" ON "user" USING btree (id);

CREATE INDEX "user_id_person_Idx" ON "user" USING btree (id_person);

CREATE UNIQUE INDEX "user_username_Idx" ON "user" USING btree (username);


/******************** Add Table: user_log ************************/

/* Build Table Structure */
CREATE TABLE user_log
(
	id NUMERIC(20, 0) NOT NULL,
	id_user NUMERIC(20, 0) NULL,
	info TEXT NOT NULL,
	date_time TIMESTAMP NULL,
	url VARCHAR(250) NOT NULL,
	ip VARCHAR(150) NULL,
	action VARCHAR(150) NOT NULL,
	browser TEXT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE user_log ADD CONSTRAINT pkuser_log
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "user_log_id_Idx" ON user_log USING btree (id);


/******************** Add Table: user_profile ************************/

/* Build Table Structure */
CREATE TABLE user_profile
(
	id NUMERIC(20, 0) NOT NULL,
	id_user NUMERIC(20, 0) NOT NULL,
	id_profile NUMERIC(20, 0) NOT NULL,
	"isActive" SMALLINT NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE user_profile ADD CONSTRAINT pkuser_profile
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "user_profile_id_Idx" ON user_profile USING btree (id);

CREATE INDEX "user_profile_id_profile_Idx" ON user_profile USING btree (id_profile);

CREATE INDEX "user_profile_id_user_Idx" ON user_profile USING btree (id_user);


/******************** Add Table: user_profile__company_branch ************************/

/* Build Table Structure */
CREATE TABLE user_profile__company_branch
(
	id NUMERIC(20, 0) NOT NULL,
	id_user_profile NUMERIC(20, 0) NOT NULL,
	id_company_branch NUMERIC(20, 0) NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE user_profile__company_branch ADD CONSTRAINT pkuser_profile__company_branch
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "user_profile__company_branch_id_Idx" ON user_profile__company_branch USING btree (id);

CREATE INDEX "user_profile__company_branch_id_company_branch_Idx" ON user_profile__company_branch USING btree (id_company_branch);

CREATE INDEX "user_profile__company_branch_id_user_profile_Idx" ON user_profile__company_branch USING btree (id_user_profile);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_catalog_catalog_type */
ALTER TABLE catalog ADD CONSTRAINT fk_catalog_catalog_type
	FOREIGN KEY (id_catalog_type) REFERENCES catalog_type (id)
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