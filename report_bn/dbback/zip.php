<?php
//������ : kmbfamily,�ֿ�,xenoteam
//�� �ҽ��ڵ�� �����̸� ���� ����� �����մϴ�.
//���� Ȩ������ : http://www.kmbfamily.net
  include('ziplib.php');
  $zipfile = new PclZip('backup.zip');
  $create = $zipfile->create($data); 
  echo "<pre>\n"; 
  print_r($create); 
 ?>