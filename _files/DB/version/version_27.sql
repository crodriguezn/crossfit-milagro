/************ Update: Tables ***************/

/******************** Update Table: class_date ************************/

ALTER TABLE public.class_date DROP COLUMN "isActive";


/******************** Update Table: class_scheduling ************************/

/* Remove Indexes */
DROP INDEX public."class_scheduling_name_Idx";

ALTER TABLE public.class_scheduling DROP COLUMN name;

/************ Update: Tables ***************/

/******************** Update Table: class_date ************************/

ALTER TABLE public.class_date ADD name VARCHAR(50) NULL;

/* Add Indexes */
CREATE INDEX "class_date_name_Idx" ON public.class_date (name);

/************ Update: Tables ***************/

/******************** Update Table: class_date ************************/

/* Remove Indexes */
DROP INDEX public."class_date_end_day_Idx";

DROP INDEX public."class_date_start_day_Idx";

/* Add Indexes */
CREATE UNIQUE INDEX "class_date_end_day_Idx" ON public.class_date (end_day);

CREATE UNIQUE INDEX "class_date_start_day_Idx" ON public.class_date USING btree (start_day);

/************ Update: Tables ***************/

/******************** Update Table: class_date ************************/

/* Remove Indexes */
DROP INDEX public."class_date_end_day_Idx";

ALTER TABLE public.class_date DROP COLUMN end_day;