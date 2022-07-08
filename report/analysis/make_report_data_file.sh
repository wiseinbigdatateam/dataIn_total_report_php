#!/bin/bash

DBHOST="datainreportdb.cvszzekzdq2c.us-east-2.rds.amazonaws.com"
DBUSER="wiseadmin"
DBPW="wise1357!"
DBNAME="dataIn"

sql="SELECT CONCAT(memid,',',idx,',',analysis_type) FROM analysis_report WHERE stCode = 'PE' AND (stCodeMake != 'Y' OR stCodeMake IS NULL) LIMIT 1;"
row=$(mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}")

#echo "'${row}'"
#echo "'${#row}'"

if [ "${#row}" != "0" ]; then

#echo "2'${row}'"

    i=`expr index "$row" ","`
    ROWMEMID=${row:0:$i-1}
    row2=${row:$i}
    i=`expr index "${row2}" ","`
    ROWIDX=${row2:0:$i-1}
    ROWTYPE=${row2:$i}

    #echo ${i}
    #echo ${row2}
    #echo ${ROWMEMID}
    #echo ${ROWIDX}
    #echo ${ROWTYPE}

    REPORTDIR="/home/ubuntu/dataIn/report/report/${ROWMEMID}/${ROWIDX}"

    echo "REPORTDIR => ${REPORTDIR}"

    if [ ! -d "${REPORTDIR}" ]; then
        mkdir "${REPORTDIR}"
        chmod 777 "${REPORTDIR}"
    fi

    if [ ${ROWTYPE} = 'AH' ]; then
        REPORTURL="http://report.datain.co.kr/report/analysis/make_ahp_report_data_file.php?ridx=${ROWIDX}"
    elif [ ${ROWTYPE} = 'DM' ]; then
        REPORTURL="http://report.datain.co.kr/report/analysis/make_dm_report_data_file.php?ridx=${ROWIDX}"
        #REPORTFILE="multi_${ROWIDX}.html"
    elif [ ${ROWTYPE} = 'MM' ]; then
        REPORTURL="http://report.datain.co.kr/report/analysis/make_mm_report_data_file.php?ridx=${ROWIDX}"
    fi

    echo "REPORTURL => ${REPORTURL}"                                                             
    #echo "REPORTFILE => ${REPORTFILE}"

    echo "wget -O - -q -t 1 ${REPORTURL}"

    cd ${REPORTDIR}

    wget -O - -q -t 1 ${REPORTURL}

    chmod 777 "${REPORTDIR}${REPORTFILE}"

    sql="UPDATE analysis_report SET stCodeMake = 'Y', updateTime = now() WHERE idx = '${ROWIDX}'"
    mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}"

fi