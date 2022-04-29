#!/usr/bin/env python3

import sys
import mysql.connector as mysqldb

DB_USERNAME = "rigelstar"
DB_PASSWORD = "*galexia7#"
DB_SERVERNAME = "localhost"
DB_NAME = 'kaamdaar'


def get_new_kdb_connection():
	return mysqldb.connect(
		username = DB_USERNAME,
		password = DB_PASSWORD,
		host = DB_SERVERNAME,
		database = DB_NAME
	)

db_conn = get_new_kdb_connection()
db_conn.autocommit = True

db_cursor = db_conn.cursor(dictionary=True, buffered=True)

REQUEST_TABLES = ['painter_requests', 'carpenter_requests', 'plumber_requests']

FETCH_QUERY = f"SELECT * FROM {REQUEST_TABLES[0]}"

db_cursor.execute(FETCH_QUERY)
results = db_cursor.fetchall()

for row in results:
	date_started = row['pr_date_started']
	date_end = row['pr_date_end']

	print(date_started, date_end)