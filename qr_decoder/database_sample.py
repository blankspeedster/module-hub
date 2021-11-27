import mysql.connector

mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        passwd="",
        database="modulehub_database"
        )
mycursor = mydb.cursor(dictionary=True)
mycursor.execute('''SELECT * FROM class c
                JOIN subjects s
                ON s.id = c.subject_id ''')
result = mycursor.fetchall()
print(result)
for record in result:
    print(record)