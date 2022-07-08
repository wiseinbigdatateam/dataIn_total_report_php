#!/bin/bash
export PATH=/home/ubuntu/anaconda3/bin:/home/ubuntu/anaconda3/condabin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin

source ~/anaconda3/etc/profile.d/conda.sh

conda activate

conda activate datainpy

DBHOST="datainreportdb.cvszzekzdq2c.us-east-2.rds.amazonaws.com"
DBUSER="wiseadmin"
DBPW="wise1357!"
DBNAME="dataIn"

sql="SELECT CONCAT(d.report_idx,' ',d.analysis_idx,' ',d.mm_report_scorepoint) FROM analysis_report AS r, MM_analysis_report_data AS d WHERE r.analysis_type = 'MM' AND r.stCode = 'AE' AND r.idx = d.report_idx LIMIT 1;"
row=$(mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}")

echo ${row}

i=`expr index "$row" " "`
ROWIDX=${row:0:$i-1}
row2=${row:$i}
i=`expr index "${row2}" " "`
ROWANALYSISIDX=${row2:0:$i-1}
ROWPOINT=${row2:$i}

echo ${ROWIDX}
echo ${ROWANALYSISIDX}
echo ${ROWPOINT}

sql="UPDATE analysis_report SET stCode = 'PS' WHERE idx = '${ROWIDX}'" # 보고서생성중
mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}"

sql="UPDATE MM_analysis_report_data SET reg_status = '1' WHERE report_idx = '${ROWIDX}'" # 진행중
mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}"

python /home/ubuntu/dataIn/report/pythonProg/regression/LinearReg.py ${row}

sql="UPDATE analysis_report SET stCode = 'PE' WHERE idx = '${ROWIDX}'" # 보고서생성완료
mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}"

sql="UPDATE MM_analysis_report_data SET reg_status = '2' WHERE report_idx = '${ROWIDX}'" # 완료
mysql -N -s -h${DBHOST} -u${DBUSER} -p${DBPW} -D${DBNAME} -e "${sql}"
