<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use PHPExcel;
use PHPExcel_IOFactory;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class UserService
{
    public function __construct(EntityManagerInterface $em,TokenStorageInterface $tokenStorage) 
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public function listUser()
    {
        $user = $this->em->getRepository(User::class)->findAll();
        return $user;
    }

    public function exportDExcel(UserService $userservice)
    {
        $objPHPExcel = new PHPExcel();

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        // $sheet->setCellValue('A1','#');
        // $sheet->setCellValue('B1','First');
        // $sheet->setCellValue('C1','Last');
        // $sheet->setCellValue('D1','Handle');

            $userList = $userservice->listUser();
            $countUser = count($userList);
            if($countUser > 0){
                $n = 1;
                foreach ($userList as $key => $user) {
                    $sheet->setCellValue("A$n",$user->getId());
                    $sheet->setCellValue("B$n",$user->getLogin());
                    $sheet->setCellValue("C$n",$user->getPassword());
                    $sheet->setCellValue("D$n",$user->getRoles());
                $n++;
                }
            }
            

            
        $objPHPExcel->getActiveSheet()->setTitle('User API');
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