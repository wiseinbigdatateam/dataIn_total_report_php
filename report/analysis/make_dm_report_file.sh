#!/bin/bash

DBHOST="datainreportdb.cvszzekzdq2c.us-east-2.rds.amazonaws.com"
DBUSER="wiseadmin"
DBPW="wise1357!"
DBNAME="dataIn"

sql="SELECT CONCAT(memid,',',idx) FROM analysis_report WHERE analysis_type = 'DM' AND stCode = 'PE' AND (stCodeMake != 'Y' OR stCodeMake IS NULL) LIMIT 1;"
row=$(mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}")

#echo "'${row}'"
#echo "'${#row}'"

if [ "${#row}" != "0" ]; then

echo "2'${row}'"

    i=`expr index "$row" ","`
    ROWMEMID=${row:0:$i-1}
    ROWIDX=${row:$i}

    #echo ${ROWMEMID}
    #echo ${ROWIDX}

    REPORTDIR="/home/ubuntu/dataIn/report/report/${ROWMEMID}/"

    echo "REPORTDIR => ${REPORTDIR}"

    if [ ! -d "${REPORTDIR}" ]; then
        mkdir "${REPORTDIR}"
        chmod 707 "${REPORTDIR}"
    fi

    REPORTURL="http://datain.co.kr/report/multi.html?ridx=${ROWIDX}"
    REPORTFILE="multi_${ROWIDX}.html"

    echo "REPORTURL => ${REPORTURL}"                                                             
    echo "REPORTFILE => ${REPORTFILE}"

    echo "wget -O ${REPORTFILE} -P ${REPORTDIR} ${REPORTURL}"

    cd ${REPORTDIR}

    wget -O ${REPORTFILE} -P ${REPORTDIR} ${REPORTURL} 

    chmod 707 "${REPORTDIR}${REPORTFILE}"

    sql="UPDATE analysis_report SET stCodeMake = 'Y' WHERE idx = '${ROWIDX}'"
    mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}"

fi