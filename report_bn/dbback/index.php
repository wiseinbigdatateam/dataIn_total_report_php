<?php
//������ : kmbfamily,�ֿ�,xenoteam
//�� �ҽ��ڵ�� �����̸� ���� ����� �����մϴ�.
//���� Ȩ������ : http://www.kmbfamily.net
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);  
ini_set("display_errors", "1");  

ini_set('max_execution_time',0);
$DB_HOST = 'localhost';	//dbȣ��Ʈ��,�Ϲ����� ���� 127.0.0.1 �Ǵ� localhost�� �����ϴ�.
$DB_USER = 'root';		//db���̵�
$DB_PASS = 'bn@5188##';		//db��й�ȣ
$DB_NAME = 'datain';		//db�̸�
$data ="../";		//�����ϰ� ���� ������ �����
//ex:�� ������ ����� �ִ� ������ �����ҰŸ� ��δ� "../�����̸�", ../�� ���� �� ��ĭ ������ ����Դϴ�.
//ex:�� �����ϰ� ���� ���� �ȿ��ִ� ������ �����ҰŸ� ��δ� "�����̸�"
//include('zip.php');	//ftp���� ��� �κ�,ftp���� ����� ������ ������ �ּ�ó�� �ϼ���.
//include('db.php');	//db��� �κ�,db����� ������ ������ �ּ� ó�� �ϼ���.
include('dbsqli.php');	//db sqli��� ��� �κ�,sqli��� ����� ������ ������ �ּ� ó�� �ϼ���.
?>