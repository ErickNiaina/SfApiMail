<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use PHPExcel;
use PHPExcel_IOFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class ExportService
{
    public function __construct(EntityManagerInterface $em,TokenStorageInterface $tokenStorage) 
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public function exportExcel()
    {
        $objPHPExcel = new PHPExcel();

        $s = $objPHPExcel->setActiveSheetIndex(0);
        $s->setCellValue('A1','#');
        $s->setCellValue('B1','First');
        $s->setCellValue('C1','Last');
        $s->setCellValue('D1','Handle');

        $s->setCellValue('A2','1');
        $s->setCellValue('B2','Marc');
        $s->setCellValue('C2','Jacob');
        $s->setCellValue('D2','@mdo');

        $s->setCellValue('A3','2');
        $s->setCellValue('B3','Jacob');
        $s->setCellValue('C3','ThornTon');
        $s->setCellValue('D3','@fat');

        $s->setCellValue('A4','3');
        $s->setCellValue('B4','Larry');
        $s->setCellValue('C4','The Birds');
        $s->setCellValue('D4','@twitter');


        $objPHPExcel->getActiveSheet()->setTitle('Data API');
        $objPHPExcel->setActiveSheetIndex(0);
        $filename = 'sample_'.time().'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Cache-Control: cache, must-revalidate'); 


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
        

        
    }

    
        
}