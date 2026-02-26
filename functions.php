<?php
// Constante pour les bases valides [cite: 118]
const VALID_BASES = ['A', 'T', 'G', 'C'];

/**
 * Valide si la séquence ne contient que A, T, G, C [cite: 26, 121]
 */
function validateSequence($sequence) {
    $sequence = strtoupper(trim($sequence));
    if (empty($sequence)) return false;
    
    foreach (str_split($sequence) as $base) {
        if (!in_array($base, VALID_BASES)) return false;
    }
    return $sequence;
}

/**
 * Transcription : Remplace T par U [cite: 12, 31]
 */
function transcribeADN($sequence) {
    return str_replace('T', 'U', $sequence);
}

/**
 * Synthèse : Brin complémentaire [cite: 20, 29]
 */
function getComplementary($sequence) {
    $map = ['A' => 'T', 'T' => 'A', 'G' => 'C', 'C' => 'G'];
    $result = "";
    foreach (str_split($sequence) as $base) {
        $result .= $map[$base];
    }
    return $result;
}

/**
 * Mutation : Modifie aléatoirement une base [cite: 30, 97]
 */
function mutateSequence($sequence) {
    if (empty($sequence)) return $sequence;
    $arr = str_split($sequence);
    $index = array_rand($arr);
    $currentBase = $arr[$index];
    
    // Choisir une base différente de l'actuelle
    $possibleBases = array_diff(VALID_BASES, [$currentBase]);
    $arr[$index] = $possibleBases[array_rand($possibleBases)];
    
    return implode('', $arr);
}
?>