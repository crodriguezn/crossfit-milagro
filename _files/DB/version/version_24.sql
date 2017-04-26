/************ Update: Tables ***************/

/******************** Update Table: class_date ************************/

ALTER TABLE public.class_date RENAME "create" TO created;
ALTER TABLE public.class_date ALTER COLUMN created TYPE TIMESTAMP;