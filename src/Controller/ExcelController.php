<?php

namespace App\Controller;

use App\Service\ExportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ExcelController extends AbstractController
{
    /**
     * @Route("/excel", name="excel")
     */
    public function index()
    {
        return $this->render('excel/export_excel.html.twig');
    }

    /**
     * @Route("/export/excel", name="export")
     */
    public function export(ExportService $export)
    {
        $export->exportExcel();
    }
}
