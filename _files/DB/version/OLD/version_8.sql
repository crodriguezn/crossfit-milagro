/************ Update: Tables ***************/

/******************** Update Table: configuration_system ************************/

ALTER TABLE configuration_system ADD "isSaveBinnacle" SMALLINT NULL;

/* Add Indexes */
CREATE INDEX "configuration_system_id_Idx" ON configuration_system (id);

CREATE INDEX "configuration_system_name_system_Idx" ON configuration_system (name_system);