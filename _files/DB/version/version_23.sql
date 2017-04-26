/************ Update: Tables ***************/

/******************** Update Table: class_date ************************/

ALTER TABLE public.class_date DROP COLUMN created;

ALTER TABLE public.class_date ADD "create" TIMESTAMP NULL;


/******************** Update Table: class_scheduling ************************/

ALTER TABLE public.class_scheduling ADD name VARCHAR(100) NULL;

/* Add Indexes */
CREATE INDEX "class_scheduling_name_Idx" ON public.class_scheduling (name);