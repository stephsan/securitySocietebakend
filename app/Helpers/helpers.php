<?php

use App\Models\Valeur;

use Illuminate\Support\Facades\Storage;

if (!function_exists('getlibelle')) {
    function getlibelle($id)
    {
        $record = Valeur::where('id', $id)->first();
        $libelle = isset($record['libelle']) ? $record['libelle'] : "";
        return $libelle;
    }
}

if (!function_exists('format_date')) {
            function format_date($date)
             {
    
                 return  date('d-m-Y', strtotime($date));
             }
    }
// if (!function_exists('getrepresentationmembre')) {
//     function getrepresentationmembre($id)
//     {
//         $record = User::where('id', $id)->first();
//         $structure_represente = isset($record['structure_represente']) ? $record['structure_represente'] : "";
//         return getlibelle($structure_represente);
//     }
// }
// if (!function_exists('getnombrededecisiondesmembreducomitedelentreprise')) {
//     function getnombrededecisiondesmembreducomitedelentreprise($id)
//     {
//         $record = Decision::where('entreprise_id', $id)->get();
//         return count($record);
//     }
// }
// if (!function_exists('reformater_montant')) {
//     function reformater_montant($montant)
//     {
//         return str_replace(",", "", $montant);
//     }
// }
// if (!function_exists('reformater_montant2')) {
//     function reformater_montant2($money)
//     {
//         $money = str_replace('F CFA', '', strval($money));
//         $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
//         $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);
//         $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;
//         $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
//         $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);
//         return (int) str_replace(',', '.', $removedThousandSeparator);
//     }
// }
// if (!function_exists('getusername')) {
//     function getusername($id)
//     {
//         $record = User::where('id', $id)->first();
//         $nom_utilisateur = isset($record['name']) ? $record['name'] . ' ' . $record['prenom'] : "";
//         return $nom_utilisateur;
//     }
// }
// if (!function_exists('calculer_age')) {
//     function calculer_age($date)
//     {
//         $format = substr($date, 0, 4) . "-" . substr($date, 5, 7) . "-" . substr($date, 8, 10);
//         $date = $format;
//         $dob = new DateTime($date);
//         $now = new DateTime();
//         return $now->diff($dob)->y;
//     }
// }
// if (!function_exists('entreprise_isFormalise')) {
//     function entreprise_isFormalise($entreprise_id)
//     {
//         $entreprise = Entreprise::find($entreprise_id);
//         if ($entreprise->formalise == 1) {
//             return true;
//         } else {
//             return false;
//         }
//     }
// }

if (!function_exists('int2str')) {
    function int2str($a)
    {
        $convert = explode('.', $a);
        if (isset($convert[1]) && $convert[1] != '') {
            return int2str($convert[0]) . 'Dinars' . ' et ' . int2str($convert[1]) . 'Centimes';
        }
        if ($a < 0) return 'moins ' . int2str(-$a);
        if ($a < 17) {
            switch ($a) {
                case 0:
                    return '';
                case 1:
                    return 'un';
                case 2:
                    return 'deux';
                case 3:
                    return 'trois';
                case 4:
                    return 'quatre';
                case 5:
                    return 'cinq';
                case 6:
                    return 'six';
                case 7:
                    return 'sept';
                case 8:
                    return 'huit';
                case 9:
                    return 'neuf';
                case 10:
                    return 'dix';
                case 11:
                    return 'onze';
                case 12:
                    return 'douze';
                case 13:
                    return 'treize';
                case 14:
                    return 'quatorze';
                case 15:
                    return 'quinze';
                case 16:
                    return 'seize';
            }
        } else if ($a < 20) {
            return 'dix-' . int2str($a - 10);
        } else if ($a < 100) {
            if ($a % 10 == 0) {
                switch ($a) {
                    case 20:
                        return 'vingt';
                    case 30:
                        return 'trente';
                    case 40:
                        return 'quarante';
                    case 50:
                        return 'cinquante';
                    case 60:
                        return 'soixante';
                    case 70:
                        return 'soixante-dix';
                    case 80:
                        return 'quatre-vingt';
                    case 90:
                        return 'quatre-vingt-dix';
                }
            } elseif (substr($a, -1) == 1) {
                if (((int)($a / 10) * 10) < 70) {
                    return int2str((int)($a / 10) * 10) . '-et-un';
                } elseif ($a == 71) {
                    return 'soixante-et-onze';
                } elseif ($a == 81) {
                    return 'quatre-vingt-un';
                } elseif ($a == 91) {
                    return 'quatre-vingt-onze';
                }
            } elseif ($a < 70) {
                return int2str($a - $a % 10) . '-' . int2str($a % 10);
            } elseif ($a < 80) {
                return int2str(60) . '-' . int2str($a % 20);
            } else {
                return int2str(80) . '-' . int2str($a % 20);
            }
        } else if ($a == 100) {
            return 'cent';
        } else if ($a < 200) {
            return int2str(100) . ' ' . int2str($a % 100);
        } else if ($a < 1000) {
            return int2str((int)($a / 100)) . ' ' . int2str(100) . ' ' . int2str($a % 100);
        } else if ($a == 1000) {
            return 'mille';
        } else if ($a < 2000) {
            return int2str(1000) . ' ' . int2str($a % 1000) . ' ';
        } else if ($a < 1000000) {
            return int2str((int)($a / 1000)) . ' ' . int2str(1000) . ' ' . int2str($a % 1000);
        } else if ($a == 1000000) {
            return 'millions';
        } else if ($a < 2000000) {
            return int2str(1000000) . ' ' . int2str($a % 1000000) . ' ';
        } else if ($a < 1000000000) {
            return int2str((int)($a / 1000000)) . ' ' . int2str(1000000) . ' ' . int2str($a % 1000000);
        } else if ($a == 1000000000) {
            return 'milliard';
        } else if ($a < 2000000000) {
            return int2str(1000000) . ' ' . int2str($a % 1000000) . ' ';
        }
    }
}

