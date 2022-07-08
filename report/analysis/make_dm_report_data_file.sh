#!/bin/bash

DBHOST="datainreportdb.cvszzekzdq2c.us-east-2.rds.amazonaws.com"
DBUSER="wiseadmin"
DBPW="wise1357!"
DBNAME="dataIn"

sql="SELECT CONCAT(memid,',',idx) FROM analysis_report WHERE analysis_type = 'DM' AND stCode = 'PE' AND (stCodeMake != 'Y' OR stCodeMake IS NULL) LIMIT 1;"
#sql="SELECT CONCAT(memid,',',idx) FROM analysis_report WHERE analysis_type = 'DM' AND idx = '6' LIMIT 1;"
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

    REPORTDIR="/home/ubuntu/dataIn/report/report/${ROWMEMID}/${ROWIDX}"

    echo "REPORTDIR => ${REPORTDIR}"

    if [ ! -d "${REPORTDIR}" ]; then
        mkdir "${REPORTDIR}"
        chmod 777 "${REPORTDIR}"
    fi

    REPORTURL="http://report.datain.co.kr/report/analysis/make_dm_report_data_file.php?ridx=${ROWIDX}"
    #REPORTFILE="multi_${ROWIDX}.html"

    echo "REPORTURL => ${REPORTURL}"                                                             
    #echo "REPORTFILE => ${REPORTFILE}"

    echo "wget -O - -q -t 1 ${REPORTURL}"

    cd ${REPORTDIR}

    wget -O - -q -t 1 ${REPORTURL}

    chmod 777 "${REPORTDIR}${REPORTFILE}"

    sql="UPDATE analysis_report SET stCodeMake = 'Y', updateTime = now() WHERE idx = '${ROWIDX}'"
    mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}"

fi