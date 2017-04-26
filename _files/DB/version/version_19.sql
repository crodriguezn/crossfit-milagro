/************ Update: Tables ***************/

/******************** Update Table: employee ************************/

ALTER TABLE public.employee ADD "isCoach" SMALLINT NULL;

/************ Update: Tables ***************/

/******************** Update Table: class_scheduling ************************/

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE public.class_scheduling ADD COLUMN id_employee NUMERIC(20, 0);
ALTER TABLE public.class_scheduling ALTER COLUMN id_employee SET NOT NULL;

/* Add Comments */
COMMENT ON COLUMN public.class_scheduling.id_employee IS 'coach';

/* Add Indexes */
CREATE INDEX "class_scheduling_id_employee_Idx" ON public.class_scheduling (id_employee);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_class_scheduling_employee */
ALTER TABLE public.class_scheduling ADD CONSTRAINT fk_class_scheduling_employee
	FOREIGN KEY (id_employee) REFERENCES public.employee (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;