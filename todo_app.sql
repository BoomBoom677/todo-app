CREATE DATABASE IF NOT EXISTS todo_app;
USE todo_app;

CREATE TABLE IF NOT EXISTS taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    statut ENUM('a_faire', 'en_cours', 'termine') DEFAULT 'a_faire',
    priorite ENUM('basse', 'moyenne', 'haute') DEFAULT 'moyenne',
    date_limite DATE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO taches (titre, description, statut, priorite, date_limite)
VALUES
('Faire un barbec', 'Acheter des merguez et ne pas oublier le charbon', 'a_faire', 'haute', '2026-04-12'),
('Finir le mini projet', 'Créer la base de données et l’interface web', 'en_cours', 'haute', '2026-04-15'),
('Lire un livre', 'Apprendre à lire', 'termine', 'moyenne', '2026-04-09');

UPDATE taches
SET statut = 'en_cours',
    priorite = 'moyenne'
WHERE id = 1;

DELETE FROM taches
WHERE id = 3;

SELECT *
FROM taches
ORDER BY
    CASE priorite
        WHEN 'haute' THEN 1
        WHEN 'moyenne' THEN 2
        WHEN 'basse' THEN 3
    END,
    date_limite ASC;