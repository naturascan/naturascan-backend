<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Export;


class TestExcel extends Command
{
    protected $signature = 'test:excel';
    protected $description = 'text excel file';

    public function handle()
    {
        $export = Export::find(4);

        $this->info("Start excel test");

        $data_observations = [];
        // foreach ($export as $e) {
        //     $data_observations[] = $this->map_observations($e);
        // }
        $data_observations = $this->map_observations($export);

        dd($data_observations);
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

   

    public function map_observations($export): array
    {

        $data = json_decode($export->data_export, true);

        $sortie = $data['naturascan'];
        if (!$sortie) {
            $sortie = $data['obstrace'];
        }   
        
        $data = $sortie;

        $data_observations = $data['observations'];  
         
        // dd($data_observations);
        $observations = [];
        foreach ($data_observations as $obs) {
            $observation = [];
            if($obs['waste']!='null'){
                $observation = $this->format_wastes($obs);
            }else{
                $observation = $this->format_especes($obs);
            }
            $observations[] = $observation;
        }
        // dd($observations);

        // dd($observations);
        return $observations;
    }

    public function format_wastes($obs)
    {
        $waste = json_decode($obs['waste'], true);
        $return = [];

        $return['date'] = isset($obs['date']) ? date('d/m/Y', $obs['date']) : '-';
        $return['heure_debut'] = isset($waste['heure_debut']) ? date('H:i', $waste['heure_debut']) : '-';
        $return['heure_fin'] = isset($waste['heure_fin']) ? date('H:i', $waste['heure_fin']) : '-';

        // lat et long 
        $return['latitude_debut_deg_min_sec'] =  $this->get_location($waste['location'], 'latitude',true);
        $return['latitude_debut_deg_dec'] =  $this->get_location($waste['location'], 'latitude',false);
        $return['longitude_debut_deg_min_sec'] = $this->get_location($waste['location'], 'longitude',true);
        $return['longitude_debut_deg_dec'] = $this->get_location($waste['location'], 'longitude',false);

        $return['latitude_fin_deg_min_sec'] =  '-';
        $return['latitude_fin_deg_dec'] =  '-';
        $return['longitude_fin_deg_min_sec'] = '-';
        $return['longitude_fin_deg_dec'] = '-';

        $matiere = json_decode($waste['matiere'], true);
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
        $location = json_decode($location, true);
        $location = json_decode($location[$type], true);
        if($deg_min_sec){   
            return $location['deg_min_sec'];
        }else{
            return $location['deg_dec'];
        }

    }

    public function format_especes($obs)
    {
        $espece = null;
        if($obs['animal']!='null'){
            $espece = json_decode($obs['animal'], true);
        }else{
            $espece = json_decode($obs['bird'], true);
        }
        dd($espece);
        // date
        $return['date'] = isset($obs['date']) ? date('d/m/Y', $obs['date']) : '-';

        // heure debut
        $return['heure_debut'] = isset($espece['heure_debut']) ? date('H:i', $espece['heure_debut']) : '-';
        $return['heure_fin'] = isset($espece['heure_fin']) ? date('H:i', $espece['heure_fin']) : '-';
       
        $return['latitude_debut_deg_min_sec'] =  $this->get_location($espece['location_d'], 'latitude',true);
        $return['latitude_debut_deg_dec'] =  $this->get_location($espece['location_d'], 'latitude',false);
        $return['longitude_debut_deg_min_sec'] = $this->get_location($espece['location_d'], 'longitude',true);
        $return['longitude_debut_deg_dec'] = $this->get_location($espece['location_d'], 'longitude',false);

        $return['latitude_fin_deg_min_sec'] =  $this->get_location($espece['location_f'], 'latitude',true);
        $return['latitude_fin_deg_dec'] =  $this->get_location($espece['location_f'], 'latitude',false);
        $return['longitude_fin_deg_min_sec'] = $this->get_location($espece['location_f'], 'longitude',true);
        $return['longitude_fin_deg_dec'] = $this->get_location($espece['location_f'], 'longitude',false);

        $specie = json_decode($espece['espece'], true);
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

        
        return [
            $data['structure'] ?? null,
            $data['date'] ?? null,
            $data['port_depart'] ?? null,
            $data['port_arrivee'] ?? null,
            $data['heure_depart_port'] ?? null,
            $data['heure_arrivee_port'] ?? null,
            $data['duree_sortie'] ?? null,
            $this->formatPersons($data['responsable']),
            $this->formatPersons($data['skipper']),
            $this->formatPersons($data['photographe']),
            $this->formatPersons($data['observateurs']),
            $data['nbre_observateurs'] ?? null,
            $data['type_bateau'] ?? null,
            $data['nom_bateau'] ?? null,
            $data['hauteur_bateau'] ?? null,
            $data['heure_utc'] ?? null,
            $data['distance_parcourue'] ?? null,
            $data['superficie_echantillonnee'] ?? null,
        ];
    }

    public function formatPersons($personData)
    {
        if(is_null($personData)){
            return '';
        }

        $persons = json_decode($personData, true);
        $person = ''  ;
        foreach ($persons as $p) {
            $person .= $p['firstname'] . ' ' . $p['name'] . ', ';
        }
        return $person;
    }

}