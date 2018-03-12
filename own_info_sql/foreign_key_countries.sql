ALTER TABLE user MODIFY country INT(11);
ALTER TABLE user ADD CONSTRAINT user_country FOREIGN KEY (country) REFERENCES countries(id);