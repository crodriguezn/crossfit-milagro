/************ Remove Foreign Keys ***************/

ALTER TABLE public.class_registration DROP CONSTRAINT fk_class_registration_schedule;



/************ Update: Tables ***************/

/******************** Add Table: public. class_schedule ************************/

/* Build Table Structure */
CREATE TABLE public. class_schedule
(
	id NUMERIC(20, 0) NOT NULL,
	start_hour VARCHAR(25) NOT NULL,
	final_hour VARCHAR(25) NOT NULL,
	"isActive" SMALLINT NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE public. class_schedule ADD CONSTRAINT pk class_schedule
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX " class_schedule_id_Idx" ON public. class_schedule USING btree (id);

CREATE UNIQUE INDEX " class_schedule_start_hour_final_hour_Idx" ON public. class_schedule USING btree (start_hour, final_hour);


/******************** Remove Table: public.class_schedule ************************/
DROP TABLE public.class_schedule;




/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_class_registration_schedule */
ALTER TABLE public.class_registration ADD CONSTRAINT fk_class_registration_schedule
	FOREIGN KEY (id_schedule) REFERENCES public. class_schedule (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;