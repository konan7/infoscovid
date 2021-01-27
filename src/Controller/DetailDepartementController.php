<?php

namespace App\Controller;

use App\Service\CallApiService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DetailDepartementController extends AbstractController
{
    /**
     * @Route("/detail/departement/{department}", name="detail_departement")
     */
    public function index(string $department, CallApiService $callApiService, ChartBuilderInterface $chartBuilder): Response
    {
        $label = [];
        $hospitalisation = [];
        $rea = [];

        for($i=1; $i < 8;$i++){
            $date = New DateTime('- '.$i.' day');
            $datas = $callApiService->getAllDataByDate($date->format('Y-m-d'));

            foreach ($datas['allFranceDataByDate'] as $data){
                if($data['nom'] === $department){
                    $label[] = $data['date']; $hospitalisation[] = $data['nouvellesHospitalisations'];
                    $rea[] = $data['nouvellesReanimations'];
                }
            }
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([

            'labels' => array_reverse($label),
            'datasets' => [
                [
            'label'=> 'Nouvelles Hospitalitions',
            'borderColor' => '#ff0000',
            'data' => array_reverse($hospitalisation),
            ],

            [
                'label' => 'Nouvelles entrées en réanimation',
                'borderColor' => 'rgb(46, 41, 78)',
                'data' => array_reverse($rea),
            ],
          ],
        ]);

        $chart->setOptions([/*...*/]);

        return $this->render('detail_departement/index.html.twig', [
            'data' => $callApiService->getDepartmentData($department),
            'chart' => $chart,
        ]);
    }
}
