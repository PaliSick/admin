#!/bin/bash
# Archivo bash para back up automáticos de la DB, se configura los datos de la db
#y luego la carpeta donde se pondrá el archivo, el bash siempre toma como inicial
#la carpeta home, por lo tanto no olvidar de poner para la creación como para el 
#borrado la variable $backup_path que es donde se guarda este archivo y los 
#backup que se van realizando.
#ejemplo del crons: 0	0,12	*	*	*	bash /home/wwwidire/backs/back.sh
user="wwweefol_movie"
password="K2__t5swWWsfvbl"
host="localhost"
db_name="wwweefol_movie"
backup_path="backs/back"
date=$(date +"%d-%b-%Y-%H")
umask 177
mysqldump --user=$user --password=$password --host=$host $db_name  | gzip -9 > $backup_path/$db_name-$date.sql.gz
# Borrado de los archivos de los días configuadados luego del "+"
find $backup_path/* -mtime +2 -exec rm {} \;