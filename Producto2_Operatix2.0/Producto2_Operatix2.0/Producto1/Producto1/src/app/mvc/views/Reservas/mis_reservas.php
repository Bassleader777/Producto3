<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5fdfc;
            padding: 2rem;
        }

        h2 {
            color: #2c7a7b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-top: 1rem;
        }

        th, td {
            padding: 0.75rem;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #319795;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f0fdfa;
        }

        .no-reservas {
            padding: 1rem;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            margin-top: 1rem;
        }

        a {
            display: inline-block;
            margin-top: 1rem;
            color: #319795;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Mis Reservas</h2>

    <?php if (empty($reservas)): ?>
        <div class="no-reservas">No tienes reservas disponibles.</div>
    <?php else: ?>
        <table>
            <tr>
                <th>Localizador</th>
                <th>Fecha de Entrada</th>
                <th>Hora Entrada</th>
                <th>Nº Viajeros</th>
                <th>Destino</th>
            </tr>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= htmlspecialchars($reserva->getLocalizador()) ?></td>
                    <td><?= htmlspecialchars($reserva->getFechaEntrada()) ?></td>
                    <td><?= htmlspecialchars($reserva->getHoraEntrada()) ?></td>
                    <td><?= htmlspecialchars($reserva->getNumViajeros()) ?></td>
                    <td><?= htmlspecialchars($reserva->getIdDestino()) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <a href="/cliente/home">← Volver al Panel del Usuario</a>
</body>
</html>
