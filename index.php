<?php 
require_once 'functions.php';
session_start(); // Pour le "Carnet de laboratoire" [cite: 44]

$resultat = "";
$erreur = "";
$input = $_POST['sequence'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validSeq = validateSequence($input);
    
    if (!$validSeq) {
        $erreur = "Veuillez entrer une séquence valide (A, T, G, C)."; [cite: 42, 122]
    } else {
        $action = $_POST['action'];
        switch ($action) {
            case 'transcribe': $resultat = transcribeADN($validSeq); break;
            case 'synthese': $resultat = getComplementary($validSeq); break;
            case 'mutate': $resultat = mutateSequence($validSeq); break;
        }
        // Sauvegarde bonus [cite: 43, 98]
        $_SESSION['history'][] = $resultat;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>LabGenius - Simulateur</title>
</head>
<body class="lab-theme">
    <header>
        <h1>LAB<span class="neon">GENIUS</span></h1>
        <p>Station de Manipulation Génétique</p>
    </header>

    <main class="container">
        <section class="terminal">
            <form method="POST">
                <label>Séquence d'ADN :</label>
                <input type="text" name="sequence" value="<?= htmlspecialchars($input) ?>" placeholder="Ex: ATGC...">
                
                <div class="actions">
                    <button type="submit" name="action" value="synthese">Synthèse</button>
                    <button type="submit" name="action" value="mutate">Mutation</button>
                    <button type="submit" name="action" value="transcribe">Transcription</button>
                </div>
            </form>

            <?php if ($erreur): ?>
                <div class="error-msg"><?= $erreur ?></div>
            <?php endif; ?>

            <?php if ($resultat): ?>
                <div class="output-box">
                    <h3>Résultat :</h3>
                    <div class="dna-display">
                        <?php 
                        [cite_start]// Coloration des bases [cite: 34, 80]
                        foreach (str_split($resultat) as $b) {
                            echo "<span class='base base-$b'>$b</span>";
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>