/************ Remove Foreign Keys ***************/

ALTER TABLE public.class_registration DROP CONSTRAINT fk_class_registration_schedule;



/************ Update: Tables ***************/

/******************** Add Table: public.class_date ************************/

/* Build Table Structure */
CREATE TABLE public.class_date
(
	id NUMERIC(20, 0) NOT NULL,
	day DATE NOT NULL,
	"isActive" SMALLINT NOT NULL
);

/* Add Primary Key */
ALTER TABLE public.class_date ADD CONSTRAINT pkclass_date
	PRIMARY KEY (id);


/******************** Add Table: public.class_hour ************************/

/* Build Table Structure */
CREATE TABLE public.class_hour
(
	id NUMERIC(20, 0) NOT NULL,
	start_hour VARCHAR(25) NOT NULL,
	final_hour VARCHAR(25) NOT NULL,
	"isActive" SMALLINT NOT NULL
) WITHOUT OIDS;

/* Add Primary Key */
ALTER TABLE public.class_hour ADD CONSTRAINT pkclass_hour
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX " class_hour_id_Idx" ON public.class_hour USING btree (id);

CREATE UNIQUE INDEX " class_hour_start_hour_final_hour_Idx" ON public.class_hour USING btree (start_hour, final_hour);


/******************** Update Table: class_registration ************************/

/* Remove Indexes */
DROP INDEX public."class_registration_id_schedule_Idx";

ALTER TABLE public.class_registration RENAME id_schedule TO id_class_scheduling;
ALTER TABLE public.class_registration ALTER COLUMN id_class_scheduling TYPE NUMERIC(20, 0);

/* Add Indexes */
CREATE INDEX "class_registration_id_class_scheduling_Idx" ON public.class_registration USING btree (id_class_scheduling);


/******************** Remove Table: public.class_schedule ************************/
DROP TABLE public.class_schedule;

/******************** Add Table: public.class_scheduling ************************/

/* Build Table Structure */
CREATE TABLE public.class_scheduling
(
	id NUMERIC(20, 0) NOT NULL,
	id_class_hour NUMERIC(20, 0) NOT NULL,
	id_class_date NUMERIC(20, 0) NOT NULL
);

/* Add Primary Key */
ALTER TABLE public.class_scheduling ADD CONSTRAINT pkclass_scheduling
	PRIMARY KEY (id);

/* Add Indexes */
CREATE UNIQUE INDEX "class_scheduling_id_Idx" ON public.class_scheduling (id);

CREATE INDEX "class_scheduling_id_class_date_Idx" ON public.class_scheduling (id_class_date);

CREATE INDEX "class_scheduling_id_class_hour_Idx" ON public.class_scheduling (id_class_hour);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_class_registration_class_scheduling */
ALTER TABLE public.class_registration ADD CONSTRAINT fk_class_registration_class_scheduling
	FOREIGN KEY (id_class_scheduling) REFERENCES public.class_scheduling (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_class_scheduling_class_date */
ALTER TABLE public.class_scheduling ADD CONSTRAINT fk_class_scheduling_class_date
	FOREIGN KEY (id_class_date) REFERENCES public.class_date (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_class_scheduling_class_hour */
ALTER TABLE public.class_scheduling ADD CONSTRAINT fk_class_scheduling_class_hour
	FOREIGN KEY (id_class_hour) REFERENCES public.class_hour (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;