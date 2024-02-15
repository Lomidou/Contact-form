<?php
require_once("./db.inc.php"); 

$pdo = connect_db();

if ($pdo) {
    $query = "SELECT * FROM contacts";
    $stmt = $pdo->query($query);

    if ($stmt) {
        if ($stmt->rowCount() > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Photo</th>
                    </tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['nom']}</td>
                        <td>{$row['prenom']}</td>
                        <td>{$row['mail']}</td>
                        <td>{$row['description']}</td>
                        <td><img src='{$row['photo']}' alt='Photo' style='max-width: 100px; max-height: 100px;'></td>
                    </tr>";
            }
            echo "</table>";
        } else {

            echo "Aucune donnée trouvée dans la table des contacts.";
        }
    } else {

        echo "Erreur lors de l'exécution de la requête : " . $pdo->errorInfo()[2];
    }
} else {

    echo "Erreur lors de la connexion à la base de données.";
}
?>