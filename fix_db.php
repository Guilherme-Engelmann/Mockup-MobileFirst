<?php
include "html/db.php";


$result = $conn->query("SHOW COLUMNS FROM Trens LIKE 'idRota'");
if ($result->num_rows == 0) {
    
    $alter_query = "ALTER TABLE Trens ADD COLUMN idRota INT NULL";
    if ($conn->query($alter_query) === TRUE) {
        echo "Column idRota added successfully to Trens table.\n";
        
        $fk_query = "ALTER TABLE Trens ADD FOREIGN KEY (idRota) REFERENCES Rotas(idRota)";
        if ($conn->query($fk_query) === TRUE) {
            echo "Foreign key added successfully.\n";
        } else {
            echo "Error adding foreign key: " . $conn->error . "\n";
        }
    } else {
        echo "Error adding column: " . $conn->error . "\n";
    }
} else {
    echo "Column idRota already exists in Trens table.\n";
}

$conn->close();
?>
