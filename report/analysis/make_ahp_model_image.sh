#!/bin/bash
export PATH=/home/ubuntu/anaconda3/bin:/home/ubuntu/anaconda3/condabin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin

source ~/anaconda3/etc/profile.d/conda.sh

conda activate

conda activate datainpy

DBHOST="datainreportdb.cvszzekzdq2c.us-east-2.rds.amazonaws.com"
DBUSER="wiseadmin"
DBPW="wise1357!"
DBNAME="dataIn"

sql="SELECT CONCAT(memid,' ',idx) FROM wise_analysis_myreport WHERE report_type = 'decision' AND image_status = 'N' LIMIT 1;"
row=$(mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}")

echo ${row}

i=`expr index "$row" " "`
ROWMEMID=${row:0:$i-1}
ROWIDX=${row:$i-1}

echo ${ROWMEMID}
echo ${ROWIDX}

python /home/ubuntu/dataIn/report/pythonProg/graph/html2img.py ${row}

sql="UPDATE wise_analysis_myreport SET image_status = 'Y' WHERE idx = '${ROWIDX}'"
mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}"