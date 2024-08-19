#!/bin/bash

DB_FILE="database/database.sqlite"

if [ ! -f "$DB_FILE" ]; then
  echo "Database file not found. Creating $DB_FILE..."
  mkdir -p "$(dirname "$DB_FILE")"
  touch "$DB_FILE"
  chmod 644 "$DB_FILE"
  echo "Database file created at $DB_FILE"
else
  echo "Database file already exists at $DB_FILE"
fi
