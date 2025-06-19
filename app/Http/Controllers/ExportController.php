<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Illuminate\Http\Request;
use App\Http\Resources\ExportResource;
use Illuminate\Support\Facades\Validator;
use App\Exports\ExportsDataExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExportExcelMail;

class ExportController extends Controller
{
    // modele export controller with swagger documentation

    /**
     * @OA\Get(
     *     path="/api/exports",
     *     tags={"Export"},
     *     security={{"sanctum": {}}},
     *     summary="List all export",
     *     @OA\Response(response="200", description="List all export"),
     * )
     */
    public function index()
    {
        // $export = Export::all();
        $user_id = auth()->user()->id;
        $export = Export::where('user_id', $user_id)->get();

        $admin_emails = ['appli.naturascan@gmail.com'];

        // check if user email is in admin_emails
        if (in_array(auth()->user()->email, $admin_emails)) {
            $export = Export::all();
        }
        
        // $export = Export::all();
        return ExportResource::collection($export);
    }

    /**
     * @OA\Get(
     *     path="/api/exports/export",
     *     tags={"Export"},
     *     security={{"sanctum": {}}},
     *     summary="Export all export",
     *     @OA\Response(response="200", description="Export all export"),
     * )
     */
    public function export()
    {
        return Excel::download(new ExportsDataExport, 'exports.xlsx');
    }

    public function exportExcel()
    {
        set_time_limit(30000);
        
        // $exports = Export::orderBy('id', 'desc')->get();
        // get all exports ordered by created_at
        $exports = Export::orderBy('created_at', 'desc')->get();

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('empty.xlsx');

        $trace_spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('traces.xlsx'); 

        $sheet = $spreadsheet->getSheetByName('Sorties');
        
        $row = 2;
        foreach ($exports as $export) {
            if($export->the_type() != "Prospection" && $export->the_type() != "SuiviTrace" ){
                $data = $this->map($export);   

                // $data = json_decode($export->data, true);
                $sheet->setCellValue('A' . $row, $data['structure'] ?? '');
                $sheet->setCellValue('B' . $row, $data['date']);
                $sheet->setCellValue('C' . $row, $data['port_depart'] ?? '');
                $sheet->setCellValue('D' . $row, $data['port_arrivee'] ?? '');
                $sheet->setCellValue('E' . $row, $data['heure_depart_port']);
                $sheet->setCellValue('F' . $row, $data['heure_arrivee_port']);
                $sheet->setCellValue('G' . $row, $data['duree_sortie'] ?? '');
                $sheet->setCellValue('H' . $row, $data['responsable']);
                $sheet->setCellValue('I' . $row, $data['skipper']);
                $sheet->setCellValue('J' . $row, $data['photographe']);
                $sheet->setCellValue('K' . $row, $data['observateurs']);
                $sheet->setCellValue('L' . $row, $data['nbre_observateurs'] ?? '');
                $sheet->setCellValue('M' . $row, $data['type_bateau'] ?? '');
                $sheet->setCellValue('N' . $row, $data['nom_bateau'] ?? '');
                $sheet->setCellValue('O' . $row, $data['hauteur_bateau'] ?? '');
                $sheet->setCellValue('P' . $row, $data['heure_utc'] ?? '');
                $sheet->setCellValue('Q' . $row, $data['distance_parcourue'] ?? '');
                $sheet->setCellValue('R' . $row, $data['superficie_echantillonnee'] ?? '');
    
                $row++;

            }
        }

        $sheet = $spreadsheet->getSheetByName('Observations');

        $row = 3;
        foreach ($exports as $export) {

            if($export->the_type() != "Prospection" && $export->the_type() != "SuiviTrace" ){
                $observations = $this->map_observations($export);   
                
                foreach($observations as $data){
    
                    if($data['heure_fin']=='-'){
                        // set row bg color to green
                        $sheet->getStyle('L' . $row . ':M' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FF00');
                    }
    
                    $sheet->setCellValue('A' . $row, isset($data['date']) ? $data['date'] : '-');
                    // add border to right of cell
                    $sheet->getStyle('A' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    
                    $sheet->setCellValue('B' . $row, isset($data['heure_debut']) ? $data['heure_debut'] : '-');
                    // border
                    $sheet->getStyle('B' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('C' . $row, isset($data['heure_fin']) ? $data['heure_fin'] : '-');
                    // border
                    $sheet->getStyle('C' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    
                    $sheet->setCellValue('D' . $row, isset($data['latitude_debut_deg_min_sec']) ? $data['latitude_debut_deg_min_sec'] : '-');
                    $sheet->setCellValue('E' . $row, isset($data['latitude_debut_deg_dec']) ? $data['latitude_debut_deg_dec'] : '-');
                    // border
                    $sheet->getStyle('E' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('F' . $row, isset($data['longitude_debut_deg_min_sec']) ? $data['longitude_debut_deg_min_sec'] : '-');
                    $sheet->setCellValue('G' . $row, isset($data['longitude_debut_deg_dec']) ? $data['longitude_debut_deg_dec'] : '-');
                    // border
                    $sheet->getStyle('G' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('H' . $row, isset($data['latitude_fin_deg_min_sec']) ? $data['latitude_fin_deg_min_sec'] : '-');
                    $sheet->setCellValue('I' . $row, isset($data['latitude_fin_deg_dec']) ? $data['latitude_fin_deg_dec'] : '-');
                    // border
                    $sheet->getStyle('I' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('J' . $row, isset($data['longitude_fin_deg_min_sec']) ? $data['longitude_fin_deg_min_sec'] : '-');
                    $sheet->setCellValue('K' . $row, isset($data['longitude_fin_deg_dec']) ? $data['longitude_fin_deg_dec'] : '-');
                    // border
                    $sheet->getStyle('K' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('L' . $row, isset($data['scientific_name']) ? $data['scientific_name'] : '-');
                    // border
                    $sheet->getStyle('L' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('M' . $row, isset($data['common_name']) ? $data['common_name'] : '-');
                    // border
                    $sheet->getStyle('M' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('N' . $row, isset($data['nbre_estime']) ? $data['nbre_estime'] : '-');
                    // border
                    $sheet->getStyle('N' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('O' . $row, isset($data['nbre_mini']) ? $data['nbre_mini'] : '-');
                    // border   
                    $sheet->getStyle('O' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('P' . $row, isset($data['nbre_maxi']) ? $data['nbre_maxi'] : '-');
                    // border
                    $sheet->getStyle('P' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('Q' . $row, isset($data['nbre_adultes']) ? $data['nbre_adultes'] : '-');
                    // border
                    $sheet->getStyle('Q' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('R' . $row, isset($data['nbre_jeunes']) ? $data['nbre_jeunes'] : '-');
                    // border
                    $sheet->getStyle('R' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('S' . $row, isset($data['nbre_nouveau_ne']) ? $data['nbre_nouveau_ne'] : '-');
                    // border
                    $sheet->getStyle('S' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('T' . $row, isset($data['gisement']) ? $data['gisement'] : '-');
                    // border
                    $sheet->getStyle('T' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('U' . $row, isset($data['distance_estimee']) ? $data['distance_estimee'] : '-');
                    // border
                    $sheet->getStyle('U' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('V' . $row, isset($data['element_detection']) ? $data['element_detection'] : '-');
                    // border
                    $sheet->getStyle('V' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('W' . $row, isset($data['structure_groupe']) ? $data['structure_groupe'] : '-');
                    // border
                    $sheet->getStyle('W' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('X' . $row, isset($data['nbre_sous_groupes']) ? $data['nbre_sous_groupes'] : '-');
                    // border
                    $sheet->getStyle('X' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('Y' . $row, isset($data['nbre_indiv_sous_groupe']) ? $data['nbre_indiv_sous_groupe'] : '-');
                    // border
                    $sheet->getStyle('Y' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('Z' . $row, isset($data['vitesse']) ? $data['vitesse'] : '-');
                    // border
                    $sheet->getStyle('Z' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('AA' . $row, isset($data['comportement_surface']) ? $data['comportement_surface'] : '-');
                    // border
                    $sheet->getStyle('AA' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('AB' . $row, isset($data['reaction_bateau']) ? $data['reaction_bateau'] : '-');
                    // border
                    $sheet->getStyle('AB' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('AC' . $row, isset($data['especes_associees']) ? $data['especes_associees'] : '-');
                    // border
                    $sheet->getStyle('AC' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('AD' . $row, isset($data['activites_humaines_associees']) ? $data['activites_humaines_associees'] : '-');
                    // border
                    $sheet->getStyle('AD' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('AE' . $row, isset($data['activites_peche_associees']) ? $data['activites_peche_associees'] : '-');
                    // border
                    $sheet->getStyle('AE' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('AF' . $row, isset($data['donnees_recoltees']) ? $data['donnees_recoltees'] : '-');
                    // border
                    $sheet->getStyle('AF' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('AG' . $row, isset($data['autre']) ? $data['autre'] : '-');
                    // border
                    $sheet->getStyle('AG' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->setCellValue('AH' . $row, isset($data['commentaires']) ? $data['commentaires'] : '-');
                    // border
                    $sheet->getStyle('AH' . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    
                    $row++;
                }
    
                // make the bottom border bold of the last row 
                $sheet->getStyle('A' . ($row - 1) . ':AD' . ($row - 1))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            }


        }

        $row = 2;
        $trace_sheet = $trace_spreadsheet->getSheetByName('Prospections');
        foreach ($exports as $export) {

            if($export->the_type() == "Prospection"){
                $traces = $this->map_observations($export);   

                foreach($traces as $trace){
    
                    $trace_sheet->setCellValue('A' . $row, $trace['date']);
                    $trace_sheet->setCellValue('B' . $row, $trace['heure_debut']);
                    $trace_sheet->setCellValue('C' . $row, $trace['heure_fin']);
                    $trace_sheet->setCellValue('D' . $row, $trace['duree_sortie']); 
                    $trace_sheet->setCellValue('E' . $row, $trace['secteur']);
                    $trace_sheet->setCellValue('F' . $row, $trace['sous_secteur']);
                    $trace_sheet->setCellValue('G' . $row, $trace['plage']);
                    $trace_sheet->setCellValue('H' . $row, $trace['mode']); 
                    $trace_sheet->setCellValue('I' . $row, $trace['latitude']);
                    $trace_sheet->setCellValue('J' . $row, $trace['longitude']);
                    $trace_sheet->setCellValue('K' . $row, $trace['referents']);
                    $trace_sheet->setCellValue('L' . $row, $trace['patrouilleurs']);
                    $trace_sheet->setCellValue('M' . $row, $trace['sea_state']);
                    $trace_sheet->setCellValue('N' . $row, $trace['cloud_cover']); 
                    $trace_sheet->setCellValue('O' . $row, $trace['wind_force']); 
                    $trace_sheet->setCellValue('P' . $row, $trace['wind_speed']);
                    $trace_sheet->setCellValue('Q' . $row, $trace["remark"]);
                    $trace_sheet->setCellValue('R' . $row, $trace['trace']);
                    $trace_sheet->setCellValue('S' . $row, $trace['presence_nid']);
                    $trace_sheet->setCellValue('T' . $row, $trace['emergence']);
                    $trace_sheet->setCellValue('U' . $row, $trace['esclavation']);
                    // email
                    $trace_sheet->setCellValue('V' . $row, $trace['email']);
                    $row++;

                }
    

            }
        }

        $row = 2;
        $trace_sheet = $trace_spreadsheet->getSheetByName('TRASSEFF');
        foreach ($exports as $export) {
            if($export->the_type() == "SuiviTrace"){

                $trace = $this->map_observations($export);   
                $trace_sheet->setCellValue('A' . $row, $trace['date']);
                $trace_sheet->setCellValue('B' . $row, $trace['heure_debut']);
                $trace_sheet->setCellValue('C' . $row, $trace['heure_fin']);
                $trace_sheet->setCellValue('D' . $row, $trace['duree_sortie']); 
                $trace_sheet->setCellValue('E' . $row, $trace['secteur']);
                $trace_sheet->setCellValue('F' . $row, $trace['sous_secteur']);
                $trace_sheet->setCellValue('G' . $row, $trace['plage']);
                $trace_sheet->setCellValue('H' . $row, $trace['mode']); 
                $trace_sheet->setCellValue('I' . $row, $trace['latitude']);
                $trace_sheet->setCellValue('J' . $row, $trace['longitude']);
                $trace_sheet->setCellValue('K' . $row, $trace['referents']);
                $trace_sheet->setCellValue('L' . $row, $trace['patrouilleurs']);
                $trace_sheet->setCellValue('M' . $row, $trace['sea_state']);
                $trace_sheet->setCellValue('N' . $row, $trace['cloud_cover']); 
                $trace_sheet->setCellValue('O' . $row, $trace['wind_force']); 
                $trace_sheet->setCellValue('P' . $row, $trace['wind_speed']);
                $trace_sheet->setCellValue('Q' . $row, $trace["remark"]);
                $trace_sheet->setCellValue('R' . $row, $trace['trace']);
                $trace_sheet->setCellValue('S' . $row, $trace['presence_nid']);
                $trace_sheet->setCellValue('T' . $row, $trace['emergence']);
                $trace_sheet->setCellValue('U' . $row, $trace['esclavation']);
                $trace_sheet->setCellValue('V' . $row, $trace['email']);

                $row++;

            }
        }



        // Créer un writer pour écrire le fichier

        $writer = new Xlsx($spreadsheet);
        $fileName = 'exports_naturascan_' . date('Y-m-d_H-i-s') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        // Créer un writer pour écrire le fichier
        $trace_writer = new Xlsx($trace_spreadsheet);
        $trace_fileName = 'exports_traces_' . date('Y-m-d_H-i-s') . '.xlsx';
        $trace_tempFile = tempnam(sys_get_temp_dir(), $trace_fileName);
        $trace_writer->save($trace_tempFile);


        $user_email = auth()->user()->email;

        // Envoyer l'email avec le fichier en pièce jointe
         $email = "S.catteau@association-emergence.fr";

        // $email = "hidi9867@gmail.com";
        //$email = "gillesakakpo01@gmail.com";
        // Mail::to($email)->send(new ExportExcelMail($tempFile));

        Mail::to($email)->send(new ExportExcelMail($tempFile, $trace_tempFile));
        Mail::to($email)->bcc('appli.naturascan@gmail.com')->send(new ExportExcelMail($tempFile, $trace_tempFile));
        // Mail::to($user_email)->bcc('gillesakakpo01@gmail.com')->bcc('sogbossimichee4@gmail.com')->bcc('s.catteau@marineland.fr')->send(new ExportExcelMail($tempFile));
        // Supprimer le fichier temporaire

        // unlink($tempFile);
        // unlink($trace_tempFile);

        return response()->json(['message' => 'Email sent successfully']);
    }
    
   
    public function map_observations($export): array
    {
        $data = json_decode($export->data, true);

        $sortie = $data['naturascan'];
        if (!$sortie) {
            $sortie = $data['obstrace'];
        }    
        
        $email = $export->user->email ?? "";
   
        if($data['type'] == "Prospection"){
            $prospection = $sortie['prospection'];
            $trace_datas = $prospection['traces'];  

               
            $traces = []; 
            if($trace_datas == []){

                $trace = [];
                $trace['date'] =  $this->format_date($prospection['heure_debut'],'date')  ??'';
                $trace['heure_debut'] =  $this->format_date($prospection['heure_debut'],'hour')  ??'';
                $trace['heure_fin'] =  $this->format_date($prospection['heure_fin'],'hour')  ??'';
                $trace['duree_sortie'] =  $this->format_date(($prospection['heure_fin'] -  $prospection['heure_debut']),'hour',false)   ??'';
                $trace['secteur'] = $prospection['secteur']['name'] ?? '';
                $trace['sous_secteur'] = $prospection['sous_secteur']['name'] ?? '';
                $trace['plage'] = $prospection['plage']['name'] ?? '';
                $trace['mode'] = $prospection['mode'] ?? "";
                $trace['location'] = $prospection['end1'];
                $trace['latitude'] = $prospection['end1']['latitude']['deg_min_sec'] ?? "";
                $trace['longitude'] = $prospection['end1']['longitude']['deg_min_sec'] ?? "";
                $trace['nbre_observateurs'] = $prospection['nbre_observateurs'] ?? "";
                $trace['referents'] = $this->formatPersons($prospection['referents'] ?? [])  ?? '';
                $trace['patrouilleurs'] = $this->formatPersons($prospection['patrouilleurs'] ?? [])  ?? '';
                $trace['suivi'] = $prospection['suivi']; 
                $trace['sea_state'] =  $prospection['weather_report']['sea_state']["description"] ?? ""  ;
                $trace['cloud_cover'] =  $prospection['weather_report']['cloud_cover']["description"] ?? ""  ;
                $trace['visibility'] =  $prospection['weather_report']['visibility']["description"] ?? ""  ;
                $trace['wind_force'] =  $prospection['weather_report']['wind_force']["description"] ?? ""  ;
                $trace['wind_direction'] =  $prospection['weather_report']['wind_direction']["description"] ?? ""  ;
                $trace['wind_speed'] =  $prospection['weather_report']['wind_speed']["description"] ?? ""  ;

                $trace["remark"]  = $prospection['remark']  ?? '-';

                $trace["trace"] = "Non";

                $trace['presence_nid'] = "-";
                $trace['emergence'] = "-";
                $trace['esclavation'] = "-";
                // email
                $trace['email'] = $email ;
                $traces[] = $trace;

            }else{
                foreach($trace_datas as $trace_data){ 
                    $trace = [];
                    $trace['date'] =  $this->format_date($prospection['heure_debut'],'date')  ??'';
                    $trace['heure_debut'] =  $this->format_date($prospection['heure_debut'],'hour')  ??'';
                    $trace['heure_fin'] =  $this->format_date($prospection['heure_fin'],'hour')  ??'';
                    $trace['duree_sortie'] =  $this->format_date(($prospection['heure_fin'] -  $prospection['heure_debut']),'hour',false)   ??'';
                    $trace['secteur'] = $prospection['secteur']['name'] ?? '';
                    $trace['sous_secteur'] = $prospection['sous_secteur']['name'] ?? '';
                    $trace['plage'] = $prospection['plage']['name'] ?? '';
                    $trace['mode'] = $prospection['mode'] ?? "";
                    $trace['location'] = $trace_data['location'];
                    $trace['latitude'] = $trace_data['location']['latitude']['deg_min_sec'] ?? "";
                    $trace['longitude'] = $trace_data['location']['longitude']['deg_min_sec'] ?? "";
                    $trace['nbre_observateurs'] = $prospection['nbre_observateurs'] ?? "";
                    $trace['referents'] = $this->formatPersons($prospection['referents'] ?? [])  ?? '';
                    $trace['patrouilleurs'] = $this->formatPersons($prospection['patrouilleurs'] ?? [])  ?? '';
                    $trace['suivi'] = $prospection['suivi']; 
                    $trace['sea_state'] =  $trace_data['weather_report']['sea_state']["description"] ?? ""  ;
                    $trace['cloud_cover'] =  $trace_data['weather_report']['cloud_cover']["description"] ?? ""  ;
                    $trace['visibility'] =  $trace_data['weather_report']['visibility']["description"] ?? ""  ;
                    $trace['wind_force'] =  $trace_data['weather_report']['wind_force']["description"] ?? ""  ;
                    $trace['wind_direction'] =  $trace_data['weather_report']['wind_direction']["description"] ?? ""  ;
                    $trace['wind_speed'] =  $trace_data['weather_report']['wind_speed']["description"] ?? ""  ;
    
                    $trace["remark"]  = $trace_data['remark']  ?? '';
    
                    // $trace["trace"] = $trace_data['presence_nid'] != null || $trace_data['emergence']!=null || $trace_data['esclavation'] != null  ? 'Oui' : 'Non';
                    $trace["trace"] = "Oui";
    
                    $presence_nid = $trace_data['presence_nid'] == null ? ($trace["trace"] == "Oui" ? 'A Confirmer' : '-') :  ($trace_data['presence_nid']['presence_nid'] == 1  ? "Oui" : 'Non' ) ;
                    $emergence = $trace_data['emergence'] == null ? ($trace["trace"] == "Oui" ? 'A Confirmer' : '-')  :  ($trace_data['emergence']['emergence'] == 1  ? "Oui" : 'Non' ) ;
                    $esclavation = $trace_data['esclavation'] == null ? ($trace["trace"] == "Oui" ? 'A Confirmer' : '-')  :  ($trace_data['esclavation']['esclavation'] == 1  ? "Oui" : 'Non' ) ;
    
                    $trace['presence_nid'] = $presence_nid;
                    $trace['emergence'] = $emergence;
                    $trace['esclavation'] = $esclavation;
                    $trace['email'] = $email ;
                    $traces[] = $trace;
    
                }
            }


            return $traces;

        }

        if($data['type'] == "SuiviTrace"){

            
            $prospection = $sortie['traces'];
            $prospection['photos'] = null;
            if(!isset($prospection['heure_debut'])){
                // dd($prospection);
            }

            $sortie['traces'] = $prospection;
            $trace = [];
            $trace['date'] = $this->format_date($prospection['heure'],'date')  ??'';

            $trace['heure_debut'] =  $this->format_date($prospection['heure'],'hour')  ??'';
            $trace['heure_fin'] =  '';
            $trace['duree_sortie'] =  '';


            $trace['secteur'] = $prospection['secteur']['name'] ?? '';
            $trace['sous_secteur'] = $prospection['sous_secteur']['name'] ?? '';
            $trace['plage'] = $prospection['plage']['name'] ?? '';
            $trace['mode'] = $prospection['mode'] ?? "";
            $trace['nbre_observateurs'] = $prospection['nbre_observateurs'] ?? '';
            $trace['referents'] = $this->formatPersons($prospection['referents'] ?? [])  ?? '';
            $trace['patrouilleurs'] = $this->formatPersons($prospection['patrouilleurs'] ?? [])  ?? '';
            $trace['heure'] =  $this->format_date($prospection['heure'],'hour')  ??'';
            $trace['suivi'] = $prospection['suivi'] == 1 ? 'Oui' : 'Non';
            $trace['sea_state'] = $prospection['weather_report']['sea_state']["description"] ?? '';
            $trace['cloud_cover'] = $prospection['weather_report']['cloud_cover']["description"] ?? '';
            $trace['visibility'] = $prospection['weather_report']['visibility']["description"] ?? '';
            $trace['wind_force'] = $prospection['weather_report']['wind_force']["description"] ?? '';
            $trace['wind_direction'] = $prospection['weather_report']['wind_direction']["description"] ?? '';
            $trace['wind_speed'] = $prospection['weather_report']['wind_speed']["description"] ?? '';
            $trace["remark"]  = $prospection['remark'] ?? '';
            $trace['location'] = $prospection['location'];
            $trace['latitude'] = $prospection['location']['latitude']['deg_min_sec'] ?? "";
            $trace['longitude'] = $prospection['location']['longitude']['deg_min_sec'] ?? "";

            $trace["remark"]  = $prospection['remark'] ?? $prospection['remark'] ?? '';

            $trace["trace"] = $prospection['presence_nid'] != null || $prospection['emergence']!=null || $prospection['esclavation'] != null  ? 'Oui' : 'Non';

            $presence_nid = $prospection['presence_nid'] == null ? ($trace["trace"] == "Oui" ? 'A Confirmer' : '-') :  ($prospection['presence_nid']['presence_nid'] == 1  ? "Oui" : 'Non' ) ;
            $emergence = $prospection['emergence'] == null ? ($trace["trace"] == "Oui" ? 'A Confirmer' : '-')  :  ($prospection['emergence']['emergence'] == 1  ? "Oui" : 'Non' ) ;
            $esclavation = $prospection['esclavation'] == null ? ($trace["trace"] == "Oui" ? 'A Confirmer' : '-')  :  ($prospection['esclavation']['esclavation'] == 1  ? "Oui" : 'Non' ) ;

            $trace['presence_nid'] = $presence_nid;
            $trace['emergence'] = $emergence;
            $trace['esclavation'] = $esclavation;
            $trace['email'] = $email ;
            return $trace;
           
        }


        $data = $sortie;

        if($data){
            $data_observations = isset($data['observations']) ? $data['observations'] : [];  
            $observations = [];
            foreach ($data_observations as $obs) {
                $observation = [];
                if($obs['waste']!=null){
                    $observation = $this->format_wastes($obs);
                }else{
                    $observation = $this->format_especes($obs);
                }
                $observations[] = $observation;
            }
            return $observations;
        }
        return [];
    }

    public function format_wastes($obs)
    {
        // $waste = json_decode($obs['waste'], true);

        $waste = $obs['waste'];
        $return = [];

        $return['date'] = isset($obs['date']) ? $this->format_date($obs['date'],'date') : '-';
        $return['heure_debut'] = isset($waste['heure_debut']) ? $this->format_date($waste['heure_debut'],'hour') : '-';
        $return['heure_fin'] = isset($waste['heure_fin']) ? $this->format_date($waste['heure_fin'],'hour') : '-';

        // lat et long 
        $return['latitude_debut_deg_min_sec'] =  $this->get_location($waste['location'], 'latitude',true) ?? '';
        $return['latitude_debut_deg_dec'] =  $this->get_location($waste['location'], 'latitude',false) ?? '';
        $return['longitude_debut_deg_min_sec'] = $this->get_location($waste['location'], 'longitude',true) ?? '';
        $return['longitude_debut_deg_dec'] = $this->get_location($waste['location'], 'longitude',false) ?? '';

        $return['latitude_fin_deg_min_sec'] =  '-';
        $return['latitude_fin_deg_dec'] =  '-';
        $return['longitude_fin_deg_min_sec'] = '-';
        $return['longitude_fin_deg_dec'] = '-';

        // $matiere = json_decode($waste['matiere'], true);
        $matiere = $waste['matiere'];
        $return['common_name'] = isset($matiere['common_name']) ? $matiere['common_name'] : '-';
        $return['scientific_name'] = isset($matiere['scientific_name']) ? $matiere['scientific_name'] : '-';

        $return['estimated_size'] = isset($waste['estimated_size']) ? $waste['estimated_size'] : '-';

        $return['commentaires'] = isset($waste['commentaires']) ? $waste['commentaires'] : '-';
        $return['deche_peche'] = isset($waste['deche_peche']) && $waste['deche_peche'] == 1 ? 'Oui' : 'Non';
        $return['picked'] = isset($waste['picked']) && $waste['picked'] == 1 ? 'Oui' : 'Non';
        $return['color'] = isset($waste['color']) ? $waste['color'] : '-';
        $return['nature_deche'] = isset($waste['nature_deche']) ? $waste['nature_deche'] : '-';  
        $return['effort']  = isset($waste['effort']) && $waste['effort'] == 1 ? 'Oui' : 'Non';

        return $return;
        
    }

    public function get_location($location, $type,$deg_min_sec = true)
    {
        if(!$location){
            return '-';
        }

        // $location = json_decode($location[$type], true);
        $location = $location[$type];

        if($deg_min_sec){   
            return $location['deg_min_sec'];
        }else{
            return $location['deg_dec'];
        }

    }

    public function format_especes($obs)
    {
        $espece = null;
        if($obs['animal']!=null){
            // $espece = json_decode($obs['animal'], true);
            $espece = $obs['animal'];
        }else{
            // $espece = json_decode($obs['bird'], true);
            $espece = $obs['bird'];
        }
        // date
        $return['date'] = isset($obs['date']) ? $this->format_date($obs['date'],'date') : '-';

        // heure debut
        $return['heure_debut'] = isset($espece['heure_debut']) ? $this->format_date($espece['heure_debut'],'hour') : '-';
        $return['heure_fin'] = isset($espece['heure_fin']) ? $this->format_date($espece['heure_fin'],'hour') : '-';
       
        $return['latitude_debut_deg_min_sec'] =  $this->get_location($espece['location_d'], 'latitude',true);
        $return['latitude_debut_deg_dec'] =  $this->get_location($espece['location_d'], 'latitude',false);
        $return['longitude_debut_deg_min_sec'] = $this->get_location($espece['location_d'], 'longitude',true);
        $return['longitude_debut_deg_dec'] = $this->get_location($espece['location_d'], 'longitude',false);

        $return['latitude_fin_deg_min_sec'] =  $this->get_location($espece['location_f'], 'latitude',true);
        $return['latitude_fin_deg_dec'] =  $this->get_location($espece['location_f'], 'latitude',false);
        $return['longitude_fin_deg_min_sec'] = $this->get_location($espece['location_f'], 'longitude',true);
        $return['longitude_fin_deg_dec'] = $this->get_location($espece['location_f'], 'longitude',false);

        // $specie = json_decode($espece['espece'], true);
        $specie = $espece['espece'];
        $return['scientific_name'] = isset($specie['scientific_name']) ? $specie['scientific_name'] : '-';
        $return['common_name'] = isset($specie['common_name']) ? $specie['common_name'] : '-';
        $return['nbre_estime'] = isset($espece['nbre_estime']) ? $espece['nbre_estime'] : '-';
        $return['nbre_mini'] = isset($espece['nbre_mini']) ? $espece['nbre_mini'] : '-';
        $return['nbre_maxi'] = isset($espece['nbre_maxi']) ? $espece['nbre_maxi'] : '-';
        $return['nbre_adultes'] = isset($espece['nbre_adultes']) ? $espece['nbre_adultes'] : '-';
        $return['nbre_jeunes'] = isset($espece['nbre_jeunes']) ? $espece['nbre_jeunes'] : '-';
        $return['nbre_nouveau_ne'] = isset($espece['nbre_nouveau_ne']) ? $espece['nbre_nouveau_ne'] : '-';
        $return['gisement'] = isset($espece['gisement']) ? $espece['gisement'] : '-';
        $return['distance_estimee'] = isset($espece['distance_estimee']) ? $espece['distance_estimee'] : '-';
        $return['element_detection'] = isset($espece['element_detection']) ? $espece['element_detection'] : '-';
        $return['structure_groupe'] = isset($espece['structure_groupe']) ? $espece['structure_groupe'] : '-';
        $return['nbre_sous_groupes'] = isset($espece['nbre_sous_groupes']) ? $espece['nbre_sous_groupes'] : '-';
        $return['nbre_indiv_sous_groupe'] = isset($espece['nbre_indiv_sous_groupe']) ? $espece['nbre_indiv_sous_groupe'] : '-';
        $return['vitesse'] = isset($espece['vitesse']) ? $espece['vitesse'] : '-';
        $return['comportement_surface'] = isset($espece['comportement_surface']) ? $espece['comportement_surface'] : '-';
        $return['reaction_bateau'] = isset($espece['reaction_bateau']) ? $espece['reaction_bateau'] : '-';
        $return['especes_associees'] = isset($espece['especes_associees']) ? $espece['especes_associees'] : '-';
        $return['activites_humaines_associees'] = isset($espece['activites_humaines_associees']) ? $espece['activites_humaines_associees'] : '-';
        $return['activites_peche_associees'] = isset($espece['activites_peche_associees']) ? $espece['activites_peche_associees'] : '-';
        $return['donnees_recoltees'] = isset($espece['donnees_recoltees']) ? $espece['donnees_recoltees'] : '-';
        $return['autre'] = isset($espece['autre']) ? $espece['autre'] : '-';
        $return['commentaires'] = isset($espece['commentaires']) ? $espece['commentaires'] : '-';


        $return['sous_group'] = isset($espece['sous_group']) && $espece['sous_group'] == 1 ? 'Oui' : 'Non';

        $return['presence_jeune'] = isset($espece['presence_jeune']) && $espece['presence_jeune'] == 1 ? 'Oui' : 'Non';
        $return['etat_groupe'] = isset($espece['etat_groupe']) ? $espece['etat_groupe'] : '-';
        $return['comportement'] = isset($espece['comportement']) ? $espece['comportement'] : '-';



        // effort
        $return['effort'] = isset($espece['effort']) && $espece['effort'] == true ? 'Oui' : 'Non';

        return $return;
    }


    public function map($export): array
    {
        $data = json_decode($export->data, true);

        $sortie = $data['naturascan'];
        if (!$sortie) {
            $sortie = $data['obstrace'];
        }       
        
        $data = $sortie;

        
        // return [
            $data['structure'] = isset($data['structure']) ? $data['structure'] : null;
            $data['date'] = isset($data['date']) ? $this->format_date($data['date'],'date') : null;
            $data['port_depart'] = isset($data['port_depart']) ? $data['port_depart'] : null;
            $data['port_arrivee'] = isset($data['port_arrivee']) ? $data['port_arrivee'] : null;
            $data['heure_depart_port'] = isset($data['heure_depart_port']) ?  $this->format_date($data['heure_depart_port'],'hour') : null;
            $data['heure_arrivee_port'] = isset($data['heure_arrivee_port']) ?  $this->format_date($data['heure_arrivee_port'],'hour') : null;
            $data['duree_sortie'] = isset($data['duree_sortie']) ? $data['duree_sortie'] : null;
            $data['responsable'] = $this->formatPersons($data['responsable']);
            $data['skipper'] = $this->formatPersons($data['skipper']);
            $data['photographe'] = $this->formatPersons($data['photographe']);
            $data['observateurs'] = $this->formatPersons($data['observateurs']);
            $data['nbre_observateurs'] = isset($data['nbre_observateurs']) ? $data['nbre_observateurs'] : null;
            $data['type_bateau'] = isset($data['type_bateau']) ? $data['type_bateau'] : null;
            $data['nom_bateau'] = isset($data['nom_bateau']) ? $data['nom_bateau'] : null;
            $data['hauteur_bateau'] = isset($data['hauteur_bateau']) ? $data['hauteur_bateau'] : null;
            $data['heure_utc'] = isset($data['heure_utc']) ? $this->format_date($data['heure_utc'],'hour') : null;
            $data['distance_parcourue'] = isset($data['distance_parcourue']) ? $data['distance_parcourue'] : null;
            $data['superficie_echantillonnee'] = isset($data['superficie_echantillonnee']) ? $data['superficie_echantillonnee'] : null;
        // ];
        return $data;
    }


    public function formatPersons($personData)
    {
        if(!$personData){
            return '';
        }

        // $persons = json_decode($personData, true);
        $persons = $personData;
        $person = ''  ;
        foreach ($persons as $p) {
            $person .= $p['firstname'] . ' ' . $p['name'] . ', ';
        }
        return $person;
    }

    public function format_date($timestamp,$type = 'full',$fr = true)
    {
        // $timestamp = 1592808000000;  
        $seconds = $timestamp / 1000; // Convertir millisecondes en secondes
        if($type == 'full'){
            $date = date('d/m/Y H:i:s', $seconds);
            return $date;
        }
        if($type == 'date'){
            $date = date('d/m/Y', $seconds);
            return $date;
        }
        if($type == 'hour'){
            $date = date('H:i:s', $seconds);
            $add = $fr ? 7200 : 0;
            // convert date to GMT+2
            $date = date('H:i:s', strtotime($date) + $add);
            return $date;
        }
       
        return $date;
    }


    /**
     * @OA\Post(
     *     path="/api/exports",
     *     tags={"Export"},
     * security={{"sanctum": {}}},
     *     summary="Create a new export",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Export"),
     *     ),
     *     @OA\Response(response="201", description="Create a new export"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'string',
            'data' => 'string', 
            'data_export' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $uuid = $request->uuid;
        if(!$uuid){
            $uuid = time();
        }
        $user_id = auth()->user()->id;
        $request->merge(['user_id' => $user_id]);

        $export = Export::where('uuid', $uuid)->first();

        if($export){
            $export->update($request->all());
            return response()->json(['message' => 'Synchronisation effectué',"isUpdate"=>true], 200);    
        }

        $export = Export::create(
            [
                'uuid' => $uuid,
                'data' => $request->data,
                'data_export' => $request->data_export,
                'user_id' => auth()->user()->id
            ]
        );
        return response()->json(['message' => 'Synchronisation effectué'], 200);
        // return new ExportResource($export);
    }

    /**
     * @OA\Get(
     *     path="/api/exports/{id}",
     *     tags={"Export"},
     * security={{"sanctum": {}}},
     *     summary="Show export by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the export",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show export by ID"),
     *     @OA\Response(response="404", description="Export not found"),
     * )
     */
    public function show($id)
    {
        $export = Export::findOrFail($id);
        return new ExportResource($export);
    }

    /**
     * @OA\Put(
     *     path="/api/exports/{id}",
     *     tags={"Export"},
     * security={{"sanctum": {}}},
     *     summary="Update export by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the export",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Export"),
     *     ),
     *     @OA\Response(response="200", description="Update export by ID"),
     *     @OA\Response(response="404", description="Export not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $export = Export::findOrFail($id);
        $export->update($request->all());
        return new ExportResource($export);
    }

    /**
     * @OA\Delete(
     *     path="/api/exports/{id}",
     *     tags={"Export"},
     * security={{"sanctum": {}}},
     *     summary="Delete export by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the export",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Delete export by ID"),
     *     @OA\Response(response="404", description="Export not found"),
     * )
     */
    public function destroy($id)
    {
        $export = Export::findOrFail($id);
        $export->delete();
        return response()->json(null, 204);
    }

    
    public function observation_headers():array
    {
        return [
            'Date',
            'Début d\'observation',
            'Fin d\'observation',
            'Latitude en début d\'observation',
            'Longitude en début d\'observation',
            'Latitude en fin d\'observation',
            'Longitude en fin d\'observation',
            'Espèce/Déchets (nom scientifique)',
            'Espèce/Déchets (nom vernaculaire)',
            'Nombre Estimé',
            'Nombre Minimum',
            'Nombre Maximum',
            'Nombre d\adultes',
            'Nombre de jeunes',
            'Nombre de nouveau né',
            'Gisement',
            'Distance estimée',
            'Element de détection',
            'Structure du groupe',
            'Nombre de sous groupe',
            'Nombre d\'individus dans le sous groupe',
            'Vitesse nage',
            'Comportement surface',
            'Réaction au bateau',
            'Espèce associée',
            'Activité humaine associée',
            'Activité pêche associée',
            'Données recoltées',
            'Autre',
            'Commentaires',
        ];

    }
    
    
    
}
