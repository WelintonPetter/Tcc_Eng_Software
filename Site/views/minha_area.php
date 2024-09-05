<?php
include('../models/conexao.php');
include('../models/protect.php');

// Verifica se o parâmetro de filtro foi enviado e o sanitiza
$filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : '';

// Monta a consulta SQL com base no filtro
$sql = "SELECT * FROM ordem_os WHERE status_os = 'Nao_atendida'";
if (!empty($filter)) {
    $sql .= " AND mantenedor_os LIKE '%$filter%'";
}

// Executa a consulta
$result = mysqli_query($conn, $sql);

$orders = array();
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

// Fecha a conexão
mysqli_close($conn);

// Exibe os dados no formato JSON
echo json_encode($orders);
?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Site/style.css">
    <title>ACOMPANHAR ANDAMENTO</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <div class="container-top">
                
                <li class="drop-hover">
                    <img src="../icon/avatar.png" alt="Foto de Perfil" class="avatar">

                    <a href="../models/logout.php">
                        <img src="../icon/log-out.svg" alt="Out" class="out">
                    </a> 
                    <a href="../views/home.php">
                        <img src="../icon/back.svg" alt="back" class="back">
                    </a>                           
                </li> 
                                       
        </header>
        <main>

            <div class="homeOrdem">
                <div class="button-container">
                    <button id="addOrderButton">Adicionar Ordem</button>
                    <button id="graphicButton">Gráficos</button>
                    <button id="userButton">Meus dados</button>
                </div>

                <div id="chartModal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <div class="modal-controls">
                            <select id="chartTypeSelector" class="chart-selector">
                                <option value="bar">Barra</option>
                                <option value="pie">Pizza</option>
                                <option value="line">Linha</option>
                                <option value="doughnut">Rosca</option>
                            </select>
                            <select id="dataTypeSelector" class="chart-selector">
                                <option value="orderType">Tipos de Ordem</option>
                                <option value="orderPriority">Criticidade da Ordem</option>
                                <option value="orderManutentor">Manutentor</option>
                                <option value="orderStage">Estágio das Ordens</option>
                            </select>
                        </div>
                        <canvas id="orderTypeChart"></canvas>
                    </div>
                </div>




                <div class="formulariOrdem">
                    <form id="orderForm" class="hidden">
                        <label for="orderTipo">Tipo De Ordem</label>
                        <select id="orderTipo" name="orderTipo" required>
                            <option value="Corretiva">CO</option>
                            <option value="CorretivaProgramada">CP</option>
                            <option value="Preventiva">PR</option>
                            <option value="Preditiva">PD</option>
                        </select>
                        <label for="orderDescription">Descrição da Ordem</label>
                        <textarea id="orderDescription" name="orderDescription" required></textarea>
                        <label for="orderMaquina">Maquina</label>
                        <select id="orderMaquina" name="orderMaquina" required>
                            <option value="Maquina1">01</option>
                            <option value="Maquina2">02</option>
                            <option value="Maquina3">03</option>
                            <option value="Maquina4">04</option>
                        </select>
                        <label for="orderPriority">Criticidade</label>
                        <select id="orderPriority" name="orderPriority" required>
                            <option value="Baixo">Baixo</option>
                            <option value="Médio">Médio</option>
                            <option value="Alto">Alto</option>
                            <option value="Crítico">Crítico</option>
                        </select>
                        <label for="orderManutentor">Manutentor</label>
                        <select id="orderManutentor" name="orderManutentor" required>
                            <option value="Manutentor1">Welinton</option>
                            <option value="Manutentor2">Welinton2</option>
                            <option value="Manutentor3">Welinton3</option>
                            <option value="Manutentor4">Welinton4</option>
                        </select>
                        <button type="submit">Criar Ordem</button>
                    </form>
                    <div id="searchFilter">
                        <input type="text" id="searchInput" placeholder="Pesquisar...">
                        <button id="searchButton">Buscar</button>
                    </div>
                    <div id="filterButtons">
                        <button id="filterLow">Baixo</button>
                        <button id="filterMedium">Médio</button>
                        <button id="filterHigh">Alto</button>
                        <button id="filterCritical">Crítico</button>
                        <button id="clearFilter">Limpar Filtro</button>
                    </div>
                </div>
                </div>
 

            <section class="colunas">
                <section class="coluna">
                    <h2 class="column__title" data-title="PARA FAZER">PARA FAZER (0)</h2>
                    <section class="column__cards" id="todoColumn"></section>
                </section>
                <section class="coluna">
                    <h2 class="column__title" data-title="EM ANDAMENTO">EM ANDAMENTO (0)</h2>
                    <section class="column__cards" id="inProgressColumn"></section>
                </section>
                <section class="coluna">
                    <h2 class="column__title" data-title="PARA REVER">PARA REVER (0)</h2>
                    <section class="column__cards" id="reviewColumn"></section>
                </section>
                <section class="coluna">
                    <h2 class="column__title" data-title="FINALIZADO">FINALIZADO (0)</h2>
                    <section class="column__cards" id="doneColumn"></section>
                </section>
            </section>
                
        </main>
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
<script src="/site/js/script.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: '/site/views/minha_area.php', // Substitua pelo nome do seu arquivo PHP
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(order) {
                const card = createCard(order); // Cria o card com os dados da ordem
                // Adiciona o cartão à coluna correta com base no campo status
                switch (order.status) { 
                    case 'Para Fazer':
                        $('#todoColumn').append(card);
                        break;
                    case 'Em Andamento':
                        $('#inProgressColumn').append(card);
                        break;
                    case 'Para Rever':
                        $('#reviewColumn').append(card);
                        break;
                    case 'Finalizado':
                        $('#doneColumn').append(card);
                        break;
                    default:
                        console.warn('Status desconhecido para o cartão:', order.status);
                }
            });
            updateOrderCount(); // Atualiza a contagem de cartões por coluna
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Erro ao carregar os dados: ', textStatus, errorThrown);
        }
    });
});


const getCircleColor = (priority) => {
    switch (priority) {
        case 'Baixo':
            return '#34d399';
        case 'Médio':
            return '#60a5fa';
        case 'Alto':
            return '#fbbf24';
        case 'Crítico':
            return '#d946ef';
        default:
            return '#ced4da';
    }
};

// Outras funções como `updateOrderCount`, `dragStart`, `dragEnd`, etc., permanecem as mesmas.

</script>


</body>
</html>
