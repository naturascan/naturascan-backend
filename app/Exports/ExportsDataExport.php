<?php

namespace App\Exports;

use App\Models\Export;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportsDataExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Export::all();
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

    public function headings(): array
    {
        return [
            'Structure',
            'Date',
            'Port_départ',
            'Port_arrivée',
            'Heure_départ_port',
            'Heure_arrivée_port',
            'Durée de la sortie',
            'Responsable',
            'Skipper',
            'Photographe',
            'Observateurs',
            'Nbre_observateurs',
            'Type_bateau',
            'Nom_bateau',
            'Hauteur_pont (m)',
            'Heure UTC',
            'Distance parcourue',
            'Superficie échantillonnée',
        ];
    }

  
}
