/* Create a trigger each time a row is added to coldroomtermperatures table and archive this result to coldroomtemperatures_archive table */
CREATE TRIGGER coldroomtemperatures_insert_trigger
AFTER INSERT ON coldroomtermperatures
FOR EACH ROW
EXECUTE PROCEDURE coldroomtemperatures_insert_trigger_function();

/* coldroomtemperatures_insert_trigger_function */
CREATE OR REPLACE FUNCTION coldroomtemperatures_insert_trigger_function()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO coldroomtemperatures_archive
    SELECT * FROM coldroomtermperatures;
    RETURN NULL;
END;