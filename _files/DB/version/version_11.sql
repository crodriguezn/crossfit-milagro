/************ Update: Tables ***************/

/******************** Update Table: schedule ************************/

/* Add Indexes */
CREATE UNIQUE INDEX "schedule_start_hour_final_hour_Idx" ON schedule (start_hour, final_hour);