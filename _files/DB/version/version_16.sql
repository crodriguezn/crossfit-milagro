/************ Remove Foreign Keys ***************/

ALTER TABLE public.class_registration DROP CONSTRAINT fk_class_registration_schedule;



/************ Update: Tables ***************/

/******************** Update Table: class_scheduling ************************/

/* Remove Indexes */
DROP INDEX public."schedule_id_Idx";

DROP INDEX public."schedule_start_hour_final_hour_Idx";

/* Rename: schedule */
ALTER TABLE schedule RENAME TO class_scheduling;

/* Add Indexes */
CREATE INDEX "class_scheduling_id_Idx" ON public.class_scheduling USING btree (id);

CREATE UNIQUE INDEX "class_scheduling_start_hour_final_hour_Idx" ON public.class_scheduling USING btree (start_hour, final_hour);


/******************** Update Table: employee ************************/

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE public.employee ADD COLUMN salary NUMERIC(10, 2);
ALTER TABLE public.employee ALTER COLUMN salary SET NOT NULL;


/******************** Update Table: product ************************/

ALTER TABLE public.product DROP COLUMN quantity;

ALTER TABLE public.product DROP COLUMN descripcion;

ALTER TABLE public.product DROP COLUMN "isValidateQuantity";

ALTER TABLE public.product DROP COLUMN "isEditable";

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE public.product ADD COLUMN name_key VARCHAR(100);
ALTER TABLE public.product ALTER COLUMN name_key SET NOT NULL;

ALTER TABLE public.product ADD description VARCHAR(250) NULL;

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE public.product ADD COLUMN stock_min INTEGER;
ALTER TABLE public.product ALTER COLUMN stock_min SET NOT NULL;

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE public.product ADD COLUMN stock_max INTEGER;
ALTER TABLE public.product ALTER COLUMN stock_max SET NOT NULL;

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE public.product ADD COLUMN purchase_price NUMERIC(10, 2);
ALTER TABLE public.product ALTER COLUMN purchase_price SET NOT NULL;

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE public.product ADD COLUMN stock INTEGER;
ALTER TABLE public.product ALTER COLUMN stock SET NOT NULL;





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_class_registration_schedule */
ALTER TABLE public.class_registration ADD CONSTRAINT fk_class_registration_schedule
	FOREIGN KEY (id_schedule) REFERENCES public.class_scheduling (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;